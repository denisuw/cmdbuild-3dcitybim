<?php
	include 'config/database.php';
	$stmt = $pdo->query("SELECT * FROM view_basemap_category ORDER BY category_seq,name");
	$row = $stmt->fetchAll(PDO::FETCH_OBJ);
	print_r(json_encode(['error'=>false,'data'=>$row]));
