<?php
// Include the database connection file
require_once '../database/db_connection.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Fetch the current editable value
        $sql = "SELECT editable FROM settings WHERE id = 1";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            $currentValue = $row['editable'];

            // Toggle the value
            $newValue = $currentValue == 1 ? 0 : 1;

            // Update the editable value in the database
            $updateSql = "UPDATE settings SET editable = :newValue WHERE id = 1";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute(['newValue' => $newValue]);

            // Redirect back to the admin page without displaying a message
            header("Location: ../admin/admin_2.php");
            exit();
        } else {
            die("No record found with id = 1");
        }
    } catch (PDOException $e) {
        die("Error updating record: " . $e->getMessage());
    }
}

// Fetch the current editable value to display
try {
    $sql = "SELECT editable FROM settings WHERE id = 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentValue = $row ? $row['editable'] : 0; // Default value if no row is found
} catch (PDOException $e) {
    die("Error fetching editable status: " . $e->getMessage());
}
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
        <a href="../admin/admin_2.php" class="btn-link">Go Back to Admin Page</a>
    </div>
</body>
</html>