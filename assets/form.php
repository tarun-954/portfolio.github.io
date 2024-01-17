<?php

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // ... (other code for validation and sanitization)

    // If there are errors, send a response back to the user
    if (!empty($errors)) {
        $response = array("success" => false, "message" => implode(" ", $errors));
    } else {
        // Process the form data and insert it into the MySQL database
        try {
            $pdo = new PDO("mysql:host=localhost;dbname=mydatabase", "username", "password");

            $stmt = $pdo->prepare("INSERT INTO form_data (name, email, category, priority, copy_email, not_a_robot, message) VALUES (?, ?, ?, ?, ?, ?, ?)");

            $stmt->execute([$name, $email, $category, $priority, $copyEmail, $notARobot, $message]);

            $response = array("success" => true, "message" => "Form submitted successfully");
        } catch (PDOException $e) {
            // Handle database connection errors
            $response = array("success" => false, "message" => "Error connecting to the database: " . $e->getMessage());
        }
    }

    // Send a JSON response back to the client
    header("Content-Type: application/json");
    echo json_encode($response);
    exit;
}

// If the form was not submitted through POST, redirect or handle accordingly
header("Location: /"); // Redirect to the home page, adjust the path as needed
exit;

?>
