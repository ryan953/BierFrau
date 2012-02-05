from debug import *
import MySQLdb

from BeerStore import Parser as BeerStoreParser

settings = {
    'debugging':True,
    'logging':True,
    'errors':True,
    'cacheDir':'./cache/',
    'searchUrl':"http://www.thebeerstore.ca/beers/search/advanced?brand=All&type=All&sub_type=All&country=All&brewer=All&title_1=",
    'database': {
        'host': 'mysql.ryan953.com',
        'user': 'app_access',
        'passwd': 'j85x7Tug',
        'db': 'com_ryan953_beerprice',
    }
}

class DataSaver(object):
    def __init__(self, dbConf):
        db = MySQLdb.connect(**dbConf)
        self.cursor = db.cursor()
    
    def saveBrandData(self, data):
        '''c.executemany
        id = 8
        rows = c.execute("""DELETE FROM types WHERE id = %s""", (id, ))
        debug(rows)
        rows = c.execute("""SELECT * FROM types WHERE 1=1""")
        debug(rows)

        #debug(c.fetchall())
        '''
        pass

class DataImporter(object):
    def scrape(self):
        parser = BeerStoreParser(update=False, 
            searchUrl=settings['searchUrl'], 
            cacheDir=settings['cacheDir'])

        parsed = parser.parse()
        debug(parsed)

        saver = DataSaver(settings['database'])

if __name__ == "__main__":
    importer = DataImporter()
    importer.scrape()