from debug import *
import sys
import urllib2
import hashlib

from BeautifulSoup import BeautifulSoup, SoupStrainer

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
    def __init__(self, url, cacheDir):
        self.url = url
        self._cacheDir = cacheDir
        self.parseOnly = SoupStrainer('body')
    
    def __str__(self):
        return self.url
    
    def cachedFilename(self):
        md5 = hashlib.md5()
        md5.update(self.url)
        return self._cacheDir + md5.hexdigest()
    
    def updateCache(self):
        PageDownloader(self.url, self.cachedFilename()).download()
    
    def getHtml(self):
        try:
            return open(self.cachedFilename(), 'r')
        except IOError as e:
            print("({})".format(e))
            return ''
        
    def getDom(self):
        return BeautifulSoup(self.getHtml(), parseOnlyThese=self.parseOnly)
    