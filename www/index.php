
<?php
	require "QueryManager.php"
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"> 
	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </head>
  <body>
	<div class="container">
		<h1>Cego study job application</h1>
		<div class="row">
			<div class="col-lg-4">	
				<form class="form-horizontal" role="form" method="post" action="index.php">
					<div class="form-group">
						<label for="usr">Input SQL query:</label>
						<input type="text" class="form-control" name="sql" id="usr">
					</div>
				
					<div class="form-group">
							<input id="submit" name="submit" type="submit" value="Send" class="btn btn-primary">
					</div>
				</div>
			</form>
			<div class="row">
				<div class="col-lg-12">
					<?php if(sendSql()){ ?>
						<h3>sql is successful</h3> 
					<?php } ?>
				</div>
			</div>
			<div class="col-lg-4">
			</div>
			<div class="col-lg-4">
			</div>
		</div>
</form>
	</div>
  </body>
</html>