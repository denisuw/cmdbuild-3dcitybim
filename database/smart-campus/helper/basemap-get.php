<?php
	include 'config/database.php';
	$stmt = $pdo->query("SELECT * FROM basemap ORDER BY sequence");
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	print_r(json_encode(['error'=>false,'data'=>$row]));
