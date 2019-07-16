<?php
/*
 | Copyright 2015 Pispidikis john
 |
 | Licensed under the   GNU GENERAL PUBLIC LICENSE  Version 3
 | you may not use this file except in compliance with the License.
 |
 |
 | Unless required by applicable law or agreed to in writing, software
 | distributed under the License is distributed on an "AS IS" BASIS,
 | WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 | See the License for the specific language governing permissions and
 | limitations under the License.
 */


//LIBRARY FOR 3DCITYDB AS FOR BUILDINGS INFORMATION
//JOHN PISPIDIKIS 2015

class cityDBWrapper {
var  $Server='';
var  $Port=0;
var  $Database='';
var  $Username='';
var  $Password='';
var $Schema='';

// Internal stuff
	public function __construct($Server, $Port= 0,$Schema='', $Database = '' ,$Username='' ,$Password='') {
		
		$this->Server = $Server;
		$this->Port= $Port;
		$this->Schema = $Schema;
		$this->Database = $Database;
		$this->Username = $Username;
		$this->Password = $Password;
	}
	
	
//////////////////////////////////////////////////////////////////GET ALL GEOMETRY ////////////////////////////////////////////////////////////			
	//take all data from 3dcityDB and return geojson
	public function getAllGeometryData()
	{
	$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
	
	$sql='SELECT ST_AsGeoJSON(ST_Collect(ST_Transform(geometry,4326))) FROM "'. $this->Schema.'"."surface_geometry"';
     $result=pg_query($dbconn3, $sql);
      if (!$result) {
           echo "An error occured. \n";
            exit;
            }
	  $gsondata='{ "type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84" } },"features": [{ "type": "Feature", "properties": { }, "geometry":';
				  
			  $mydata=array();		  
	         $i=0;
          while ($row = pg_fetch_row($result))
               {

                $mydata[$i]=$row[0];
				$gsondata.=$mydata[$i];
				$i++;
	           } 			  
		
		  $gsondata.='}]}';
		   return $gsondata; 

		
	   }
	
//////////////////////////////////////////////////////////////////SEMANTICS DATA////////////////////////////////////////////////////////////			
	//get the number of semantics data and return the name in array variable
 public function checkifexistthematicdatabylod($lod)
    {
	  $dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
	  if($lod==2){
	  	

	    	 $sql='SELECT count(lod2_multi_surface_id) FROM "'. $this->Schema.'"."thematic_surface" where building_id is not NULL';	
			
	   }
	  if($lod==3){
	   
	    	$sql='SELECT count(lod3_multi_surface_id) FROM "'. $this->Schema.'"."thematic_surface" where building_id is not NULL';
			
	   }
	  if($lod==4){
	    	
			$sql='SELECT count(lod4_multi_surface_id) FROM "'. $this->Schema.'"."thematic_surface" where building_id is not NULL';
	   }
	  
	  $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }  
			 $mydata=array();		  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {

                $mydata[$i]=$row[0];
				//$gsondata.=$mydata[$i];
				$i++;
	           } 
			   
			 return $mydata;  	
	  
	
    }  
 //////////////////////////////////////////////////////////////////OBJECTCLASS///////////////////////////////////////////////////////////	  
