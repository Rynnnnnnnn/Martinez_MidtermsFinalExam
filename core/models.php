<?php  

require_once 'dbConfig.php';

function insertNewUser($pdo, $username, $password, $first_name, $last_name, $dob) {

    if (empty($username) || empty($password) || empty($first_name) || empty($last_name) || empty($dob)) {
        $_SESSION['message'] = "All fields are required.";
        return false;
    }

    $checkUserSql = "SELECT * FROM user_passwords WHERE username = ?";
    $checkUserSqlStmt = $pdo->prepare($checkUserSql);
    $checkUserSqlStmt->execute([$username]);

    if ($checkUserSqlStmt->rowCount() == 0) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO user_passwords (username, password, first_name, last_name, dob) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $executeQuery = $stmt->execute([$username, $hashedPassword, $first_name, $last_name, $dob]);

        if ($executeQuery) {
            $_SESSION['message'] = "User successfully inserted";
            return true;
        } else {
            $_SESSION['message'] = "An error occurred during the query";
        }
    } else {
        $_SESSION['message'] = "User already exists";
    }
    return false;
}

function loginUser($pdo, $username, $password) {
    $sql = "SELECT * FROM user_passwords WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);

    if ($stmt->rowCount() == 1) {
        $userInfoRow = $stmt->fetch();
        $hashedPasswordFromDB = $userInfoRow['password'];

        if (password_verify($password, $hashedPasswordFromDB)) {
            $_SESSION['username'] = $username;
            $_SESSION['message'] = "Login successful!";
            return true;
        } else {
            $_SESSION['message'] = "Invalid password.";
        }
    } else {
        $_SESSION['message'] = "Username doesn't exist in the database. You may consider registration first.";
    }
    return false;
}

function getAllUsers($pdo) {
	$sql = "SELECT * FROM user_passwords";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute();

	if ($executeQuery) {
		return $stmt->fetchAll();
	}

}

function getUserByID($pdo, $user_id) {
	$sql = "SELECT * FROM user_passwords WHERE user_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$user_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}


function insertCustomer($pdo, $first_name, $last_name, $email, $purpose) {

	$added_by = $_SESSION['username'] ?? 'Unknown'; 

	$sql = "INSERT INTO customer (first_name, last_name, email, purpose, added_by) VALUES (?, ?, ?, ?, ?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $email, $purpose, $added_by]);

	if ($executeQuery) {
		return true;
	}
}

function updateCustomer($pdo, $first_name, $last_name, $email, $purpose, $customer_id) {

	$updated_by = $_SESSION['username'] ?? 'Unknown'; 

	$sql = "UPDATE customer
			SET first_name = ?,
				last_name = ?,
				email = ?, 
				purpose = ?,
				last_updated = NOW(),
				updated_by = ?
			WHERE customer_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$first_name, $last_name, $email, $purpose, $updated_by, $customer_id]);

	if ($executeQuery) {
		return true;
	}
}

function deleteCustomer($pdo, $customer_id) {
	$deleteCustomerPC = "DELETE FROM virtual_pc WHERE customer_id = ?";
	$deleteStmt = $pdo->prepare($deleteCustomerPC);
	$executeDeleteQuery = $deleteStmt->execute([$customer_id]);

	if ($executeDeleteQuery) {
		$sql = "DELETE FROM customer WHERE customer_id = ?";
		$stmt = $pdo->prepare($sql);
		$executeQuery = $stmt->execute([$customer_id]);

		if ($executeQuery) {
			return true;
		}

	}
	
}

function getAllCustomers($pdo) {
    $sql = "SELECT customer_id, first_name, last_name, email, purpose, date_added, added_by, last_updated, updated_by FROM customer";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute();

    if ($executeQuery) {
        return $stmt->fetchAll();
    }
}


function getCustomerByID($pdo, $customer_id) {
    $sql = "SELECT customer_id, first_name, last_name, email, purpose, date_added, added_by, last_updated, updated_by 
            FROM customer 
            WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $executeQuery = $stmt->execute([$customer_id]);

    if ($executeQuery) {
        return $stmt->fetch();
    }
    return null;
}


function getPCsByCustomer($pdo, $customer_id) {
	
	$sql = "SELECT 
				virtual_pc.pc_id AS pc_id,
				virtual_pc.pc_name AS pc_name,
				virtual_pc.pc_specs AS pc_specs,
				virtual_pc.date_added AS date_added,
				CONCAT(customer.first_name,' ',customer.last_name) AS pc_owner
			FROM virtual_pc
			JOIN customer ON virtual_pc.customer_id = customer.customer_id
			WHERE virtual_pc.customer_id = ? 
			GROUP BY virtual_pc.pc_name;
			";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$customer_id]);
	if ($executeQuery) {
		return $stmt->fetchAll();
	}
}

function insertPC($pdo, $pc_name, $pc_specs, $customer_id) {
	$sql = "INSERT INTO virtual_pc (pc_name, pc_specs, customer_id) VALUES (?,?,?)";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$pc_name, $pc_specs, $customer_id]);
	if ($executeQuery) {
		return true;
	}

}

function getPCByID($pdo, $pc_id) {
	$sql = "SELECT 
				virtual_pc.pc_id AS pc_id,
				virtual_pc.pc_name AS pc_name,
				virtual_pc.pc_specs AS pc_specs,
				virtual_pc.date_added AS date_added,
				CONCAT(customer.first_name,' ',customer.last_name) AS pc_owner
			FROM virtual_pc
			JOIN customer ON virtual_pc.customer_id = customer.customer_id
			WHERE virtual_pc.pc_id  = ? 
			GROUP BY virtual_pc.pc_name";

	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$pc_id]);
	if ($executeQuery) {
		return $stmt->fetch();
	}
}

function updatePC($pdo, $pc_name, $pc_specs, $pc_id) {
	$sql = "UPDATE virtual_pc
			SET pc_name = ?,
				pc_specs = ?
			WHERE pc_id = ?
			";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$pc_name, $pc_specs, $pc_id]);

	if ($executeQuery) {
		return true;
	}
}

function deletePC($pdo, $pc_id) {
	$sql = "DELETE FROM virtual_pc WHERE pc_id = ?";
	$stmt = $pdo->prepare($sql);
	$executeQuery = $stmt->execute([$pc_id]);
	if ($executeQuery) {
		return true;
	}
}

?>
