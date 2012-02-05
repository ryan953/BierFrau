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
        debug('Traversing search DOM for brands')
        soup = self.getDom()
        brands = soup.findAll(attrs='node-brand')
        info = []
        for brand in brands:
            a = brand.find('a').extract()
            info.append( DetailsPage('http://www.thebeerstore.ca' + a['href'], self._cacheDir) )
        return info

class DetailsPage(HTMLPage):
    def getInfoTuple(self):
        log('Getting Details Info Tuple')
        soup = self.getDom()
        node = soup.find('div', 'node')
        detail_soup = node.find('div', 'brand-details')
        values = self._getAttrs(copy.deepcopy(detail_soup))
        return {
            'url': self.url,
            'name': self._getName(detail_soup),
            'desc': self._getDesc(detail_soup),
            'imgSrc': self._getImageSrc(node),
            'categories': values[0].split(','),
            'type': values[1],
            'styles': [style.strip() for style in values[2].split(',')],
            'country': values[3],
            'brewer': values[4],
            'alcohol': values[5],
            'prices': self._getPrices(node)
        }
        
    def _getName(self, soup):
        return soup.find('h3', 'beer-name').string
        
    def _getDesc(self, soup):
        try:
            return soup.find('p').string
        except:
            return ''
    
    def _getAttrs(self, soup):
        h3 = soup.find('h3')
        h3.extract()
        spans = soup.findAll('span')
        [span.extract() for span in spans]
        div = soup.find('div', 'beer-desc')
        div.extract()
        text = str(soup.renderContents().strip())
        return [a.strip().title() for a in text.split("<br />")]
        
    def _getImageSrc(self, node):
        img_soup = node.find('div', 'brand-image')
        img = img_soup.find('img')
        return img['src']
        
    def _getPrices(self, node):
        prices = node.find('div', attrs={'id':'tab-prices'})
        allTr = prices.findAll('tr')
        rows = []
        for tr in allTr:
            cols = [str(col.string).strip() for col in tr.findAll('td')]
            if len(cols):
                rows.append({
                    'package':self._parsePackage(cols[0]),
                    'price':cols[1].replace('$', ''),
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
        parts = package.split(' ')
        return {
            'name':"{0} ({1}{2})".format(parts[1], parts[2], parts[3]),
            'volume_amount':parts[2],
            'volume_unit':parts[3]
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
        for i,page in list(enumerate(self.detailsPages())):
            page.updateCache()
            print "%d/%d done." % (i+1, total)

    def listPageInfo(self):
        pages = self.detailsPages()
        
        info = []
        for i in range(1, 10):
            info.append(pages[i].getInfoTuple())
        #info = [page.getInfoTuple() for page in pages]

        return info

    def parse(self):
        info_list = self.listPageInfo()

        prices = [brand['prices'] for brand in info_list]
        data = {
            'categories': self.flattenField('categories', info_list),
            'types': [brand['type'] for brand in info_list],
            'styles': self.flattenField('styles', info_list),
            'countries': [brand['country'] for brand in info_list],
            'brewers': [brand['brewer'] for brand in info_list],
            #'prices': prices,
            #'packages': [price[0]['package'] for price in prices],
            'containers': [price[0]['package']['container'] for price in prices]
        }
        return self.uniqueData(data)


        