//get the objeclass name base the id
	public function getobjectclassname($objectclass_id)
	{
		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		$sql='SELECT classname FROM "'. $this->Schema.'"."objectclass" WHERE id='+$objectclass_id;
		$result=pg_query($dbconn3, $sql);
		 $mydata=array();		  
	    $i=0;
        while ($row = pg_fetch_row($result))
               {

                $mydata[$i]=$row[0];
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
	 return $mydata;		   	

	}
//////////////////////////////////////////////////////////////////BUILDINGS ////////////////////////////////////////////////////////////		
	
	//get building base lod[2-3-4]-multisurface (surface_geometry-thematic_surface)
	public function getbuildingbaselod($lod)
	{
		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		if($lod==2){
					
			     $sql='SELECT ts.building_id, ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry FROM "'. $this->Schema.'"."surface_geometry" sg, "'. $this->Schema.'"."thematic_surface" ts WHERE ts.lod2_multi_surface_id=sg.root_id AND ts.building_id is not NULL group by ts.building_id order by ts.building_id';	

		           }
		else if($lod==3){
		
			     $sql=' SELECT ts.building_id, ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry FROM "'. $this->Schema.'"."surface_geometry" sg, "'. $this->Schema.'"."thematic_surface" ts WHERE ts.lod3_multi_surface_id=sg.root_id AND ts.building_id is not NULL group by ts.building_id order by ts.building_id';	
		           }		
        else if($lod==4){
		
			     $sql=' SELECT ts.building_id, ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry FROM "'. $this->Schema.'"."surface_geometry" sg, "'. $this->Schema.'"."thematic_surface" ts WHERE ts.lod4_multi_surface_id=sg.root_id AND ts.building_id is not NULL group by ts.building_id order by ts.building_id limit 5';	
		           }	
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
		      $mydata=array();	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
             
				$gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[0].'"} },"features":';
			    $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[1]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
			   return $mydata;   
		
		}

public function getbuildings()
    {
    	//select b.id from building b;
	  $dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
	  $sql='SELECT b.id FROM "'.$this->Schema.'"."building" b';	
	  $result=pg_query($dbconn3, $sql);  
	   if (!$result) {
          echo "An error occured. \n";
           exit;
          }  
		 $mydata=array();		  
	    $i=0;
        while ($row = pg_fetch_row($result))
             {

         $mydata[$i]=$row[0];
				//$gsondata.=$mydata[$i];
		     $i++;
	         } 
			   
	    return $mydata;  	
	
    }
				
 public function getbuildingsbaselod($lod)
    {
    	//select b.id from building b;
	  $dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');
	   $lodmulti="";
	   $lodsolid="";
	  if($lod==2)
	  {
	  	$lodmulti="lod2_multi_surface_id";
		$lodsolid="lod2_solid_id";
	  }
	 if($lod==3)
	  {
	  	$lodmulti="lod3_multi_surface_id";
		$lodsolid="lod3_solid_id";
	  }
	  if($lod==4)
	  {
	  	$lodmulti="lod4_multi_surface_id";
		$lodsolid="lod4_solid_id";
	  }
	  
	  $sql='SELECT b.id FROM "'.$this->Schema.'"."building" b WHERE ('.$lodmulti.' IS NOT NULL OR '.$lodsolid.' IS NOT NULL)
	  OR 
	  (lod2_multi_surface_id IS NULL AND lod2_solid_id IS NULL AND lod3_multi_surface_id IS NULL AND lod3_solid_id IS NULL AND lod4_multi_surface_id IS NULL AND lod4_solid_id IS NULL)';	
	  $result=pg_query($dbconn3, $sql);  
	   if (!$result) {
          echo "An error occured. \n";
           exit;
          }  
		 $mydata=array();		  
	    $i=0;
        while ($row = pg_fetch_row($result))
             {

         $mydata[$i]=$row[0];
				//$gsondata.=$mydata[$i];
		     $i++;
	         } 
			   
	    return $mydata;  	
	
    }
				
				
						
				
				
  public function getbuildingsbyquery($coord,$type)
    {
    	
    	//select b.id from building b;
	  $dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
	  
	  if($type=="Polygon")
	  {
	  $sql="	 SELECT id
                 FROM cityobject co
                 WHERE
                 objectclass_id=26
                 AND 
                 ST_INTERSECTS(ST_Transform(ST_Force_2D(envelope),4326),
                 ST_Transform(ST_GeomFromText('".$coord."',3857),4326))
                 ORDER BY id";
				 
	  }
	  if($type=="Point")
	  {
	  	$sql="	 SELECT id
                 FROM cityobject co
                 WHERE
                 objectclass_id=26
                 AND 
                 ST_Contains(ST_Transform(ST_Force_2D(envelope),4326),
                 ST_Transform(ST_GeomFromText('".$coord."',3857),4326))
                 ORDER BY id";
		
	  }		 	
	  $result=pg_query($dbconn3, $sql);  
	   if (!$result) {
          echo "An error occured. \n";
           exit;
          }  
		  $mydata=array();		  
	    $i=0;
        while ($row = pg_fetch_row($result))
             {

         $mydata[$i]=$row[0];
				//$gsondata.=$mydata[$i];
		     $i++;
	         } 
			   
	    return $mydata;  	
	
    }  
 //////////////////////////////////////////////////////////////////SURFACE DATA///////////////////////////////////////////////////////////	    
 
    //get geometry of surface group by thematic surface for every buildings/lod
public function getgeometryofsurfacebasebuilding($lod)
	{


		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		 $lodsurfacesql="";

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		if($lod==2){
					$lodsurfacesql='lod2_multi_surface_id';
			 }
		   if($lod==3){
		           $lodsurfacesql='lod3_multi_surface_id';
                  }	 
	     if($lod==4){
		          $lodsurfacesql='lod4_multi_surface_id';
		           }
		
		 
		    $sql='SELECT ts.building_id, ts.objectclass_id,oc.classname, ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry'; 
            $sql.=' FROM "'.$this->Schema.'"."surface_geometry" sg, "'.$this->Schema.'"."thematic_surface" ts,"'.$this->Schema.'"."objectclass" oc';
            $sql.=' WHERE ts.'.$lodsurfacesql.'=sg.root_id AND ts.building_id is not NULL AND ts.objectclass_id=oc.id group by ts.building_id, ts.objectclass_id, oc.classname order by ts.building_id, ts.objectclass_id';
		             
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		      $mydata=array();		  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[0].'","sufracetype_id":"'.$row[1].'","sufracename":"'.$row[2].'"} },"features":';
			$gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[3]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
			   return $mydata;   
		
	//echo json_encode($jsonresult); 
    		
	
	}
//get details of surface base building id and lod of thematic 
public function getgeometryofsurfacebasebuildingid($lod,$buildingid)
	{
        $lodsurfacesql="";

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		if($lod==2){
					$lodsurfacesql='lod2_multi_surface_id';
			 }
		   if($lod==3){
		           $lodsurfacesql='lod3_multi_surface_id';
                  }	 
	     if($lod==4){
		          $lodsurfacesql='lod4_multi_surface_id';
		           }
		           
	    $sql='SELECT ts.building_id, ts.objectclass_id,oc.classname, ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry'; 
        $sql.=' FROM "'.$this->Schema.'"."surface_geometry" sg, "'.$this->Schema.'"."thematic_surface" ts,"'.$this->Schema.'"."objectclass" oc';
        $sql.=' WHERE ts.'.$lodsurfacesql.'=sg.root_id AND ts.building_id is not NULL AND ts.objectclass_id=oc.id AND  ts.building_id='.$buildingid.' group by ts.building_id, ts.objectclass_id, oc.classname order by ts.building_id, ts.objectclass_id';
			
			
				   	
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();		  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[0].'","surfacetype_id":"'.$row[1].'","surfacename":"'.$row[2].'"} },"features":';
			$gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[3]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
			   return $mydata;   
		
	//echo json_encode($jsonresult); 
    		
	
	}
//////////////////////////////////////////////////////////////////ADDRESS INFORAMTION////////////////////////////////////////////////////////////					   
//get  address information of the building
public function getaddressbybuilding($buildingid)
	{

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		///
		$sql="select street,house_number,po_box, zip_code, city,state,country,xal_source";
		$sql.=' FROM "'.$this->Schema.'"."address_to_building" ab, "'.$this->Schema.'"."address" a';
		$sql.=" where a.id=ab.address_id ";
		$sql.=" AND ab.building_id=".$buildingid;

		////
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		    
			  $mydata=array();	
			 $gsondata="";	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $mydata[$i]='{"street":"'.$row[0].'","house_number":"'.$row[1].'","po_box":"'.$row[2].'","zip_code":"';
               $mydata[$i].=$row[3].'","city":"'.$row[4].'","state":"'.$row[5];
               $mydata[$i].='","country":"'.$row[6].'"}';
			  $gsondata.=$mydata[$i];
              
				//$gsondata.=$mydata[$i];
				$i++;
	           } 
				return $gsondata;	

			    
			      
		
	//echo json_encode($jsonresult); 
    		
	
	}

