<?php
$string="";

//////////////////////////////////////////////////////////////////CONNECTION ////////////////////////////////////////////////////////////		
//check the connection of the database
if (isset($_GET['request'])) 
{
	if($_GET['request']==0)
	{
      require_once('connect.php');//pernei stoixeia sindesis
      $dbconn3 = pg_connect("host=$Server port=$Port dbname=$Database user=$Username password=$Password")or die("Connection Fail"); 

     $string= $Database;
     echo $string;

	}
	
//////////////////////////////////////////////////////////////////ALL DATA ////////////////////////////////////////////////////////////			
	//create dynamic json file from database
	if($_GET['request']==1)
	{
	require_once('connect.php');//connection data
	include "3DcityDBWrapper.php";	
	$citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	$jsonresult=$citydb->getAllGeometryData();
	header("Content-Type: application/json");
	echo $jsonresult;
		
	}	
	
//////////////////////////////////////////////////////////////////BUILDINGS////////////////////////////////////////////////////////////			
	//for every building ///
	if($_GET['request']==2)
	    {
	    $lod=$_POST['lod'];
		//$lod=2;
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getbuildingbaselod($lod);
	    // header("Content-Type: application/json");
	//for ($i=0;$i<sizeof($jsonresult);$i++)
	// {
	    echo json_encode($jsonresult); 
	  //}	
	}	
	
	
//////////////////////////////////////////////////////////////////SURFACE DATA ////////////////////////////////////////////////////////////			
	//check if exist surfacedata 
	if($_GET['request']==3)
	    {
	    $lod=$_POST['lod'];
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->checkifexistthematicdatabylod($lod);
	    // header("Content-Type: application/json");
	//for ($i=0;$i<sizeof($jsonresult);$i++)
	// {
	    echo $jsonresult[0]; 
	  //}	
	   }	

	if($_GET['request']==4)
	    {
	    $lod=$_POST['lod'];
	   //$lod=2;
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofsurfacebasebuilding($lod);

	    echo json_encode($jsonresult); 
	    }
	    
	   //get all buildings 	base lod
	  if($_GET['request']==5)
	    {
	   $lod=$_POST['lod'];
	   //$lod=2;
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getbuildingsbaselod($lod);
          if(sizeof($jsonresult)==0)
		      {
		 	
		       $jsonresult=$citydb->getbuildings();
			   echo json_encode($jsonresult);
			
		       }
		      else {
			 echo json_encode($jsonresult); 
		       }
	    //return $jsonresult; 
	    }	
		
		
		if($_GET['request']==20)
	    {
	    	
			//POINT(499465.61392504285 6783280.655110053)
	 $coord=$_POST['coord'];
	 $type=$_POST['type'];
	 

	   //$lod=2;
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getbuildingsbyquery($coord,$type);
		 
		    if(sizeof($jsonresult)==0)
		      {
		 	
		       echo sizeof($jsonresult);
			
		       }
		      else {
			 echo json_encode($jsonresult); 
		       }
		 

	    //return $jsonresult; 
	    }	
		
		
		
	
		//detail of surface data by building
	if($_GET['request']==6)
	    {
	 
	      $lod=$_POST['lod'];
		  $buidingid=$_POST['buidingid'];
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofsurfacebasebuildingid($lod,$buidingid);
         echo json_encode($jsonresult); 
	    //return $jsonresult; 
	    }	
		
//////////////////////////////////////////////////////////////////BUILDING ADDRESS INFORMATION////////////////////////////////////////////////////////////			
		//for building address
		if($_GET['request']==7)
	    {
	 
	      //$lod=$_POST['lod'];;
		  $buildingid=$_POST['buildingid'];
		  //$buildingid=18;
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getaddressbybuilding($buildingid);
          if(sizeof($jsonresult)==0)
		 {
		 	
		echo sizeof($jsonresult);
			
		 }
		 else {
			 echo json_encode($jsonresult); 
		 }
	    //return $jsonresult; 
	    }	
//////////////////////////////////////////////////////////////////BUILDING INFORMATION////////////////////////////////////////////////////////////			
	//for building information
			if($_GET['request']==8)
	    {
	 
	      //$lod=$_POST['lod'];;
		  $buildingid=$_POST['buildingid'];
		//$buildingid=29;
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getinformationbybuilding($buildingid);
         if(sizeof($jsonresult)==0)
		 {
		 	
		echo sizeof($jsonresult);
			
		 }
		 else {
			 echo json_encode($jsonresult); 
		 }
	    //return $jsonresult; 
	    }	
		
//////////////////////////////////////////////////////////////////OPENING////////////////////////////////////////////////////////////			
		
		///// for opening geometry per building and lods
		if($_GET['request']==9)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		  $buidingid=$_POST['buidingid'];
		  $lodopening=$_POST['lodopening'];
		  $lodthematic=$_POST['lodthematic'];
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofopeningbasebuildingid($lodthematic,$lodopening,$buidingid);
		 
		 if(sizeof($jsonresult)==0)
		 {
		 	
		echo sizeof($jsonresult);
			
		 }
		 else {
			 echo json_encode($jsonresult); 
		 }
         

         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
		
		
				///// for  current opening geometry per building and lods
		if($_GET['request']==13)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		  $buidingid=$_POST['buidingid'];
		  $lodopening=$_POST['lodopening'];
		  $lodthematic=$_POST['lodthematic'];
		  $openingid=$_POST['openingid'];
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getcurrentopeningbasebuildingid($lodthematic,$lodopening,$openingid,$buidingid);
		 
		 if(sizeof($jsonresult)==0)
		 {
		 	
		echo sizeof($jsonresult);
			
		 }
		 else {
			 echo json_encode($jsonresult); 
		 }
         

         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }	
		
		
		
			
		
