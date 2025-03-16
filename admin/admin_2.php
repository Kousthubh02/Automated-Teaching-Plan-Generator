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
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .header {
            width: 100%;
            background-color: white;
            padding: 20px;
            border-bottom: 1px solid #000;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative; /* For positioning the logout button */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header h1, .header h2, .header h3 {
            margin: 5px 0; /* Reduce margin for better spacing */
        }

        .main-wrapper {
            display: flex;
            gap: 20px; /* Space between the two containers */
            width: 90%;
            max-width: 1200px; /* Adjust based on your layout */
            margin-top: 20px;
        }

        .container {
            width: 100%;
            background-color: white;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
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
            position: absolute; /* Position the logout button */
            top: 10px; /* Distance from the top */
            right: 10px; /* Distance from the right */
            width: auto;
            background-color: red;
            padding: 8px 12px; /* Smaller padding for smaller screens */
            font-size: 0.9em; /* Smaller font size for smaller screens */
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
            .main-wrapper {
                flex-direction: column; /* Stack containers vertically on smaller screens */
            }

            .container {
                width: 95%; /* Adjust width for smaller screens */
            }

            button {
                padding: 12px; /* Increase padding for better touch targets */
            }

            input[type="text"], input[type="date"], input[type="file"] {
                padding: 12px; /* Increase padding for better touch targets */
            }

            .header {
                padding: 15px; /* Reduce padding for smaller screens */
            }

            button.logout {
                top: 5px; /* Adjust position for smaller screens */
                right: 5px; /* Adjust position for smaller screens */
                padding: 6px 10px; /* Smaller padding for smaller screens */
                font-size: 0.8em; /* Smaller font size for smaller screens */
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.2em; /* Reduce font size for smaller screens */
            }

            button {
                padding: 12px; /* Ensure buttons are easy to tap */
            }

            input[type="text"], input[type="date"], input[type="file"] {
                padding: 10px; /* Adjust input padding for smaller screens */
            }

            .header h1, .header h2, .header h3 {
                font-size: 1em; /* Reduce font size for smaller screens */
            }

            button.logout {
                top: 5px; /* Adjust position for smaller screens */
                right: 5px; /* Adjust position for smaller screens */
                padding: 5px 8px; /* Smaller padding for smaller screens */
                font-size: 0.7em; /* Smaller font size for smaller screens */
            }
        }
    </style>
</head>
<body>

<!-- Header Container -->
<div class="header">
    <h1><img src="./college.jpeg" alt="Institute Logo"></h1>
    <h2>Teaching Plan Generator</h2>
    <h3>Admin Portal</h3>
    <!-- Logout Button -->
    <button class="logout">Log Out</button>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Main Container -->
    <div class="container">
        <h3 style="text-align:center;">Dates Section</h3>
        <div class="separator"></div>

        <form id="adminForm" action="adminLogic.php" method="POST" enctype="multipart/form-data">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="exclude_dates">Exclude Dates (.csv):</label>
            <input type="file" id="exclude_dates" name="exclude_dates" accept=".csv" required>

            <br><br>

            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Control Section -->
    <div class="container">
        <h3 style="text-align:center;">Control Section</h3>
        <div class="separator"></div>

        <!-- Editable Status -->
        <?php
        // Dynamic class for message
        $statusClass = $editableStatus === "Editable" ? "editable" : "not-editable";
        ?>
        <div class="message <?php echo $statusClass; ?>">
            Current Editable Status: <?php echo $editableStatus; ?>
        </div>

        <!-- Toggle Editable Button -->
        <button type="button" onclick="submitFormToToggle()">Toggle Editable</button>

    </div>
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