<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "chatbot";
$conn = mysqli_connect($servername, $username, $password);

// Initialize the connection using object-oriented style
$conn = mysqli_init(); // Initializes a new mysqli object

// Set SSL (if needed, for remote connections like Azure)
//mysqli_ssl_set($conn, NULL, NULL, "DigiCertGlobalRootCA.crt.pem", NULL, NULL);

// Attempt to connect using real_connect
if (!mysqli_real_connect($conn, $servername, $username, $password, $database)) {
    die("Connection failed: " . mysqli_connect_error());
}

//echo "Connected successfully";

// Assuming you have received the user's question and stored it in $userQuestion
$userQuestion = mysqli_real_escape_string($conn, $_POST['text']);  // Make sure to sanitize user input

// Use the user's question in the SQL query
$query = "SELECT answer FROM chatbot_questionaries WHERE LOWER(questions) = LOWER('$userQuestion')";
$run_query = mysqli_query($conn, $query);

// Check if the query was successful
if ($run_query) {
    // Check if there are rows returned
    if (mysqli_num_rows($run_query) > 0) {
        $fetch_data = mysqli_fetch_assoc($run_query);
        $reply = $fetch_data['answer'];
        echo $reply;
    } else {
        echo "Sorry, can't be able to understand you!";
    }
} else {
    echo "Query failed: " . mysqli_error($conn);
}

// Close the connection
mysqli_close($conn);

?>
