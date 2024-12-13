<?php
$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "DeviceManagement";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect form data
$deviceName = $_POST['deviceName'];
$personName = $_POST['personName'];
$beginDate = $_POST['beginDate'];
$endDate = $_POST['endDate'];
$notes = $_POST['notes'];

// Search for the device by name
$deviceQuery = "SELECT ID FROM Device WHERE Name = ?";
$deviceStmt = $conn->prepare($deviceQuery);
$deviceStmt->bind_param("s", $deviceName);
$deviceStmt->execute();
$deviceResult = $deviceStmt->get_result();

// Check if device was found
if ($deviceResult->num_rows == 0) {
    echo "Error: Device not found.";
    exit;
}
$deviceRow = $deviceResult->fetch_assoc();
$deviceID = $deviceRow['ID'];

// Search for the person by name
$personQuery = "SELECT ID FROM Person WHERE CONCAT(FirstName, ' ', LastName) = ?";
$personStmt = $conn->prepare($personQuery);
$personStmt->bind_param("s", $personName);
$personStmt->execute();
$personResult = $personStmt->get_result();

// Check if person was found
if ($personResult->num_rows == 0) {
    echo "Error: Person not found.";
    exit;
}
$personRow = $personResult->fetch_assoc();
$personID = $personRow['ID'];

// Prepare the SQL statement to insert into the Reservation table
$stmt = $conn->prepare("INSERT INTO Reservation (DeviceID, PersonID, BeginDate, EndDate, Notes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $deviceID, $personID, $beginDate, $endDate, $notes);

// Execute the query and check if it's successful
if ($stmt->execute()) {
    echo "<h2>Reservation submitted successfully!</h2>";
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

// Close the connection
$stmt->close();
$conn->close();
?>
