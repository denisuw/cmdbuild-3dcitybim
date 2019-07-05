<?php

	include 'config/database.php';
	if(isset($_POST['param'])){
		$result = array();
		$name = strtolower($_POST['param']);
		
		if($name !== '') {
			
			$querybase = $pdo->prepare("SELECT * FROM basemap where table_name != '' ORDER BY sequence");
			$querybase->execute();
	
			$rowbase = $querybase->fetchAll();
			foreach($rowbase as $row) {	
				$NamaLayer = $row[1];
				$NamaTable = $row['table_name'];
			   
				//echo $NamaTable;
				
				$sql1 =  'SELECT a."Id", a."Name", ST_AsGeoJson(ST_centroid(b."Geometry")) AS geo FROM "'.$NamaTable.'" a JOIN "Detail_'.$NamaTable.'_the_geom" b ON a."Id" = b."Master" WHERE LOWER (a."Name") LIKE ';
				
				$sql2 = "'%{$name}%'";
				
				//echo $sql1 .$sql2;
				
				$stmt = $pdo->prepare($sql1.$sql2);
				$stmt->execute();

				$rowdata = $stmt->fetchAll();
				$result[$NamaLayer] = $rowdata;
			}
	
			echo json_encode(['data' => $result]);
			die();
			if($rowbase) {
				echo json_encode(['data' => $result, 'error_status' => false]);
			} else {
				echo json_encode(['error_status' => true,'error' => "tidak bisa menemukan dengan keyword {$name}"]);
			}
			
			/*$sql1 =  'SELECT "Name", ST_AsGeoJson(ST_centroid("Geometry")) AS geo FROM view_building_geom WHERE LOWER ("Name") LIKE ';
			$sql2 = "'%{$name}%'";
			
			$stmt = $pdo->prepare($sql1.$sql2);
			$stmt->execute();

			$row = $stmt->fetchAll();
			$result['gedung'] = $row;

			$sqlR1 =  'SELECT DISTINCT "NamaRuang", ST_AsGeoJson(ST_centroid("Geometry")) AS geo FROM view_building_room_geom WHERE LOWER ("NamaRuang") LIKE ';
			$sqlR2 = "'%{$name}%'";
			
			$stmt2 = $pdo->prepare($sqlR1.$sqlR2);
			
			$stmt2->execute();
			$row2 = $stmt2->fetchAll();
			$result['ruangan'] = $row2;
			echo json_encode(['data' => $result]);
			die();
			if($row) {
				echo json_encode(['data' => $result, 'error_status' => false]);
			} else {
				echo json_encode(['error_status' => true,'error' => "tidak bisa menemukan dengan keyword {$name}"]);
			}*/
			// $stmt = $pdo->prepare("SELECT DISTINCT ON (nm_gedung) nm_gedung, ST_AsGeoJson(geom) AS geo FROM gedung WHERE LOWER (nm_gedung) LIKE '%{$name}%'");
			// $stmt->execute();

			// $row = $stmt->fetchAll();
			// if($row) {
			// 	echo json_encode(['data' => $row, 'error_status' => false]);
			// } else {
			// 	echo json_encode(['error_status' => true,'error' => "tidak bisa menemukan dengan keyword {$name}"]);
			// }
		} else {
			echo json_encode(['error_status' => true,'error' => "keyword kosong"]);
		}
	}