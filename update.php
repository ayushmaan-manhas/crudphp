<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Connect to the database (replace dbname, username, password with actual values)
    $mysqli = new mysqli("localhost", "root", "", "test");

    // Check connection
    if ($mysqli->connect_error) {
        die("Connection failed: " . $mysqli->connect_error);
    }

    // Retrieve form data
    $userId = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    // Prepare and execute a query to update the user's data
    $sql = "UPDATE users SET name=?, email=?, phone=?, address=? WHERE id=?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $userId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        // Redirect the user back to the index page with a success message
        header("Location: dispaly_users.php?message=success");
        exit();
    } else {
        // Redirect the user back to the edit page with an error message
        header("Location: edit.php?id=$userId&message=error");
        exit();
    }

    // Close the prepared statement and database connection
    $stmt->close();
    $mysqli->close();
} else {
    // If the form is not submitted, redirect the user back to the edit page
    header("Location: edit.php?id=$userId");
    exit();
}
?>
