<?php
// Start the session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Assuming you have already established a database connection in $con
$user_id = $_SESSION['user_id'];

// Use a prepared statement to safely query the database
if ($stmt = $con->prepare("SELECT id FROM wallet WHERE customer_id = ?")) {
    // Bind the user ID to the statement
    $stmt->bind_param("i", $user_id);
    // Execute the statement
    $stmt->execute();
    // Bind the result to a variable
    $stmt->bind_result($wallet_id);
    // Fetch the result
    $stmt->fetch();
    // Close the statement
    $stmt->close();
}

// Check if $wallet_id is set before proceeding
if (isset($wallet_id)) {
    // Use a prepared statement to safely query the wallet_details table
    if ($stmt = $con->prepare("SELECT balance FROM wallet_details WHERE wallet_id = ?")) {
        // Bind the wallet ID to the statement
        $stmt->bind_param("i", $wallet_id);
        // Execute the statement
        $stmt->execute();
        // Bind the result to a variable
        $stmt->bind_result($balance);
        // Fetch the result
        $stmt->fetch();
        // Close the statement
        $stmt->close();
    }
} else {
    echo "No wallet found for the given user.";
}
?>
