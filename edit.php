<?php

// Check if the ID parameter is set
if(isset($_GET['id'])) {
// Connect to the database (replace dbname, username, password with actual values)
$mysqli = new mysqli("localhost", "root", "", "test");

// Check connection
    if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
    }

// Retrieve the user's ID from the URL parameter
$userId = $_GET['id'];

// Insert data into users table
$sql = "SELECT * FROM users WHERE id =?" ;
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

// Check if the user exists
        if ($result->num_rows === 1) {
    // Fetch the user's data
             $userData = $result->fetch_assoc();
        } else {
    // If the user does not exist, redirect the user back to the page where they came from or display an error message
                 header("Location: index.php");
                exit();
        }

// Close the prepared statement and database connection
        $stmt->close();
        $mysqli->close();
        } 
    else {
    // If no ID parameter is set, redirect the user back to the page where they came from or display an error message
                header("Location: index.php");
                exit();
}

?>
<a href="dispaly_users.php">see records</a>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
    <div class="container">
        <h1>Edit User</h1>
        <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $userData['name']; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $userData['email']; ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?php echo $userData['phone']; ?>">
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address"><?php echo $userData['address']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>