//////////////////////////////////////////////////////////////////BUILDING INFORMATION////////////////////////////////////////////////////////////	
//get  building information of the building
public function getinformationbybuilding($buildingid)
	{

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		///
		$sql="SELECT class,class_codespace,function,function_codespace,usage,usage_codespace,year_of_construction,roof_type,roof_type_codespace,measured_height,measured_height_unit";
		$sql.=' FROM "'.$this->Schema.'"."building" b';
		$sql.=" where b.id=".$buildingid;
		

		////
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		    
			  $mydata=array();	
			 $gsondata="";	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $mydata[$i]='{"theclass":"'.$row[0].'","class_codespace":"'.$row[1].'","thefunction":"'.$row[2].'","function_codespace":"';
               $mydata[$i].=$row[3].'","usage":"'.$row[4].'","usage_codespace":"'.$row[5];
               $mydata[$i].='","year_of_construction":"'.$row[6].'","roof_type":"'.$row[7].'","roof_type_codespace":"'.$row[8].'","measured_height":"'.$row[9].'","measured_height_unit":"'.$row[10].'"}';
			  $gsondata.=$mydata[$i];
              
				//$gsondata.=$mydata[$i]
				$i++;
	           } 
		
		return $gsondata;	

			    
			      
		
	//echo json_encode($jsonresult); 
    		
	
	}

