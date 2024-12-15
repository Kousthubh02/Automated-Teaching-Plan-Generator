<?php
// Include your PDO database connection
require '../database/db_connection.php'; // Assuming db_connection.php has the correct connection setup

// Validation function
function validateForm($start_date, $end_date) {
    // Check if any required fields are empty
    if (empty($start_date) || empty($end_date)) {
        return "Start Date and End Date are required.";
    }

    // Validate start_date and end_date format (YYYY-MM-DD)
    $start_date_obj = DateTime::createFromFormat('Y-m-d', $start_date);
    $end_date_obj = DateTime::createFromFormat('Y-m-d', $end_date);

    if (!$start_date_obj || !$end_date_obj) {
        return "Invalid date format. Please use YYYY-MM-DD.";
    }

    // Check if end date is later than start date
    if ($start_date_obj > $end_date_obj) {
        return "End Date should be later than Start Date.";
    }

    return null;  // No error
}

// Fetching the form data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Fetch subject and days directly from the form
    $subject = isset($_POST['subject']) ? $_POST['subject'] : ''; // Subject input
    $days = isset($_POST['days']) ? $_POST['days'] : ''; // Days input (comma-separated)

    // Validate subject and days
    if (empty($subject) || empty($days)) {
        echo "<p class='error-message'>Subject and Days are required.</p>";
        exit();
    }

    // Fetch start_date, end_date, and exclude_date from the teaching_dates table
    try {
        $query = "SELECT start_date, end_date, exclude_dates FROM teaching_dates LIMIT 1"; // Fetch a single row, adjust as needed
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if any rows are returned
        if ($row) {
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $exclude_dates_str = $row['exclude_dates']; // Store fetched exclude dates as a string
        } else {
            $error_message = "No start and end dates found in the teaching_dates table.";
            echo "<p class='error-message'>$error_message</p>";
            exit();
        }
    } catch (PDOException $e) {
        $error_message = "Error fetching dates from teaching_dates table: " . $e->getMessage();
        echo "<p class='error-message'>$error_message</p>";
        exit();
    }

    // Validate form fields (start_date, end_date)
    $error_message = validateForm($start_date, $end_date);
    if ($error_message) {
        echo "<p class='error-message'>$error_message</p>";
        exit();
    }

    // Process exclude dates into an array and convert to Y-m-d format
    $exclude_dates = json_decode($exclude_dates_str, true); // Exclude dates in json format from DB (e.g. ["01-11-2024", "15-11-2024"])
    $formatted_exclude_dates = [];
    foreach ($exclude_dates as $date) {
        $date_obj = DateTime::createFromFormat('d-m-Y', $date); // Parse the date from DD-MM-YYYY
        if ($date_obj) {
            $formatted_exclude_dates[] = $date_obj->format('Y-m-d'); // Convert to YYYY-MM-DD
        }
    }

    // Calculate all dates between start_date and end_date
    function getAllDates($start_date, $end_date) {
        // Convert start and end dates to DateTime objects
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $all_dates = [];

        // Loop through each day between start and end date
        while ($start <= $end) {
            $date_str = $start->format('Y-m-d');
            $all_dates[] = $date_str;
            $start->modify('+1 day');
        }

        return $all_dates;
    }

    // Get all dates between start_date and end_date
    $all_dates = getAllDates($start_date, $end_date);

    // Split days into an array
    $days_array = explode(',', $days); // Assuming days are comma-separated (e.g., 'Monday,Tuesday,Wednesday')

    // Insert the dates into the teaching_plan table
    try {
        $stmt_insert = $pdo->prepare("INSERT INTO teaching_plan (subject, teaching_date, content) VALUES (:subject, :date, :content)");

        foreach ($all_dates as $date) {
            // Get the full weekday name (e.g., 'Monday', 'Tuesday', 'Saturday', 'Sunday')
            $current_day = (new DateTime($date))->format('l');  // Get the full weekday name (e.g., 'Monday')

            // Exclude weekends (Saturday and Sunday)
            if ($current_day == 'Saturday' || $current_day == 'Sunday') {
                continue;  // Skip weekends
            }

            // If the current date matches the day of the week in the form input, insert it
            if (in_array($current_day, $days_array)) {
                // Check if the date is in exclude_dates
                $content = in_array($date, $formatted_exclude_dates) ? "Non Teaching Day" : ""; // Add content for exclude dates

                // Bind the parameters and insert the data for Non Teaching Days
                $stmt_insert->bindParam(':subject', $subject, PDO::PARAM_STR);  // Insert subject from the form
                $stmt_insert->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt_insert->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt_insert->execute();
            }
        }

        echo "<p class='success-message'>Teaching Plan has been successfully inserted into the database.</p>";
        echo "<a href='teacher.php' class='btn-link'>Go back to form page</a><br>";
        echo "<a href='../teachingPlan/teachingPlan.php' class='btn-link'>View teaching plan</a>";
        exit();
    } catch (PDOException $e) {
        $error_message = "Error inserting Teaching Plan: " . $e->getMessage();
        echo "<p class='error-message'>$error_message</p>";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Plan</title>
    <style>
        .error-message, .success-message { color: red; font-size: 18px; text-align: center; margin-top: 20px; }
        .success-message { color: green; }
    </style>
</head>
<body>
    <h2>Create Teaching Plan</h2>
    <form method="POST" action="">
        <label for="subject">Subject</label>
        <input id="subject" name="subject" type="text" required>

        <label for="days">Days (comma separated, e.g. Monday,Tuesday)</label>
        <input id="days" name="days" type="text" required>

        <button type="submit">Submit</button>
    </form>
</body>
</html>
