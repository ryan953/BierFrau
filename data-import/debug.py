import pprint
pp = pprint.PrettyPrinter(indent=4)

def debug(msg = ''):
	try:
		debug = settings['debugging']
	except:
		debug = True

	if debug: 
		pp.pprint(msg)
	

def log(msg = ''):
	try:
		log = settings['logging']
	except:
		log = True

	if log:
		pp.pprint(msg)


'''
class Struct:
    def __init__(self, **entries): 
        self.__dict__.update(entries)
'''
