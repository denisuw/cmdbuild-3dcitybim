import shapefile
from lxml import etree, objectify

def build_gml_main():    
    # define Namespaces
    ns_core = "http://www.opengis.net/citygml/1.0"
    ns_bldg = "http://www.opengis.net/citygml/building/1.0"
    ns_gen = "http://www.opengis.net/citygml/generics/1.0"
    ns_gml = "http://www.opengis.net/gml"
    ns_xAL = "urn:oasis:names:tc:ciq:xsdschema:xAL:2.0"
    ns_xlink = "http://www.w3.org/1999/xlink"
    ns_xsi = "http://www.w3.org/2001/XMLSchema-instance"
    ns_schemaLocation = "http://www.opengis.net/citygml/1.0 http://schemas.opengis.net/citygml/1.0/cityGMLBase.xsd http://www.opengis.net/citygml/building/1.0 http://schemas.opengis.net/citygml/building/1.0/building.xsd http://www.opengis.net/citygml/generics/1.0 http://schemas.opengis.net/citygml/generics/1.0/generics.xsd http://www.opengis.net/gml http://schemas.opengis.net/gml/3.1.1/base/gml.xsd"

    #ns_core, ns_bldg, ns_gen, ns_gml, ns_xAL, ns_xlink, ns_xsi


    nsmap = {
        'core': ns_core,
        'bldg': ns_bldg,
        'gen': ns_gen,
        'gml': ns_gml,
        'xAL': ns_xAL,
        'xlink': ns_xlink,
        'xsi': ns_xsi,

    }

    # Main Element
    cityModel = etree.Element("{%s}CityModel" % ns_core, nsmap=nsmap)
    # Add branch
    description = etree.SubElement(cityModel, "{%s}description" % ns_gml)
    description.text = "Created by me"
    name = etree.SubElement(cityModel, "{%s}name" % ns_gml)
    name.text = "LoD_Bannane"
    # Add branch
    bounded = etree.SubElement(cityModel, "{%s}boundedBy" % ns_gml)
    # Add branch to a branch
    envelop = etree.SubElement(bounded, "{%s}Envelope" % ns_gml, srsName="urn:adv:crs:ETRS89_UTM32*DE_DHHN92_NH")
    lb = etree.SubElement(envelop, "{%s}lowerCorner" % ns_gml, srsDimension="3")
    lb.text = ''
    ub = etree.SubElement(envelop, "{%s}upperCorner" % ns_gml, srsDimension="3")
    ub.text = ''

    # Read Shapefile
    shp_layer = read_shape()

    # Add buildings
    cityModel, point_max, point_min = iteration_buildings(cityModel, shp_layer, ns_core, ns_bldg, ns_gen, ns_gml, ns_xAL, ns_xlink, ns_xsi)

    lb.text = str(point_min[0]) + ' ' + str(point_min[1])+ ' ' + str(point_min[2])
    ub.text = str(point_max[0]) + ' ' + str(point_max[1])+ ' ' + str(point_max[2])

    # pretty print
    print etree.tostring(cityModel, pretty_print=True)

    # Save File
    et = etree.ElementTree(cityModel)
    outFile = open('/yourPath/output_b.xml', 'w')
    et.write(outFile, xml_declaration=True, encoding='utf-8', pretty_print= True)
    print 'done'
	
def iteration_buildings(cityModel, shp_layer, ns_core, ns_bldg, ns_gen, ns_gml, ns_xAL, ns_xlink, ns_xsi):
    #lower corner
    point_min = None
    #upper corner
    point_max = None

    building_count = len(shp_layer.shapes())
    field_content = shp_layer.records()

    # iteration
    for i_build in range(building_count):

        cityObject = etree.SubElement(cityModel, "{%s}cityObjectMember" % ns_core)

        # building shape area
        points_2D = shp_layer.shapes()[i_build].points

        # contents which are given in the shapefile and needed in the citygml model
        inits = building_inits(field_content[i_build], shp_layer)

        # for Citygml the lower and upper limit of all buildings are needed
        point_min, point_max = find_lower_upper_corner(points_2D, inits['dachhoehe'], point_min, point_max)

        # calculation of the polygon by useing the points from the building shape area
        polygon = polygon_caculation(inits, points_2D)

        # Add branch and sub-branche of a building
        bldg = etree.SubElement(cityObject, "{%s}Building" % ns_bldg, {"{%s}id" % ns_gml: inits['gml_id']})
        creationDate = etree.SubElement(bldg, "{%s}creationDate" % ns_core)
        creationDate.text = '2017-02-04'
        externalReference = etree.SubElement(bldg, "{%s}externalReference" % ns_core)
        informationSystem = etree.SubElement(externalReference, "{%s}informationSystem" % ns_core)
        informationSystem.text = "http://www.BananenBAUM2017.de"
        externalObject = etree.SubElement(externalReference, "{%s}externalObject" % ns_core)
        name = etree.SubElement(externalObject, "{%s}name" % ns_core)
        name.text = inits['gml_id']

        stringAttribute = etree.SubElement(bldg, "{%s}stringAttribute" % ns_gen, name="Gemeindeschluessel")
        value = etree.SubElement(stringAttribute, "{%s}value" % ns_gen)
        value.text = inits['bezirk']

        stringAttribute = etree.SubElement(bldg, "{%s}stringAttribute" % ns_gen, name="DatenquelleDachhoehe")
        value = etree.SubElement(stringAttribute, "{%s}value" % ns_gen)
        value.text = str(1000)

        stringAttribute = etree.SubElement(bldg, "{%s}stringAttribute" % ns_gen, name="DatenquelleLage")
        value = etree.SubElement(stringAttribute, "{%s}value" % ns_gen)
        value.text = str(1000)

        stringAttribute = etree.SubElement(bldg, "{%s}stringAttribute" % ns_gen, name="DatenquelleBodenhoehe")
        value = etree.SubElement(stringAttribute, "{%s}value" % ns_gen)
        value.text = str(1300)

        stringAttribute = etree.SubElement(bldg, "{%s}stringAttribute" % ns_gen, name="BezugspunktDach")
        value = etree.SubElement(stringAttribute, "{%s}value" % ns_gen)
        value.text = str(2100)

        function = etree.SubElement(bldg, "{%s}function" % ns_bldg)
        function.text = str(inits['funktion'])

        measuredHeight = etree.SubElement(bldg, "{%s}measuredHeight" % ns_bldg, uom="urn:adv:uom:m")
        measuredHeight.text = str(inits['dachhoehe'])

        storeysAboveGround = etree.SubElement(bldg, "{%s}storeysAboveGround" % ns_bldg)
        storeysAboveGround.text = str(inits['Anz_O'])

        # Add the 3d polygon
        lod1Solid = etree.SubElement(bldg, "{%s}lod1Solid" % ns_bldg)
        Solid = etree.SubElement(lod1Solid, "{%s}Solid" % ns_gml)
        exterior = etree.SubElement(Solid, "{%s}exterior" % ns_gml)
        CompositeSurface = etree.SubElement(exterior, "{%s}CompositeSurface" % ns_gml)
        for poly in polygon:
            surfaceMember = etree.SubElement(CompositeSurface, "{%s}surfaceMember" % ns_gml)
            polygon = etree.SubElement(surfaceMember, "{%s}Polygon" % ns_gml, {"{%s}id" % ns_gml: inits['gml_id']})
            exterior = etree.SubElement(polygon, "{%s}exterior" % ns_gml)
            LinearRing = etree.SubElement(exterior, "{%s}LinearRing" % ns_gml)

            for point in poly:
                pos = etree.SubElement(LinearRing, "{%s}pos" % ns_gml, srsDimension = "3")
                pos.text = str(point[0]) + ' ' + str(point[1])+ ' ' + str(point[2])
            #print etree.tostring(cityModel, pretty_print=True)
        #print etree.tostring(cityModel, pretty_print=True)

        print 'done'

    #print etree.tostring(cityModel, pretty_print=True)
    return cityModel, point_max, point_min
	
