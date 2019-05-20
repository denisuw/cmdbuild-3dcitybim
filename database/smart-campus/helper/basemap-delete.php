<?php require 'header.php'; ?>

<?php  
	if(isset($_GET['id'])) {
		$id = $_GET['id'];
	}
	$stmt = $pdo->prepare("DELETE FROM basemap WHERE id = :id");
	$stmt->execute(array(
		'id' => $id
	));
	header('location: /helper/basemap.php');
?>

<?php require 'footer.php'; ?>