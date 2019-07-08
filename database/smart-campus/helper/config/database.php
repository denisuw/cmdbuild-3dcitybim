<?php

	$pdo = new PDO('pgsql:dbname=petakampusitb;host=localhost;port=5437;user=postgres;password=12345') OR die("There's something wrong with database");
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
