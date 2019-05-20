
	<?php 
		require 'header.php'; 
	    $stmt = $pdo->query("SELECT * FROM basemap order by sequence");
	?>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h2 class="text-center">Basemap &amp; Tile</h2>
				<hr>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table table-bordered" border="1px"> 
					<thead>
						<tr>
							<td>No</td>
							<td>Name</td>
							<td>Title</td>
							<td>URL</td>
							<td>Parameter</td>
							<td>Action</td>
						</tr>
					</thead>
					<tbody>
						<?php while ( $row = $stmt->fetch() ) { ?>
							<tr>
								<td><?php echo $row['id']; ?></td>
								<td><?php echo ucfirst($row['name']); ?></td>
								<td><?php echo ucfirst($row['title']); ?></td>
								<td><?php echo $row['url']; ?></td>
								<td><?php echo $row['params']; ?></td>
								<td>
									<div class="row">
										<div class="col-md-12">
											<a href="/helper/basemap-edit.php?id=<?php echo $row['id']; ?>">
												<span class="pull-left" style="margin-right: 5px;">Update </span>
											</a>
											<a href="/helper/basemap-delete.php?id=<?php echo $row['id']; ?>">
												<span class="pull-left" style="margin-right: 5px;">Delete </span>
											</a>
										</div>
									</div>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
		<div class="row">
			<div class="col-md-4">
				<a href="/helper/basemap-create.php"><button class="btn btn-default">Create</button></a>
			</div>
		</div>
	</div>
	<?php require 'footer.php'; ?>