def building_inits(content, shp_layer):
    inits = {}
    for i, field in zip(range(len(shp_layer.fields) - 1), shp_layer.fields[1:]):
        # print field[0]
        # print content[i]
        if field[0] == 'gml_id':
            inits['gml_id'] = content[i]
        elif field[0] == 'Stadtteil':
            inits['stadtteil'] = content[i]
        elif field[0] == 'anzahlDerO':
            inits['Anz_O'] = content[i]
        elif field[0] == 'anzahlDerU':
            inits['Anz_U'] = content[i]
        elif field[0] == 'dachform':
            inits['dachform'] = content[i]
        elif field[0] == 'grundflaec':
            inits['grundflaeche'] = content[i]
        elif field[0] == 'bauweise':
            inits['bauweise'] = content[i]
        elif field[0] == 'anlass':
            inits['anlass'] = content[i]
        elif field[0] == 'Bezirk':
            inits['bezirk'] = content[i]
        elif field[0] == 'baujahr':
            inits['baujahr'] = content[i]
        elif field[0] == 'gebaeudefu':
            inits['funktion'] = content[i]
        elif field[0] == 'dachart':
            inits['dachart'] = content[i]

    # needed roof height for the 3d polygon
    # simple and mostly wrong calculation should be changed by user
    if int(inits['Anz_O']):
        inits['dachhoehe'] = (int(inits['Anz_O']) + 1) * 2.53
    else:
        inits['dachhoehe'] = 3.113    
    return inits
	
def read_shape():
    shp_read = shapefile.Reader('/yourPath/ALKIS 2017-01/Harburg_corp')
    return shp_read
	
def polygon_caculation(inits, points_2D):

    anz_polygone = len(points_2D)+2
    polygon = []
    grundhoehe = 0
    # extimated roof heigth
    dachhoehe = inits['dachhoehe'] + grundhoehe

    for point_A, point_B in zip(points_2D[:-1], points_2D[1:]):
        surface = []
        surface.append((point_A[0], point_A[1], dachhoehe))
        surface.append((point_B[0], point_B[1], dachhoehe))
        surface.append((point_B[0], point_B[1], grundhoehe))
        surface.append((point_A[0], point_A[1], grundhoehe))
        surface.append((point_A[0], point_A[1], dachhoehe))

        polygon.append(surface)

        print point_A, point_B

    # add roof, add ground
    roof = []
    ground = []
    for point in points_2D:
        roof.append((point[0], point[1], dachhoehe))
        ground.append((point[0], point[1], grundhoehe))
    polygon.append(roof)
    polygon.append(ground)

    return polygon

def find_lower_upper_corner(points_2D, dachhoehe, point_min, point_max):
    #compare the given points with the saved lower and upper limit
    # if lower or upper points exist, overwrite the saved ones
    points_2D_list = list(points_2D)
    if point_min is None:
        point_min = list(points_2D_list[0] + (0,))
        point_max = list(points_2D_list[0] + (0,))

    for point in points_2D_list:
        if point_min[0] > point[0]:
            point_min[0] = point[0]
        if point_max[0] < point[0]:
            point_max[0] = point[0]
        if point_min[1] > point[1]:
            point_min[1] = point[1]
        if point_max[1] < point[1]:
            point_max[1] = point[1]
        if point_max[2] < dachhoehe:
            point_max[2] = dachhoehe
    return point_min, point_max
	
build_gml_main()