//////////////////////////////////////////////////////////////////BUILDING INSTALLATION////////////////////////////////////////////////////////////		
			///// for building installation per building and lods
		if($_GET['request']==10)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		  $buildingid=1;
		  $lod=4;
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofbuildinginstallation($lod,$buildingid);
         echo json_encode($jsonresult); 
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
		
//////////////////////////////////////////////////////////////////ROOM////////////////////////////////////////////////////////////			
		//for room
		if($_GET['request']==11)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		$buildingid=$_POST['buildingid'];
		 $solid=$_POST['solid'];
		 if($solid==1)
		 {
		 	
			$mysolid=TRUE;
		 }
		 else {
		 	
			$mysolid=FALSE;
		 
			 
		 }
		// $buildingid=1;
		//$solid=FALSE;
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofroom($mysolid,$buildingid);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
		
				//for current room
		if($_GET['request']==14)
	    {
	 

		  $buildingid=$_POST['buildingid'];
		  $solid=$_POST['solid'];
		  $roomid=$_POST['roomid'];
		   if($solid==1)
		 {
		 	
			$mysolid=TRUE;
		 }
		 else {
		 	
			$mysolid=FALSE;
		 
			 
		 }
		  
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofcurrentroom($solid,$roomid,$buildingid);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
		
		
		
		
		
//////////////////////////////////////////////////////////////////BUILDING FURNITURE////////////////////////////////////////////////////////////			
		//for building furniture by room and building
		if($_GET['request']==12)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		  $buidingid=1;
		  $room=91;
		
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofbuildingfurniture($room,$buidingid);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
		
		
		

//////////////////////////////////////////////LIST OF DATA BASE VALUE///////////////////////////////////////////////		
		//list of data base value
		if($_GET['request']==15)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		 // $value=$_POST['value'];
		 $value=$_POST['value'];
		  //$room=91;
		
		  
	     require_once('connect.php');//connection data
	     include "extrafunction.php";	
	     $extrafun = new extrafunctionWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$extrafun->getdatainformation($value);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }		
	
////////////////////////////////////////////////////DYNAMIC QUERY///////////////////////////////////////////
		if($_GET['request']==16)
	    {
	 
	      //$lod=$_POST['lod'];;
		 // $buidingid=$_POST['buidingid'];
		 // $value=$_POST['value'];
		$whereclause=$_POST["whereclause"];
		  //$room=91;
		
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->dynamicqueries($whereclause);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }	

///////////////////////////////////////////////////BUILDING INSTALLATION////////////////////////////////////////////////////////
			if($_GET['request']==17)
	    {
	 
	      $lod=$_POST['lodinstallation'];
		  $buildingid=$_POST['buildingid'];
		 // $buildingid=1;
		 // $room=91;
		
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofbuildinginstallation($lod,$buildingid);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
	
	
		if($_GET['request']==18)
	    {
	 
	      $lod=$_POST['lodinstallation'];
		  $buildingid=$_POST['buildingid'];
		 $installationid=$_POST['installationid'];
		 // $room=91;
		
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofcurrentbuildinginstallation($installationid,$lod,$buildingid);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
	
	///////////////////////////////////////////////////BUILDING FURNITURE////////////////////////////////////////////////////////
			if($_GET['request']==19)
	    {
	 
	      $room=$_POST['roomid'];
		  $buildingid=$_POST['buildingid'];

		 // $room=91;
		
		  
	     require_once('connect.php');//connection data
	     include "3DcityDBWrapper.php";	
	     $citydb = new cityDBWrapper($Server,$Port,"citydb",$Database, $Username,$Password);	
	
	     $jsonresult=$citydb->getgeometryofbuildingfurniture($room,$buildingid);
		 if(sizeof($jsonresult)==0)
		 {
		 	echo 0;
			
		 } else{
         echo json_encode($jsonresult);
		 } 
         // echo $jsonresult;
         //check if exist with [] value of $jsonresult
         //if return [] then no data in current lods
	    //return $jsonresult; 
	    }
	
	
	
	
	
	
	
	
	
	
	
}
?>