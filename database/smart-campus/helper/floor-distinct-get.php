<?php
	include 'config/database.php';
	$stmt = $pdo->query("SELECT * FROM view_floor_distinct_get");
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	print_r(json_encode(['error'=>false,'data'=>$row]));
