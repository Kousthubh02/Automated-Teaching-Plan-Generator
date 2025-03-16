<?php
// Include the database connection file
require_once '../database/db_connection.php';

// Fetch the current editable value
try {
    $sql = "SELECT editable FROM settings WHERE id = 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentValue = $row ? $row['editable'] : 0;  // Default value if no row is found
} catch (PDOException $e) {
    die("Error fetching editable status: " . $e->getMessage());
}

// Convert the editable value to a string message
$editableStatus = $currentValue == 1 ? "Editable" : "Not Editable";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1, h2, h3 {
            text-align: center;
            margin: 10px 0;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1em;
        }

        button.logout {
            float: right;
            width: auto;
            background-color: red;
            padding: 10px 15px;
        }

        button:hover {
            opacity: 0.9;
        }

        .separator {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .message {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .editable {
            color: #4CAF50; /* Green */
            background-color: #e8f5e9;
            border: 1px solid #c3e6cb;
        }

        .not-editable {
            color: #F44336; /* Red */
            background-color: #fbe9e7;
            border: 1px solid #f5c6cb;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            button {
                padding: 12px;
            }

            input[type="text"], input[type="date"], input[type="file"] {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.2em;
            }

            button {
                padding: 12px;
            }

            input[type="text"], input[type="date"], input[type="file"] {
                padding: 10px;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h1><img src="./college.jpeg" alt="Institute Logo"></h1>

    <h2>Teaching Plan Generator</h2>
    <h3>Admin Portal</h3>

    <div>
        <button class="logout">Log Out</button>
    </div>

    <div class="separator"></div>

    <!-- Display Editable Status -->
    <?php
    // Dynamic class for message
    $statusClass = $editableStatus === "Editable" ? "editable" : "not-editable";
    ?>
    <div class="message <?php echo $statusClass; ?>">
        Current Editable Status: <?php echo $editableStatus; ?>
    </div>

    <form id="adminForm" action="adminLogic.php" method="POST" enctype="multipart/form-data">
        <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <label for="exclude_dates">Exclude Dates (.csv):</label>
        <input type="file" id="exclude_dates" name="exclude_dates" accept=".csv" required>

        <br><br>

        <button type="submit">Submit</button>
        <button type="button" onclick="submitFormToToggle()">Toggle Editable</button>
    </form>
</div>

<script>
    // Function to submit the form to toggle.php
    function submitFormToToggle() {
        var form = document.getElementById('adminForm');
        form.action = 'toggle.php'; // Set the action to toggle.php
        form.submit(); // Submit the form
    }

    // Reset form action when Submit button is clicked
    document.querySelector('button[type="submit"]').addEventListener('click', function () {
        var form = document.getElementById('adminForm');
        form.action = 'adminLogic.php'; // Reset the action to adminLogic.php
    });
</script>

</body>
</html>
