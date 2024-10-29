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
	<a href="index.php">Return to home</a>
	<?php $getCustomerByID = getCustomerByID($pdo, $_GET['customer_id']); ?>
	<h1>Customer: <?php echo $getCustomerByID['first_name'] . ' ' . $getCustomerByID['last_name']; ?></h1>
	<h1>Add New Virtual PC</h1>
	<form action="core/handleForms.php?customer_id=<?php echo $_GET['customer_id']; ?>" method="POST">
		<p>
			<label for="pcName">PC Name</label> 
			<input type="text" name="pcName" required>
		</p>
		<p>
			<label for="pcSpecs">PC Specs</label> 
			<input type="text" name="pcSpecs" required>
			<input type="submit" name="insertNewPCBtn">
		</p>
	</form>

	<table style="width:100%; margin-top: 50px;">
	  <tr>
	    <th>PC ID</th>
	    <th>PC Name</th>
	    <th>PC Specs</th>
	    <th>PC Owner</th>
	    <th>Date Added</th>
	    <th>Action</th>
	  </tr>
	  <?php $getPCsByCustomer = getPCsByCustomer($pdo, $_GET['customer_id']); ?>
	  <?php foreach ($getPCsByCustomer as $row) { ?>
	  <tr>
	  	<td><?php echo $row['pc_id']; ?></td>	  	
	  	<td><?php echo $row['pc_name']; ?></td>	  	
	  	<td><?php echo $row['pc_specs']; ?></td>	  	
	  	<td><?php echo $row['pc_owner']; ?></td>	  	
	  	<td><?php echo $row['date_added']; ?></td>
	  	<td>
	  		<a href="editpc.php?pc_id=<?php echo $row['pc_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>">Edit</a>
	  		<a href="deletepc.php?pc_id=<?php echo $row['pc_id']; ?>&customer_id=<?php echo $_GET['customer_id']; ?>">Delete</a>
	  	</td>	  	
	  </tr>
	<?php } ?>
	</table>
</body>
</html>