//////////////////////////////////////////////////////////////////OPENING DATA////////////////////////////////////////////////////////////	

//get geometry of opening (windows, doors) base building and lod
public function getgeometryofopeningbasebuildingid($lodsurface,$lodopening,$buildingid)
	{
		//"'.$this->Schema.'"."thematic_surface"
       $lodthematiksql="";
	   $lodopeningsql="";

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		    
		    if($lodsurface==2)
		        {
		   	$lodthematiksql="lod2_multi_surface_id";
		        }
		   if($lodsurface==3)
		        {
		   	$lodthematiksql="lod3_multi_surface_id";
		        }
			if($lodsurface==4) 
			    {  
		   		$lodthematiksql="lod4_multi_surface_id";
                 }	 
				
			 if($lodopening==3)
		        {
		   	$lodopeningsql="lod3_multi_surface_id";
		        }
			if($lodopening==4) 
			    {  
		   		$lodopeningsql="lod4_multi_surface_id";
                }	
				
			$sql='select cityobject_id,objectclass_id,classname,geometry';   
			$sql.='		from(';
			$sql.='		select root_id,cityobject_id,ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry';  
			$sql.='		from surface_geometry as sg';
			$sql.='		inner join';
			$sql.='			(';

			$sql.='		select id,objectclass_id,'.$lodopeningsql.' as geomid';
			$sql.='		from opening as o';
			$sql.='		inner join';
			$sql.='				(';

			$sql.='		SELECT opening_id,thematic_surface_id';
			$sql.='		from opening_to_them_surface as os';
			$sql.='		inner join (';
			$sql.='		SELECT  ts.id';
			$sql.='		FROM surface_geometry sg,thematic_surface ts,objectclass oc';
			$sql.='		WHERE ts.'.$lodthematiksql.'=sg.root_id AND ts.building_id is not NULL ';
			$sql.='		AND ts.objectclass_id=oc.id AND ts.building_id='.$buildingid;
			$sql.='		group by ts.building_id, ts.objectclass_id,oc.classname,ts.id order by ts.building_id, ts.objectclass_id';
			$sql.='		) as n2';
			$sql.='		on n2.id=os.thematic_surface_id';
			$sql.='		) as n1';
			$sql.='		on n1.opening_id=o.id';
			$sql.='		) as n0';
			$sql.='		on n0.geomid=sg.root_id';
			$sql.='		group by sg.root_id, sg.cityobject_id';
			$sql.='		order by sg.root_id';
			$sql.='		)as n,cityobject as co,objectclass as oc';
			$sql.='		where co.objectclass_id=oc.id';
			$sql.='		AND';
			$sql.='		n.cityobject_id=co.id';
			$sql.='		group by n.cityobject_id,oc.classname,co.objectclass_id,geometry';
			$sql.='		order by co.objectclass_id';	
				
				
				
				
                 
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$buildingid.'","cityobject_id":"'.$row[0].'","objectclass_id":"'.$row[1].'","classname":"'.$row[2].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[3]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
              
	          return $mydata;
	//echo json_encode($jsonresult); 
    		
	
	}
			
			
	public function getcurrentopeningbasebuildingid($lodsurface,$lodopening,$openingid,$buildingid)
	{
		//"'.$this->Schema.'"."thematic_surface"
       $lodthematiksql="";
	   $lodopeningsql="";

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		    
		    if($lodsurface==2)
		        {
		   	$lodthematiksql="lod2_multi_surface_id";
		        }
		   if($lodsurface==3)
		        {
		   	$lodthematiksql="lod3_multi_surface_id";
		        }
			if($lodsurface==4) 
			    {  
		   		$lodthematiksql="lod4_multi_surface_id";
                 }	 
				
			 if($lodopening==3)
		        {
		   	$lodopeningsql="lod3_multi_surface_id";
		        }
			if($lodopening==4) 
			    {  
		   		$lodopeningsql="lod4_multi_surface_id";
                }	
				
			$sql='select cityobject_id, objectclass_id,classname,geometry';   
			$sql.='		from(';
			$sql.='		select root_id,cityobject_id,ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geometry';  
			$sql.='		from surface_geometry as sg';
			$sql.='		inner join';
			$sql.='			(';

			$sql.='		select id,objectclass_id,'.$lodopeningsql.' as geomid';
			$sql.='		from opening as o';
			$sql.='		inner join';
			$sql.='				(';

			$sql.='		SELECT opening_id,thematic_surface_id';
			$sql.='		from opening_to_them_surface as os';
			$sql.='		inner join (';
			$sql.='		SELECT  ts.id';
			$sql.='		FROM surface_geometry sg,thematic_surface ts,objectclass oc';
			$sql.='		WHERE ts.'.$lodthematiksql.'=sg.root_id AND ts.building_id is not NULL ';
			$sql.='		AND ts.objectclass_id=oc.id AND ts.building_id='.$buildingid;
			$sql.='		group by ts.building_id, ts.objectclass_id,oc.classname,ts.id order by ts.building_id, ts.objectclass_id';
			$sql.='		) as n2';
			$sql.='		on n2.id=os.thematic_surface_id';
			$sql.='		) as n1';
			$sql.='		on n1.opening_id=o.id';
			$sql.='		) as n0';
			$sql.='		on n0.geomid=sg.root_id';
			$sql.='		group by sg.root_id, sg.cityobject_id';
			$sql.='		order by sg.root_id';
			$sql.='		)as n,cityobject as co,objectclass as oc';
			$sql.='		where co.objectclass_id=oc.id';
			$sql.='		AND';
			
			$sql.='		n.cityobject_id=co.id AND n.cityobject_id='.$openingid;
			$sql.='		group by n.cityobject_id,oc.classname,co.objectclass_id,geometry';
			$sql.='		order by co.objectclass_id';	
				
				
				
				
                 
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$buildingid.'","cityobject_id":"'.$row[0].'","objectclass_id":"'.$row[1].'","classname":"'.$row[2].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[3]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
              
	          return $mydata;
	//echo json_encode($jsonresult); 
    		
	
	}		
