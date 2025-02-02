<?php
// Enable error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your PDO database connection
require '../database/db_connection.php'; // Adjust the path as needed

// Function to generate all dates excluding weekends (Saturday and Sunday)
function getAllDates($start_date, $end_date) {
    $dates = [];
    
    // Convert the start_date and end_date to DateTime objects
    $start = new DateTime($start_date);
    $end = new DateTime($end_date);

    // Loop through each day between start and end dates
    $current = $start;
    while ($current <= $end) {
        // If the current day is not Saturday or Sunday, add it to the dates array
        if ($current->format('N') < 6) {
            $dates[] = $current->format('Y-m-d'); // Format: yyyy-mm-dd
        }
        // Move to the next day
        $current->modify('+1 day');
    }

    return $dates;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subject_name = isset($_POST['subject']) ? trim($_POST['subject']) : ''; // Get the subject name
    $first_week_details = isset($_POST['first_week_details']) ? $_POST['first_week_details'] : [];
    $regular_week_details = isset($_POST['regular_week_details']) ? $_POST['regular_week_details'] : [];

    if (empty($subject_name)) {
        echo "<p class='error-message'>Subject is required.</p>";
        exit();
    }

    // Get start_date, end_date, and exclude_dates from teaching_dates table
    try {
        $query = "SELECT start_date, end_date, exclude_dates FROM teaching_dates LIMIT 1";
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $start_date = $row['start_date'];  // expected format: yyyy-mm-dd
            $end_date   = $row['end_date'];    // expected format: yyyy-mm-dd
            $exclude_dates_str = $row['exclude_dates']; // JSON string, e.g.: {"13-02-2025": "diwali", ...}
        } else {
            echo "<p class='error-message'>No start and end dates found.</p>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<p class='error-message'>Error fetching dates: " . $e->getMessage() . "</p>";
        exit();
    }

    // Process exclude dates (convert from dd-mm-yyyy to yyyy-mm-dd)
    $exclude_dates = json_decode($exclude_dates_str, true);
    $formatted_exclude_dates = [];
    if (is_array($exclude_dates)) {
        foreach ($exclude_dates as $date => $reason) {
            // Convert date format from dd-mm-yyyy to yyyy-mm-dd
            $date_obj = DateTime::createFromFormat('d-m-Y', $date);
            if ($date_obj) {
                $formatted_exclude_dates[$date_obj->format('Y-m-d')] = $reason;
            }
        }
    }

    // Get all dates between start_date and end_date (excluding weekends)
    $all_dates = getAllDates($start_date, $end_date);

    // Prepare the insert statement
    $stmt_insert = $pdo->prepare("INSERT INTO teaching_plan (subject, proposed_date, content, isNTD) VALUES (:subject, :date, :content, :isNTD)");

    // Loop through each date and insert records based on matching lecture details
    foreach ($all_dates as $date) {
        $currentDateObj = DateTime::createFromFormat('Y-m-d', $date);
        $current_day = $currentDateObj->format('l'); // Get the day of the week

        // Check if the date is in the exclude_dates
        $content = isset($formatted_exclude_dates[$date]) ? $formatted_exclude_dates[$date] : "";
        $isNTD = isset($formatted_exclude_dates[$date]) ? 1 : 0; // Set isNTD to 1 if the date is excluded

        // Determine if the current date belongs to first week or regular week
        $details = ($currentDateObj <= DateTime::createFromFormat('Y-m-d', $start_date)->modify('+6 days')) ? $first_week_details : $regular_week_details;

        // For each lecture detail, check if the day matches and insert the number of lectures
        foreach ($details as $detail) {
            if (isset($detail['day']) && isset($detail['lectures']) && $detail['day'] == $current_day) {
                $num_lectures = (int)$detail['lectures'];
                for ($i = 0; $i < $num_lectures; $i++) {
                    $stmt_insert->execute([
                        ':subject' => $subject_name, // Insert the subject name
                        ':date' => $date, // yyyy-mm-dd format
                        ':content' => $content,
                        ':isNTD' => $isNTD
                    ]);
                }
            }
        }
    }

    // Display success page after insertion
    echo "
    <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Teaching Plan Submitted</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css'>
    <style>
        body { 
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; 
            background-color: #f4f7f6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            height: 100vh; 
            margin: 0; 
        }
        .container { 
            background-color: white; 
            border-radius: 12px; 
            padding: 40px; 
            text-align: center; 
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15); 
            animation: fadeIn 0.6s ease-in-out; 
        }
        .success-message { 
            color: #28a745; 
            font-size: 24px; 
            margin-bottom: 25px; 
        }
        .success-message i { 
            font-size: 50px; 
            margin-bottom: 15px; 
        }
        .btn-link { 
            display: inline-block; 
            background-color: #007bff; 
            color: white; 
            padding: 12px 25px; 
            border-radius: 8px; 
            text-decoration: none; 
            font-size: 18px; 
            margin: 10px; 
            transition: background-color 0.3s ease, transform 0.2s ease; 
        }
        .btn-link:hover { 
            background-color: #0056b3; 
            transform: scale(1.05); 
        }
        @keyframes fadeIn {
            0% { opacity: 0; }
            100% { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class='container'>
        <div class='success-message'>
            <i class='fas fa-check-circle'></i>
            <p>Your teaching plan has been successfully submitted for <strong>$subject_name</strong>.</p>
        </div>
        <a href='teacher.php' class='btn-link'>Go Back</a>
        <!-- New button to view teaching plan -->
        <a href='view_teaching_plan.php' class='btn-link'>View Teaching Plan</a>
    </div>
</body>
</html>";
}
?>
