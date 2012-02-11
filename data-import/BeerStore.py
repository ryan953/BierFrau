from debug import *
import copy

from BeautifulSoup import SoupStrainer

from Pages import HTMLPage
from BierFrau import ListParser

class SearchResultsPage(HTMLPage):
    def __init__(self, url, cacheDir):
        super(SearchResultsPage, self).__init__(url, cacheDir)
        self.parseOnly = SoupStrainer('div', 'view-brands')

    def getDetailsPages(self):
        debug('Traversing search DOM for brands from %s' % (self.url,))
        soup = self.getDom()
        brands = soup.findAll(attrs='node-brand')
        info = []
        for brand in brands:
            a = brand.find('a').extract()
            info.append( DetailsPage('http://www.thebeerstore.ca' + a['href'], self._cacheDir) )
        return info

class DetailsPage(HTMLPage):
    def getInfoTuple(self):
        log('Getting Details Info Tuple for %s' % (self.url,))
        soup = self.getDom()
        node = soup.find('div', 'node')
        detail_soup = node.find('div', 'brand-details')
        name = self._extractName(detail_soup)
        description = self._extractDesc(detail_soup)
        values = self._getAttrs(detail_soup)
        return {
            'url': self.url,
            'cachedFilename': self.cachedFilename(),
            'name': name,
            'desc': description,
            'imgSrc': self._getImageSrc(node),
            'categories': [cat.strip() for cat in values['category'].split(',')],
            'styles': [style.strip() for style in values['style'].split(',')],
            'type': values['type'],
            'country': values['country'],
            'brewer': values['brewer'],
            'alcohol': values['alcohol content (abv)'].replace('%', ''),
            'prices': self._getPrices(name, node)
        }

    def _extractName(self, soup):
        try:
            return soup.find('h3', 'beer-name').extract().text
        except:
            debug('Brand Name not found')
            return ''

    def _extractDesc(self, soup):
        try:
            return soup.find('div', 'beer-desc').extract().text
        except:
            debug('Description not found')
            return ''

    def _getAttrs(self, soup):
        try:
            soup.find('span', 'label-heading').extract()
        except:
            debug('Unable to remove .label-heading')

        values = soup.renderContents() \
            .replace('<span class="label-heading">Some things about me:</span>', '') \
            .strip().split('<br />')

        attrs = {
            'category': '',
            'style': '',
            'type': '',
            'country': '',
            'brewer': '',
            'alcohol content (abv)': ''
        }
        for pair in values:
            if pair == '':
                continue

            try:
                key, value = pair.replace('<span class="label">', '').split('</span>')
                key = key.replace(':', '').strip().lower()
                value = value.strip().title()
                attrs[key] = value
            except:
                debug('Problem extracting key from: %s in %s' % (pair, values))
        return attrs

    def _getImageSrc(self, node):
        img_soup = node.find('div', 'brand-image')
        img = img_soup.find('img')
        return img['src']

    def _getPrices(self, name, node):
        prices = node.find('div', attrs={'id':'tab-prices'})
        allTr = prices.findAll('tr')
        rows = []
        for tr in allTr:
            cols = [str(col.string).strip() for col in tr.findAll('td')]
            if len(cols):
                rows.append({
                    'brand': name,
                    'price': cols[1].replace('$', ''),
                    'package': self._parsePackage(cols[0]),
                })
        return rows

    def _parsePackage(self, package):
        parts = package.split(' ')
        container = self._parseContainer(package)
        return {
            'name':parts[0] + ' ' + container['name'],
            #'name':parts[2],
            'quantity':parts[0],
            'container':container
        }

    def _parseContainer(self, package):
        c, ctr_type, ctr_amount, ctr_unit = package.split(' ')
        return {
            'name':"%s (%d%s)" % (ctr_type, int(ctr_amount), ctr_unit),
            'volume_amount':ctr_amount,
            'volume_unit':ctr_unit
        }

class Parser(ListParser):
    def __init__(self, update=False, searchUrl='', cacheDir='/tmp'):
        self._searchPage = SearchResultsPage(searchUrl, cacheDir)
        self._detailsPages = None
        if (update):
            self.updateAll()

    def searchPage(self):
        return self._searchPage

    def detailsPages(self):
        if self._detailsPages is None:
            self._detailsPages = self.searchPage().getDetailsPages()
        return self._detailsPages

    def updateAll(self):
        log("Updating All Caches")
        self.searchPage().updateCache()
        total = len(self.detailsPages())

        pages = self.detailsPages()
        for i,page in list(enumerate(pages)):
            page.updateCache()
            print "%d/%d done." % (i+1, total)

    def listPageInfo(self):
        pages = self.detailsPages()
        return [page.getInfoTuple() for page in pages]

    def parse(self):
        info_list = self.listPageInfo()
        prices = [brand['prices'] for brand in info_list]

        containers = []
        packages = []
        for brand in prices:
            for package in brand:
                containers.append(package['package']['container'])
                packages.append(package['package'])

        data = {
            'categories': self.flattenField('categories', info_list),
            'types': [brand['type'] for brand in info_list],
            'styles': self.flattenField('styles', info_list),
            'countries': [brand['country'] for brand in info_list],
            'brewers': [brand['brewer'] for brand in info_list],
            'brands': info_list,
            'containers': containers,
            'packages': packages,
            'prices': prices,
        }
        return self.uniqueData(data)
