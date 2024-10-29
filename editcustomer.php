<?php require_once 'core/handleForms.php'; ?>
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
	<?php $getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']); ?>
	<h1>Edit the customer!</h1>
	<form action="core/handleForms.php?customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
		<p>
			<label for="firstName">First Name</label> 
			<input type="text" name="firstName" value="<?php echo $getCustomerByID['first_name']; ?>" required>
		</p>
		<p>
			<label for="lastName">Last Name</label> 
			<input type="text" name="lastName" value="<?php echo $getCustomerByID['last_name']; ?>" required>
		</p>
		<p>
			<label for="email">Email</label> 
			<input type="email" name="email" value="<?php echo $getCustomerByID['email']; ?>" required>
		</p>
		<p>
			<label for="purpose">Purpose</label> 
			<input type="text" name="purpose" value="<?php echo $getCustomerByID['purpose']; ?>" required>
			<input type="submit" name="editCustomerBtn">
		</p>
	</form>
</body>
</html>
