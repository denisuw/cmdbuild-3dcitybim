<?php

	$pdo = new PDO('pgsql:dbname=openmaint-itb;host=localhost;port=5432;user=postgres;password=admin') OR die("There's something wrong with database");
	$pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