//////////////////////////////////////////////////////////////////BUILDING INSTALLATION///////////////////////////////////////////////////////////				
			//support only lodx_brep_id 
  public function getgeometryofbuildinginstallation($lod,$buildingid)
	{

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	 
		$lodinstallationsql="";
		 if($lod==2)
		        {
		   	$lodinstallationsql="lod2_brep_id";
		        }
		   if($lod==3)
		        {
		   	$lodinstallationsql="lod3_brep_id";
		        }
			if($lod==4) 
			    {  
		   		$lodinstallationsql="lod4_brep_id";
                 }	 
		$sql='SELECT bi.building_id, bi.id,oc.classname,ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326)))
				FROM building_installation bi,surface_geometry sg, objectclass oc
				WHERE sg.root_id=bi.'.$lodinstallationsql.' 
				AND bi.building_id='.$buildingid.'
				AND bi.objectclass_id=oc.id
				GROUP BY sg.root_id,bi.id, bi.objectclass_id,oc.classname
				ORDER BY sg.root_id';
		
		 $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[0].'","installation_id":"'.$row[1].'","classname":"'.$row[2].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[3]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
			   return $mydata;	
		
		
		
	}
				
				
				
 public function getgeometryofcurrentbuildinginstallation($installationid,$lod,$buildingid)
	{

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	 
		$lodinstallationsql="";
		 if($lod==2)
		        {
		   	$lodinstallationsql="lod2_brep_id";
		        }
		   if($lod==3)
		        {
		   	$lodinstallationsql="lod3_brep_id";
		        }
			if($lod==4) 
			    {  
		   		$lodinstallationsql="lod4_brep_id";
                 }	 
		$sql='SELECT bi.building_id, bi.id,oc.classname,ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326)))
				FROM building_installation bi,surface_geometry sg, objectclass oc
				WHERE sg.root_id=bi.'.$lodinstallationsql.' 
				AND bi.building_id='.$buildingid.'
				AND bi.objectclass_id=oc.id
				AND bi.id='.$installationid.'
				GROUP BY sg.root_id,bi.id, bi.objectclass_id,oc.classname
				ORDER BY sg.root_id';
		
		 $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();	  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[0].'","installation_id":"'.$row[1].'","classname":"'.$row[2].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[3]."}]}";
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
			   return $mydata;	
		
		
		
	}						
