import sys
import copy
import urllib2
import hashlib
from BeautifulSoup import BeautifulSoup, SoupStrainer

settings = {
    'debugging':True,
    'logging':True,
    'errors':True,
    'cacheDir':'./cache/',
    'searchUrl':"http://www.thebeerstore.ca/beers/search/advanced?brand=All&type=All&sub_type=All&country=All&brewer=All&title_1="
}

def debug(msg):
    if settings['debugging']: 
        print msg
    
def log(msg):
    if settings['logging']:
        print msg

class PageDownloader(object):
    def __init__(self, url, filename):
        self.url = url
        self.filename = filename
    
    def download(self):
        sys.stdout.write('Downloading: %s\n' % (self.url))
        remote = urllib2.urlopen(self.url)
        data = self.chunk_read(remote, report_hook=self.chunk_report)
        self.local = open(self.filename, 'w')
        self.local.write(data)
        self.local.close()
        sys.stdout.write('Saved To: %s\n\n' % (self.filename))
    
    def chunk_report(self, bytes_so_far, chunk_size, total_size):
        percent = 0 if total_size == 0 else float(bytes_so_far) / total_size
        sys.stdout.write("Downloaded %d of %d bytes (%0.2f%%)\r" % 
            (bytes_so_far, total_size, percent*100))
        
        if bytes_so_far >= total_size:
            sys.stdout.write('\n')
    
    def chunk_read(self, response, chunk_size=4096, report_hook=None):
        try:
            total_size = response.info().getheader('Content-Length').strip()
            total_size = int(total_size)
        except AttributeError:
            total_size = 0;
            
        bytes_so_far = 0
        data = []
        
        while 1:
            chunk = response.read(chunk_size)
            bytes_so_far += len(chunk)
            
            if not chunk:
                break
            
            data += chunk
            if report_hook:
                report_hook(bytes_so_far, chunk_size, total_size)
            
        return "".join(data)

class HTMLPage(object):
    def __init__(self, url):
        self.url = url
        self.parseOnly = SoupStrainer('body')
    
    def __str__(self):
        return self.url
    
    def cachedFilename(self):
        m = hashlib.md5()
        m.update(self.url)
        return settings['cacheDir'] + m.hexdigest()
    
    def updateCache(self):
        PageDownloader(self.url, self.cachedFilename()).download()
    
    def getHtml(self):
        # check that the file exists first?
        try:
            return open(self.cachedFilename(), 'r')
        except IOError as e:
            print("({})".format(e))
            return ''
        
    def getDom(self):
        return BeautifulSoup(self.getHtml(), parseOnlyThese=self.parseOnly)
    
class SearchResultsPage(HTMLPage):
    def __init__(self, url):
        super(SearchResultsPage, self).__init__(self, url)
        self.parseOnly = SoupStrainer('div', 'view-brands')
    
    def getMoreInfo(self):
        debug('Traversing search DOM for brands')
        soup = self.getDom()
        brands = soup.findAll(attrs='node-brand')
        info = []
        for brand in brands:
            a = brand.find('a').extract()
            info.append( DetailsPage('http://www.thebeerstore.ca' + a['href']) )
        return info
    
class DetailsPage(HTMLPage):
    def getInfoTuple(self):
        soup = self.getDom()
        node = soup.find('div', 'node')
        detail_soup = node.find('div', 'brand-details')
        values = self.getAttrs(copy.deepcopy(detail_soup))
        return {
            'name': self.getName(detail_soup),
            'desc': self.getDesc(detail_soup),
            'imgSrc': self.getImageSrc(node),
            'categories': values[0].split(','),
            'type': values[1],
            'styles': values[2].split(','),
            'country': values[3],
            'brewer': values[4],
            'alcohol': values[5],
            'prices': self.getPrices(node)
        }
        
    def getName(self, soup):
        return soup.find('h3', 'beer-name').string
        
    def getDesc(self, soup):
        return soup.find('p').string
    
    def getAttrs(self, soup):
        h3 = soup.find('h3')
        h3.extract()
        spans = soup.findAll('span')
        [span.extract() for span in spans]
        div = soup.find('div', 'beer-desc')
        div.extract()
        text = str(soup.renderContents().strip())
        return [a.strip().title() for a in text.split("<br />")]
        
    def getImageSrc(self, node):
        img_soup = node.find('div', 'brand-image')
        img = img_soup.find('img')
        return img['src']
        
    def getPrices(self, node):
        prices = node.find('div', attrs={'id':'tab-prices'})
        allTr = prices.findAll('tr')
        rows = []
        for tr in allTr:
            cols = [str(col.string).strip() for col in tr.findAll('td')]
            if len(cols):
                rows.append({
                    'package':self.parsePackage(cols[0]),
                    'price':cols[1].replace('$', ''),
                })
        return rows
        
    def parseContainer(self, package):
        parts = package.split(' ')
        return {
            'name':"{0} ({1}{2})".format(parts[1], parts[2], parts[3]),
            'volume_amount':parts[2],
            'volume_unit':parts[3]
        }
        
    def parsePackage(self, package):
        parts = package.split(' ')
        container = self.parseContainer(package)
        return {
            'name':parts[0] + ' ' + container['name'],
            #'name':parts[2],
            'quantity':parts[0],
            'container':container
        }
        
class DataImporter(object):
    def __init__(self):
        self._searchPage = None
        
    def getSearchPage(self):
        if self._searchPage is None:
            self._searchPage = SearchResultsPage(settings['searchUrl'])
        return self._searchPage
        
    def getDetailsPages(self):
        return self.getSearchPage().getMoreInfo()
        
    def updateCaches(self):
        self.getSearchPage().updateCache()
        pages = self.getDetailsPages()
        total = len(pages)
        for i,page in list(enumerate(pages)):
            page.updateCache()
            print "%d/%d done." % (i+1, total)
        
importer = DataImporter()

#importer.getSearchPage().updateCache()
#importer.updateCaches()

#pages = importer.getDetailsPages()
#for page in pages:
#    print page.__str__()

steamWhistle = DetailsPage('http://www.thebeerstore.ca/beers/steam-whistle')
print steamWhistle.getInfoTuple()
