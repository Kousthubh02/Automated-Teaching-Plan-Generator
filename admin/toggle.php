<?php
// Must exist as a separate file or script as there are two buttons
// Convert to message box to show editable value without shifting pages, and show on admin page also
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "major_testing";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Fetch current editable value
    $sql = "SELECT editable FROM settings WHERE id = 1";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentValue = $row['editable'];

        // Toggle the value
        $newValue = $currentValue == 1 ? 0 : 1;
        $updateSql = "UPDATE settings SET editable = $newValue WHERE id = 1";

        if ($conn->query($updateSql) === TRUE) {
            echo "Editable value updated successfully to: " . ($newValue == 1 ? "Editable" : "Not Editable");
        } else {
            echo "Error updating record: " . $conn->error;
        }
    } else {
        echo "No record found with id = 1";
    }
}

// Fetch the current value to display
$sql = "SELECT editable FROM settings WHERE id = 1";
$result = $conn->query($sql);
$currentValue = 0;
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $currentValue = $row['editable'];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Editable</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            text-align: center;
        }
        h1 {
            font-size: 1.8em;
            margin-bottom: 20px;
        }
        .btn-link {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 1em;
            text-decoration: none;
            color: white;
            background-color: #007BFF;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        .btn-link:hover {
            background-color: #0056b3;
        }
        .status-editable {
            color: #4CAF50; /* Green */
        }
        .status-not-editable {
            color: #F44336; /* Red */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>
            Current Editable Value: 
            <span class="<?php echo $currentValue == 1 ? 'status-editable' : 'status-not-editable'; ?>">
                <?php echo $currentValue == 1 ? "Editable" : "Not Editable"; ?>
            </span>
        </h1>
        <a href="../admin/hello_admin.php" class="btn-link">Go Back to Admin Page</a>
    </div>
</body>
</html>