//////////////////////////////////////////////////////////////////BUILDING FURNITURE////////////////////////////////////////////////////////////			
			//support only lodx4_brep_id  furniture by building and room
  public function getgeometryofbuildingfurniture($room,$buildingid)
	{

		 
		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');		 
	$sql='SELECT geom.room_id as id_room,geom.id, ST_AsGeoJSON(ST_Collect(ST_Transform(geom.geom,4326))) as geometry 
			FROM 
 			(
   				select bf.room_id,bf.id, sg.geometry as geom
   				from surface_geometry as sg,building_furniture as bf
   				where 
   				bf.lod4_brep_id=sg.root_id
   				) as geom
				INNER JOIN 
 				(
  				SELECT r.id
   				FROM room r
   				WHERE
   				r.building_id='.$buildingid.'
   				AND r.id='.$room.'
   				GROUP BY  r.id
   				ORDER BY r.id

				) as room
				on  geom.room_id=room.id
				group by id_room, geom.id
				order by id_room';
				
		
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();
	
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$buildingid.'","room_id":"'.$row[0].'","furniture_id":"'.$row[1].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[2]."}]}";
		 				$i++;
	           } 
			   return $mydata;
		 
		 }
//////////////////////////////////////////////////////////////////ROOM DATA////////////////////////////////////////////////////////////		
	//get the geometry of rooms if exist by building
	 public function getgeometryofroom($solid,$buildingid)
	{
		

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		$lodinstallationsql="";
		
		if($solid==TRUE)
		{
			$lodinstallationsql="lod4_solid_id";
			
			
		}
		
		///second for no solid but mulitsurface with connection id
		if($solid==FALSE)
		{
			
			$lodinstallationsql="lod4_multi_surface_id";
			
		}
		
		$sql='SELECT r.id,building_id,ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geom
				FROM room r,surface_geometry sg
				WHERE
				r.'.$lodinstallationsql.'=sg.root_id
				AND r.building_id='.$buildingid.'
				AND sg.is_solid=0
				GROUP BY  r.id,building_id
				ORDER BY r.id';
				
		
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();
						  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[1].'","room_id":"'.$row[0].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[2]."}]}";
				//$gsondata.=$myda
			   $i++;
	           } 
			 if(sizeof($mydata)==0 && $solid==FALSE)
			  {
			  		////third for no solid, no connection--> but existing solid_id in thematic surface

			  	$sqlnew='SELECT geom.room_id as id_room, ST_AsGeoJSON(ST_Collect(ST_Transform(geom.geom,4326))) as geometry 
				FROM 
   			    (
   					select ts.room_id, sg.geometry as geom
   					from surface_geometry as sg,thematic_surface as ts
   					where 
   					ts.lod4_multi_surface_id=sg.root_id
   					or 
   					ts.lod3_multi_surface_id=sg.root_id
   					) as geom
				INNER JOIN 
				(
   					SELECT r.id
   					FROM room r
   					WHERE
   					r.building_id='.$buildingid.'
   					GROUP BY  r.id
   					ORDER BY r.id

				) as room
				on  geom.room_id=room.id
				group by id_room
				order by id_room';
	
		
				$resultnew=pg_query($dbconn3, $sqlnew);  
			     if (!$resultnew) {
                   echo "An error occured. \n";
                   exit;
                    }     
			
		          $mydatanew=array();	  
	             $i=0;
                 while ($rownew = pg_fetch_row($resultnew))
                    {
                   $gsondatanew='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$buildingid.'","room_id":"'.$rownew[0].'"} },"features":';
			       $gsondatanew.='[{ "type": "Feature", "properties": {}, "geometry":';
                   $mydatanew[$i]=$gsondatanew.$rownew[1]."}]}";
				   //$gsondata.=$mydata[$i];
				   $i++;
	                } 	
				return $mydatanew;
				
			  }	
           else
			 {
			 	
				return $mydata;
				
			 }	
		
	  
	
	}		

	
				
 public function getgeometryofcurrentroom($solid,$roomid,$buildingid)
	{

		$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
		$lodinstallationsql="";
		
		if($solid==true)
		{
			$lodinstallationsql="lod4_solid_id";
			
			
		}
		
		///second for no solid but mulitsurface with connection id
		if($solid==false)
		{
			
			$lodinstallationsql="lod4_multi_surface_id";
			
		}
		
		$sql='SELECT r.id,building_id,ST_AsGeoJSON(ST_Collect(ST_Transform(sg.geometry,4326))) as geom
				FROM room r,surface_geometry sg
				WHERE
				r.'.$lodinstallationsql.'=sg.root_id
				AND r.building_id='.$buildingid.'
				AND sg.is_solid=0
				AND r.id='.$roomid.'
				GROUP BY  r.id,building_id
				ORDER BY r.id';
				
		
		    $result=pg_query($dbconn3, $sql);  
			if (!$result) {
           echo "An error occured. \n";
            exit;
            }     
			
		     $mydata=array();
						  
	         $i=0;
             while ($row = pg_fetch_row($result))
               {
               $gsondata='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$row[1].'","room_id":"'.$row[0].'"} },"features":';
			  $gsondata.='[{ "type": "Feature", "properties": {}, "geometry":';
                $mydata[$i]=$gsondata.$row[2]."}]}";
				//$gsondata.=$myda
			   $i++;
	           } 
			  if(sizeof($mydata)==0 && $lodinstallationsql== "lod4_multi_surface_id")
			  {
			  	
			  		////third for no solid, no connection--> but existing solid_id in thematic surface
			  	
			  	$sqlnew='SELECT geom.room_id as id_room, ST_AsGeoJSON(ST_Collect(ST_Transform(geom.geom,4326))) as geometry 
				FROM 
   			    (
   					select ts.room_id, sg.geometry as geom
   					from surface_geometry as sg,thematic_surface as ts
   					where 
   					ts.lod4_multi_surface_id=sg.root_id
   					or 
   					ts.lod3_multi_surface_id=sg.root_id
   					) as geom
				INNER JOIN 
				(
   					SELECT r.id
   					FROM room r
   					WHERE
   					r.building_id='.$buildingid.'
   					GROUP BY  r.id
   					ORDER BY r.id

				) as room
				on  geom.room_id=room.id
				AND geom.room_id='.$roomid.'
				group by id_room
				order by id_room';
	
		
				$resultnew=pg_query($dbconn3, $sqlnew);  
			     if (!$resultnew) {
                   echo "An error occured. \n";
                   exit;
                    }     
			
		          $mydatanew=array();	  
	             $i=0;
                 while ($rownew = pg_fetch_row($resultnew))
                    {
                   $gsondatanew='{"type": "FeatureCollection","crs": { "type": "name", "properties": { "name": "urn:ogc:def:crs:OGC:1.3:CRS84","building":"'.$buildingid.'","room_id":"'.$rownew[0].'"} },"features":';
			       $gsondatanew.='[{ "type": "Feature", "properties": {}, "geometry":';
                   $mydatanew[$i]=$gsondatanew.$rownew[1]."}]}";
				   //$gsondata.=$mydata[$i];
				   $i++;
	                } 	
				return $mydatanew;
				
			  }	
             else 
			 {
			 	
				return $mydata;
				
			 }	
		
	  
	
	}	


/////////////////////////////////////DYNAMIC QUERY///////////////////////////////////////////
public function dynamicqueries($whereclause)
{
	
	$dbconn3 = pg_connect("host=$this->Server port=$this->Port dbname=$this->Database user=$this->Username password=$this->Password ")or die('connection failed');	
	    $sql='SELECT id FROM building WHERE ';
		$sql.= $whereclause;  
		
		$result=pg_query($dbconn3, $sql);
		$mydata=array();	  
	    $i=0;
        while ($row = pg_fetch_row($result))
               {

                $mydata[$i]=$row[0];
				//$gsondata.=$mydata[$i];
				$i++;
	           } 	
			   
	 return $mydata;
	
}		

	
}



