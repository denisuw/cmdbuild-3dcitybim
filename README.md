# cmdbuild-3dcitybim
This Project is the source for experimental work of our research about Asset and Facility Management of Large and Complex Cultural Heritage Site using Open Source 3D-GIS and BIM. We utilize the advantage of CMDBuild that has native mechanisms to model the database, to design workflow, to configure reports and dashboards, to build connectors with external systems, to geo-refer assets, and to administer the system. Then not only management of Cultural Heritage Site can be implemented with this software environment but any application such as construction management, smart campus, smart city , etc.

We also upgrade the two-dimensional (2D) map in CMDBuild to three-dimensional (3D) map even to 3D Geographical Information System using 3DCityDB, and ol-Cesium.

We use some open source applications, and the list are:
- CMDBuild v2.5.1, http://www.cmdbuild.org/en/download
- PostgreSQL v9.4.17, https://www.postgresql.org/download/
- PostGIS v2.2.3, https://postgis.net/windows_downloads/
- GeoServer v2.11.0
- 3D City Database v4.0 and Importer/Exporter v4.0 for PostGIS, https://3dcitydb.net/3dcitydb/downloads/
- BIMServer v1.5.81, with plugin
    - BIMServer JavaScript API 0.0.120
    - BIMsurfer 0.0.41
    - BIMvie.ws 0.0.85
    - BinarySerializers 0.0.26
    - Console 0.0.10
    - IfcOpenShellPlugin 0.5.24
    - IfcPlugins 0.0.30
 - OpenLayers-Cesium integration library, http://openlayers.org/ol-cesium/
