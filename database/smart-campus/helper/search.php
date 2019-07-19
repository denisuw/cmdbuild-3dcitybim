<?php

	include 'config/database.php';
	if(isset($_POST['param'])){
		$result = array();
		$name = strtolower($_POST['param']);
		$bs = "'basement'";
		$bs2 = "'basement 2'";
		$lt1 = "'lantai 1'";
		$lt2 = "'lantai 2'";
		$lt3 = "'lantai 3'";
		$lt4 = "'lantai 4'";
		$lt5 = "'lantai 5'";
		$lt6 = "'lantai 6'";
		$lt7 = "'lantai 7'";
		$lt8 = "'lantai 8'";
		
		if($name !== '') {
			
			$querybase = $pdo->prepare("SELECT * FROM basemap where table_name != '' ORDER BY sequence");
			$querybase->execute();
			$nmlntai = -99;
			$rowbase = $querybase->fetchAll();
			
			$cnt = 0;
			foreach($rowbase as $row) {	
				$NamaLayer = $row[1];
				$NamaTable = $row['table_name'];
			   
				//echo $NamaTable;
				
				$sql1 =  'SELECT a."Id", a."Name", ST_AsGeoJson(ST_centroid(b."Geometry")) AS geo,ST_AsGeoJSON(b."Geometry") AS geom, '.$nmlntai.' as NamaLantai FROM "'.$NamaTable.'" a JOIN "Detail_'.$NamaTable.'_the_geom" b ON a."Id" = b."Master" WHERE LOWER (a."Name") LIKE ';
				
				
				if($NamaTable == "Room")
				{
					$sql1 =  'SELECT a."Id", a."Name", ST_AsGeoJson(ST_centroid(b."Geometry")) AS geo,ST_AsGeoJSON(b."Geometry") AS geom, CASE'.
								' WHEN LOWER(c."Name")::text = '.$bs.'::text THEN (-1)'.
								' WHEN LOWER(c."Name")::text = '.$bs2.'::text THEN (-2)'.
								' WHEN LOWER(c."Name")::text = '.$lt1.'::text THEN 0'.
								' WHEN LOWER(c."Name")::text = '.$lt2.'::text THEN 1'.
								' WHEN LOWER(c."Name")::text = '.$lt3.'::text THEN 2'.
								' WHEN LOWER(c."Name")::text = '.$lt4.'::text THEN 3'.
								' WHEN LOWER(c."Name")::text = '.$lt5.'::text THEN 4'.
								' WHEN LOWER(c."Name")::text = '.$lt6.'::text THEN 5'.
								' WHEN LOWER(c."Name")::text = '.$lt7.'::text THEN 6'.
								' WHEN LOWER(c."Name")::text = '.$lt8.'::text THEN 7'.
								' ELSE 0'.
								' END AS NamaLantai FROM "'.$NamaTable.'" a JOIN "Detail_'.$NamaTable.'_the_geom" b ON a."Id" = b."Master" JOIN "Floor" c ON a."Floor" = c."Id" WHERE LOWER (a."Name") LIKE ';
				}
				$sql2 = "'%{$name}%'";
				
				//cho $sql1;
				
				$stmt = $pdo->prepare($sql1.$sql2);
				$stmt->execute();

				$rowdata = $stmt->fetchAll();
				$cnt += count($rowdata);
				$result[$NamaLayer] = $rowdata;
			}
	
			echo json_encode(['data' => $result,'rowcount' => $cnt]);
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