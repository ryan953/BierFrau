from sets import Set

class ListParser(object):
    def parse(self, info_list):
        raise NotImplementedError( "Should have implemented this" )

    def flattenField(self, field, info_list):
        lists = [brand[field] for brand in info_list]
        values = []
        for i in range(0, len(lists)):
            for i2 in range(0, len(lists[i])):
                values.append( lists[i][i2].strip() )
        return values
    
    def uniqueData(self, data):
        unique = {}
        for key in data:
            try:
                unique[key] = list(Set(data[key]))
            except:
                unique[key] = data[key]

        return unique
