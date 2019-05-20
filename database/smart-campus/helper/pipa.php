<?php

	$pdo = new PDO('pgsql:dbname=peta_kampus_v2;host=localhost;port=5433;user=postgres;password=amirahfarah050895') OR die("There's something wrong with database");
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	$result = array();
	
	$stmt = $pdo->prepare("select st_asgeojson(geom) from pipa");
	$stmt->execute();

	$row = $stmt->fetchAll();
	$result['pipa'] = $row;
	echo json_encode(['data' => $result]);
	
	die();
	if($row) {
		echo json_encode(['data' => $result, 'error_status' => false]);
	} else {
		echo json_encode(['error_status' => true,'error' => "tidak bisa menemukan data"]);
	}
	
	?>