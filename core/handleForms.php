<?php 
session_start(); // Start the session at the top

require_once 'dbConfig.php'; 
require_once 'models.php';

if (isset($_POST['registerUserBtn'])) {
	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {
		$insertQuery = insertNewUser($pdo, $username, $password);
		if ($insertQuery) {
			header("Location: ../login.php");
		} else {
			header("Location: ../register.php");
		}
	} else {
		$_SESSION['message'] = "Please make sure the input fields are not empty for registration!";
		header("Location: ../login.php");
	}
}

if (isset($_GET['logoutAUser'])) {
	// Ensure session is started, destroy the session to log out the user
	session_start();
	session_unset();
	session_destroy();

	// Redirect to the login page after logout
	header("Location: ../loginRegister.php");
	exit();
}

if (isset($_POST['loginUserBtn'])) {
	$username = $_POST['username'];
	$password = sha1($_POST['password']);

	if (!empty($username) && !empty($password)) {
		$loginQuery = loginUser($pdo, $username, $password);
		if ($loginQuery) {
			$_SESSION['username'] = $username; // Store username in session
			header("Location: ../index.php");
		} else {
			header("Location: ../login.php");
		}
	} else {
		$_SESSION['message'] = "Please make sure the input fields are not empty for the login!";
		header("Location: ../login.php");
	}
}

// Rest of your form handling code for insert, edit, delete operations
// No need to repeat the logout section here; it has already been handled above

if (isset($_POST['insertCustomerBtn'])) {
	if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['purpose'])) {
		$query = insertCustomer($pdo, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['purpose']);
		if ($query) {
			header("Location: ../index.php");
		} else {
			echo "Insertion failed";
		}
	} else {
		echo "All fields are required.";
	}
}

if (isset($_POST['editCustomerBtn'])) {
	if (!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['email']) && !empty($_POST['purpose'])) {
		$query = updateCustomer($pdo, $_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['purpose'], $_GET['customer_id']);
		if ($query) {
			header("Location: ../index.php");
		} else {
			echo "Edit failed";
		}
	} else {
		echo "All fields are required.";
	}
}

if (isset($_POST['deleteCustomerBtn'])) {
	$query = deleteCustomer($pdo, $_GET['customer_id']);
	if ($query) {
		header("Location: ../index.php");
	} else {
		echo "Deletion failed";
	}
}

if (isset($_POST['insertNewPCBtn'])) {
	if (!empty($_POST['pcName']) && !empty($_POST['pcSpecs'])) {
		$query = insertPC($pdo, $_POST['pcName'], $_POST['pcSpecs'], $_GET['customer_id']);
		if ($query) {
			header("Location: ../viewpcs.php?customer_id=" . $_GET['customer_id']);
		} else {
			echo "Insertion failed";
		}
	} else {
		echo "All fields are required.";
	}
}

if (isset($_POST['editPCBtn'])) {
	if (!empty($_POST['pcName']) && !empty($_POST['pcSpecs'])) {
		$query = updatePC($pdo, $_POST['pcName'], $_POST['pcSpecs'], $_GET['pc_id']);
		if ($query) {
			header("Location: ../viewpcs.php?customer_id=" . $_GET['customer_id']);
		} else {
			echo "Update failed";
		}
	} else {
		echo "All fields are required.";
	}
}

if (isset($_POST['deletePCBtn'])) {
	$query = deletePC($pdo, $_GET['pc_id']);
	if ($query) {
		header("Location: ../viewpcs.php?customer_id=" . $_GET['customer_id']);
	} else {
		echo "Deletion failed";
	}
}
?>
