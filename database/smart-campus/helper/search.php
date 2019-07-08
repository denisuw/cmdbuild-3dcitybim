<?php

	include 'config/database.php';
	if(isset($_POST['param'])){
		$result = array();
		$name = strtolower($_POST['param']);

		if($name !== '') {
			$stmt = $pdo->prepare("SELECT nm_gedung, ST_AsGeoJson(ST_centroid(geom)) AS geo FROM gedung WHERE LOWER (nm_gedung) LIKE '%{$name}%'");
			$stmt->execute();

			$row = $stmt->fetchAll();
			$result['gedung'] = $row;

			$stmt2 = $pdo->prepare("SELECT DISTINCT nama_ruang, ST_AsGeoJson(ST_centroid(geom)) AS geo FROM ruangan WHERE LOWER (nama_ruang) LIKE '%{$name}%'");
			$stmt2->execute();
			$row2 = $stmt2->fetchAll();
			$result['ruangan'] = $row2;
			echo json_encode(['data' => $result]);
			die();
			if($row) {
				echo json_encode(['data' => $result, 'error_status' => false]);
			} else {
				echo json_encode(['error_status' => true,'error' => "tidak bisa menemukan dengan keyword {$name}"]);
			}
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