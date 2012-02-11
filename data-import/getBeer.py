from debug import *

import argparse
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
        self.cache = {}

    def save(self, data):
        for dataType in data:
            methodName = 'save'+dataType.capitalize()
            try:
                method = getattr(self, methodName)
            except:
                debug('Count not find: %s' % methodName)
                continue
            method(data[dataType])

    def _defaultSaver(self, table, values):
        self._saveMany(table=table, values=values)
        self._cacheStatics(table=table)

    def _saveMany(self, table, fields=['name'], values=[]):
        f = ", ".join(fields)
        v = ", ".join(["%s"] * len(fields))
        insert = '''INSERT IGNORE INTO %s (%s) VALUES (%s)''' % (table, f, v)
        rows = self.cursor.executemany(insert,  values)
        debug("Inserted %s rows into %s" % (rows, table))

    def _cacheStatics(self, table, unique='id', search='name'):
        if search is None:
            search = table

        select = '''SELECT %s, %s FROM %s''' % (unique, search, table)
        self.cursor.execute(select)
        rows = self.cursor.fetchall()
        self.cache[table] = {}
        for row in rows:
            key = row[1].upper()
            self.cache[table][key] = row[0]
        debug('''Cached: %s''' % (table,))

class BeerSaver(DataSaver):
    def save(self, data):
        brands = data['brands']
        packages = data['packages']
        prices = data['prices']
        del data['brands']
        del data['packages']
        del data['prices']

        DataSaver.save(self, data)
        self.saveBrands(brands)
        self.savePackages(packages)
        self.savePrices(prices)

    def saveCategories(self, values):
        self._defaultSaver('categories', values)

    def saveTypes(self, values):
        self._defaultSaver('types', values)

    def saveStyles(self, values):
        self._defaultSaver('styles', values)

    def saveCountries(self, values):
        self._defaultSaver('countries', values)

    def saveBrewers(self, values):
        self._defaultSaver('brewers', values)

    def saveContainers(self, containers):
        table = 'containers'
        fields = ['name','volume_unit','volume_amount']
        values = [(c['name'], c['volume_unit'], c['volume_amount']) for c in containers]
        self._saveMany(table=table, fields=fields, values=values)
        self._cacheStatics(table=table)

    def saveBrands(self, brands):
        if 'brewers' not in self.cache or 'types' not in self.cache:
            debug('Need Brewers to save Brands')
            return

        for brand in brands:
            typeName = brand['type'].upper()
            brewer = brand['brewer'].upper()
            brand['typeid'] = self.cache['types'][typeName]
            brand['brewerid'] = self.cache['brewers'][brewer]

        table = 'brands'
        fields = ['name', 'percent', 'year', 'type_id', 'brewer_id']
        values = [(b['name'], b['alcohol'], 0, b['typeid'], b['brewerid']) for b in brands]
        self._saveMany(table=table, fields=fields, values=values)
        self._cacheStatics(table=table)

    def savePackages(self, packages):
        if 'containers' not in self.cache:
            debug('Need Contaners to save Packages')
            return

        for package in packages:
            containerName = package['container']['name'].upper()
            package['containerid'] = self.cache['containers'][containerName]

        table = 'packages'
        fields = ['name', 'quantity', 'container_id']
        values = [(p['name'], p['quantity'], p['containerid']) for p in packages]
        self._saveMany(table=table, fields=fields, values=values)
        self._cacheStatics(table=table)

    def savePrices(self, prices):
        if 'brands' not in self.cache or 'packages' not in self.cache:
            debug('Need Brands and Pacakges to save Prices')
            return

        values = []
        for brand in prices:
            for price in brand:
                brandName = price['brand'].upper()
                packageName = price['package']['name'].upper()
                price['brandid'] = self.cache['brands'][brandName]
                price['packageid'] = self.cache['packages'][packageName]
            values.append((price['price'], price['brandid'], price['packageid'], 0))

        table = 'prices'
        fields = ['amount', 'brand_id', 'package_id', 'location_id']
        self._saveMany(table=table, fields=fields, values=values)

class DataImporter(object):
    def scrape(self, args):
        debug(args)
        if args.parse:
            parser = BeerStoreParser(update=args.update, 
                searchUrl=settings['searchUrl'], 
                cacheDir=settings['cacheDir'])
            parsed = parser.parse()
            debug('Data parsed')

            if args.save:
                saver = BeerSaver(settings['database'])
                saver.save(parsed)
        else:
            debug('Nothing to do')

if __name__ == "__main__":
    parser = argparse.ArgumentParser(description='Populate the BierFrau database with prices from TheBeerStore.ca')
    parser.add_argument('--update', action='store_true', help='update file cache')
    parser.add_argument('--parse', action='store_true', default=True, help='parse cached files')
    parser.add_argument('--save', action='store_true', help='save parsed data')

    importer = DataImporter()
    importer.scrape(parser.parse_args())
