<?php require_once 'core/models.php'; ?>
<?php require_once 'core/dbConfig.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="styles.css">
</head>
<body>
	<a href="viewpcs.php?customer_id=<?php echo $_GET['customer_id']; ?>">
	View The PCs</a>
	<h1>Edit the virtual PC!</h1>
	<?php $getPCByID = getPCByID($pdo, $_GET['pc_id']); ?>
	<form action="core/handleForms.php?pc_id=<?php echo $_GET['pc_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
		<p>
			<label for="pcName">PC Name</label> 
			<input type="text" name="pcName" 
			value="<?php echo $getPCByID['pc_name']; ?>">
		</p>
		<p>
			<label for="pcSpecs">PC Specs</label> 
			<input type="text" name="pcSpecs" 
			value="<?php echo $getPCByID['pc_specs']; ?>">
			<input type="submit" name="editPCBtn">
		</p>
	</form>
</body>
</html>
