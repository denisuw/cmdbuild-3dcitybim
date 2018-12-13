# cmdbuild-3dcitybim
Strasbourg, October 2018.

This Project is the source for experimental work of our research about Asset and Facility Management of Large and Complex Cultural Heritage Site using Open Source 3D-GIS and BIM. We utilize the advantage of CMDBuild that has native mechanisms to model the database, to design workflow, to configure reports and dashboards, to build connectors with external systems, to geo-refer assets, and to administer the system. Not only management of Cultural Heritage Site can be implemented with this software environment but also any applications such as construction management, smart campus, smart village, smart city , etc.

We also upgrade the two-dimensional (2D) map in CMDBuild to three-dimensional (3D) map even to 3D Geographical Information System using 3DCityDB, and ol-Cesium. We are doing:
1. Data Model Designing for Asset/Facility Management of Large and Complex Cultural Heritage (CH) Site, its include temporal aspect that has not established in CityGML yet;
2. Integrating or Mapping between CityGML scheme in 3DCityDB and IFC scheme in BIMServer;
3. Spatial Analysis Investigation that would be important in the management of CH asset/facility

We use some open source applications, and the list are (MS Windows Operating System):
- CMDBuild v2.5.1, http://www.cmdbuild.org/en/download
- PostgreSQL v9.4.17, https://www.postgresql.org/download/ or https://www.enterprisedb.com/downloads/postgres-postgresql-downloads
- PostGIS v2.2.3, https://postgis.net/windows_downloads/
- GeoServer v2.11.0, http://geoserver.org/download/
- 3D City Database v4.0 and Importer/Exporter v4.0 for PostGIS, https://3dcitydb.net/3dcitydb/downloads/
- BIMServer v1.5.81, with plugin, https://github.com/opensourceBIM/BIMserver/releases/tag/parent-1.5.81
    - BIMServer JavaScript API 0.0.120
    - BIMsurfer 0.0.41
    - BIMvie.ws 0.0.85
    - BinarySerializers 0.0.26
    - Console 0.0.10
    - IfcOpenShellPlugin 0.5.24
    - IfcPlugins 0.0.30
 - OpenLayers-Cesium integration library, http://openlayers.org/ol-cesium/
    - OL-Cesium v1.37 (Release 1.37 based on OL 4.6.5 and Cesium 1.45)
 - Apache Tomcat 8, https://tomcat.apache.org/download-80.cgi

![alt text](https://github.com/denisuw/cmdbuild-3dcitybim/blob/master/3dcitybim.png)

# Installation
 1. Install Postgresql. 
    The easiest way to install PostgreSQL on Windows is with the One Click installer package maintained by EnterpriseDB, which you can get from the page linked to above.
 2. Install PostGIS.
    Run the “StackBuilder” utility in Postgresql and install the PostGIS add-on. If you can not install from “StackBuilder”, try to install using PostGIS windows installer, which you can get from the page linked to above.
 3. Install Geoserver.
 4. Install BIMServer
 5. Install Apache Tomcat
 6. Restore 3dcitybim (for cultural heritage) database in Postgresql
 7. Run 3dcitydb script to create 3dcity scheme in 3dcitybim database
 8. Copy CMDBuild war to webapp in Apache Tomcat and restart the tomcat application
 9. Upgrade CMDBuild by replace several java class and javascript files with our new codes 
 10. Connect CMDBuild to 3dcitybim
 11. Login
    
