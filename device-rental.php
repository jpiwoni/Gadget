<?php
$servername = "localhost";
$username = "root";
$password = "root"; 
$dbname = "DeviceManagement";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$deviceName = $_POST['deviceName'];
$personName = $_POST['personName'];
$beginDate = $_POST['beginDate'];
$endDate = $_POST['endDate'];
$notes = $_POST['notes'];

$deviceQuery = "SELECT ID FROM Device WHERE Name = ?";
$deviceStmt = $conn->prepare($deviceQuery);
$deviceStmt->bind_param("s", $deviceName);
$deviceStmt->execute();
$deviceResult = $deviceStmt->get_result();

if ($deviceResult->num_rows == 0) {
    echo "Error: Device not found.";
    exit;
}
$deviceRow = $deviceResult->fetch_assoc();
$deviceID = $deviceRow['ID'];

$personQuery = "SELECT ID FROM Person WHERE CONCAT(FirstName, ' ', LastName) = ?";
$personStmt = $conn->prepare($personQuery);
$personStmt->bind_param("s", $personName);
$personStmt->execute();
$personResult = $personStmt->get_result();

if ($personResult->num_rows == 0) {
    echo "Error: Person not found.";
    exit;
}
$personRow = $personResult->fetch_assoc();
$personID = $personRow['ID'];

$stmt = $conn->prepare("INSERT INTO Reservation (DeviceID, PersonID, BeginDate, EndDate, Notes) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("iisss", $deviceID, $personID, $beginDate, $endDate, $notes);

if ($stmt->execute()) {
    echo "<h2>Reservation submitted successfully!</h2>";
} else {
    echo "<p>Error: " . $stmt->error . "</p>";
}

$stmt->close();
$conn->close();
?>
