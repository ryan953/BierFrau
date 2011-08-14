import sys
import urllib2
import hashlib
from BeautifulSoup import BeautifulSoup

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
        return BeautifulSoup(self.getHtml())
    
class SearchResultsPage(HTMLPage):
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
        #print soup
        return {
            'name':self.getName(soup),
            'desc':self.getDesc(soup)
        }
        
        
    def getName(self, soup):
        return soup.h3('beer-name', text=True, limit=1)[0]
        
    def getDesc(self, soup):
        return soup.div('beer-desc').p(text=True, limit=1)[0]

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
