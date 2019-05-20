	<?php  require 'header.php'; ?>
	<?php  
		if(isset($_POST['submit'])) {
			$name = $_POST['name'];
			$title = $_POST['title'];
			$baseLayer = $_POST['base_layer'];
			$maxRes = $_POST['max_res'];
			$minRes = $_POST['min_res'];
			$url = $_POST['url'];
			$params = $_POST['params'];
			$active = $_POST['active'];
			$visible = $_POST['visible'];
			$opacity = $_POST['opacity'];
			$visible = $_POST['visible'];
			$layerOrder = $_POST['layer_order'];
			$stmt = $pdo->prepare("INSERT INTO basemap(name, title, base_layer, visible, max_resolution, min_resolution, url, params, opacity, active, sequence) VALUES (:name, :title, :baseL, :visible, :max_resolution, :min_resolution, :url, :params, :opacity, :active, :sequence)");
			$stmt->execute(array(
				"name" => $name,
				'title' => $title, 
				'baseL' => $baseLayer, 
				'visible' => $visible,
				'max_resolution' => $maxRes, 
				'min_resolution' => $minRes,
				'url' => $url,
				'params' => $params, 
				'opacity' => $opacity,
				'active' => $active,
				'sequence' => $layerOrder
			));
			if(!$stmt) {
				echo "Error";
			} else {
				echo "Success";
				header('location: /helper/basemap.php');
			}
		}
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">Create Basemap</h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 col-md-offset-3">
				<form action="" method="POST">
					<div class="form-group">
						<label for="name">Name</label>
						<input type="text" name="name" class="form-control" id="name">
					</div>
					<div class="form-group">
						<label for="title">Title</label>
						<input type="text" name="title" class="form-control" id="title">
					</div>
					<div class="form-group">
						<label for="base_ayer">Base Layer</label>
						<select name="base_layer" id="base_layer" class="form-control">
							<option value="background">Background</option>
							<option value="overlay">Overlay</option>
							<option value="tile">Tile</option>
						</select>
					</div>
					<div class="row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="max_res">Max Resolution</label>
								<input type="text" name="max_res" class="form-control" id="max_res">
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<label for="min_res">Min Resolution</label>
								<input type="text" name="min_res" class="form-control" id="min_res">
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
		</div>
	</div>
	<?php require 'footer.php'; ?>