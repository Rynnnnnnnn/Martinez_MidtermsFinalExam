<?php require_once 'core/dbConfig.php'; ?>
<?php require_once 'core/models.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<?php $getPCByID = getPCByID($pdo, $_GET['pc_id']); ?>
	<h1>Are you sure you want to delete this virtual PC?</h1>
	<div class="container" style="border-style: solid; height: 400px;">
		<h2>PC Name: <?php echo $getPCByID['pc_name'] ?></h2>
		<h2>PC Specs: <?php echo $getPCByID['pc_specs'] ?></h2>
		<h2>PC Owner: <?php echo $getPCByID['pc_owner'] ?></h2>
		<h2>Date Added: <?php echo $getPCByID['date_added'] ?></h2>

		<div class="deleteBtn" style="float: right; margin-right: 10px;">

			<form action="core/handleForms.php?pc_id=<?php echo $_GET['pc_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
				<input type="submit" name="deletePCBtn" value="Delete">
			</form>			
			
		</div>	

	</div>
</body>
</html>
