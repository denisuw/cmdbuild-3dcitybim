<?php include 'header.php'; ?>

<?php  

	if(isset($_GET['id'])) {
		$id = $_GET['id'];
	} else {
		header('location: /helper/basemap.php');
	}

	$stmt = $pdo->prepare("SELECT * FROM basemap WHERE id = {$_GET['id']}");
	$stmt->execute();
	$item = $stmt->fetch();
?>

<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">Edit Basemap <?php echo $item['name'] ?></h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form action="" method="POST">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name" value="<?php echo $item['name'] ?>">
					</div>
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" id="title" value="<?php echo $item['title'] ?>">
					</div>
					<div class="form-group">
						<label for="base_ayer">Base Layer</label>
						<select name="base_layer" id="base_layer" class="form-control">
							<option value="background" <?php echo ($item['base_layer'] == 'background' ) ? "selected" : ''  ?>>Background</option>
							<option value="overlay" <?php echo ($item['base_layer'] == 'overlay' ) ? "selected" : ''  ?> >Overlay</option>
							<option value="tile" <?php echo ($item['base_layer'] == 'tile' ) ? "selected" : ''  ?>>Tile</option>
						</select>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="max_res">Max Resolution</label>
								<input type="text" name="max_res" class="form-control" id="max_res" value="<?php echo $item['max_resolution'] ?>">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="min_res">Min Resolution</label>
								<input type="text" name="min_res" class="form-control" id="min_res" value="<?php echo $item['min_resolution'] ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="url">URL</label>
								<input type="text" id="url" name="url" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="params">Parameter</label>
								<input type="text" id="params" name="params" class="form-control">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="visible">Visible</label><br>
						 		<input type="checkbox" name="visible" id="visible" class="checkbox">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="active">Active</label><br>
						 		<input type="checkbox" name="active" id="active" class="checkbox">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="opacity">Opacity</label>
								<input type="text" name="opacity" id="opacity" class="form-control">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="layer_order">Layer order</label>
								<input type="text" name="layer_order" id="layer_order" class="form-control">
							</div>
						</div>
					</div>
					<button type="submit" class="btn btn-primary" name="submit">Create</button>
				</form>
			</div>
		</div><br>
	</div>



<?php include 'footer.php'; ?>