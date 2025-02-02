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

    // Fetch start_date, end_date, and exclude_dates from the teaching_dates table
    try {
        $query = "SELECT start_date, end_date, exclude_dates FROM teaching_dates LIMIT 1"; // Fetch a single row, adjust as needed
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if any rows are returned
        if ($row) {
            $start_date = $row['start_date'];
            $end_date = $row['end_date'];
            $exclude_dates_str = $row['exclude_dates']; // Exclude dates stored as JSON key–value pairs (e.g. {"24-04-2025": "Holiday", "01-05-2025": "Festival"})
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

    // Process exclude dates into an associative array and convert keys to YYYY-MM-DD format
    $exclude_dates = json_decode($exclude_dates_str, true); // Expects a JSON object like: {"24-04-2025": "Holiday", "01-05-2025": "Festival"}
    $formatted_exclude_dates = [];
    if (is_array($exclude_dates)) {
        foreach ($exclude_dates as $date => $reason) {
            // Parse the date from dd-mm-yyyy format
            $date_obj = DateTime::createFromFormat('d-m-Y', $date);
            if ($date_obj) {
                // Convert the date key to YYYY-MM-DD format and store the corresponding reason
                $formatted_exclude_dates[$date_obj->format('Y-m-d')] = $reason;
            }
        }
    }

    // Function to calculate all dates between start_date and end_date (inclusive)
    function getAllDates($start_date, $end_date) {
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);
        $all_dates = [];

        while ($start <= $end) {
            $all_dates[] = $start->format('Y-m-d');
            $start->modify('+1 day');
        }

        return $all_dates;
    }

    // Get all dates between start_date and end_date
    $all_dates = getAllDates($start_date, $end_date);

    // Split days into an array and sanitize (e.g., 'monday' becomes 'Monday')
    $days_array = array_map('ucfirst', array_map('trim', explode(',', $days)));

    // Insert the dates into the teaching_plan table
    try {
        $stmt_insert = $pdo->prepare("INSERT INTO teaching_plan (subject, proposed_date, content) VALUES (:subject, :date, :content)");

        foreach ($all_dates as $date) {
            // Get the full weekday name (e.g., 'Monday', 'Tuesday', etc.)
            $current_day = (new DateTime($date))->format('l');

            // Exclude weekends (Saturday and Sunday)
            if ($current_day == 'Saturday' || $current_day == 'Sunday') {
                continue;
            }

            // Only insert if the current weekday is one of the selected days from the form
            if (in_array($current_day, $days_array)) {
                // Check if the current date exists in the formatted_exclude_dates array
                // If so, fill the content with the reason (or "Non Teaching Day" if desired)
                $content = isset($formatted_exclude_dates[$date]) ? $formatted_exclude_dates[$date] : "";
                
                // Bind parameters and execute the insertion
                $stmt_insert->bindParam(':subject', $subject, PDO::PARAM_STR);
                $stmt_insert->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt_insert->bindParam(':content', $content, PDO::PARAM_STR);
                $stmt_insert->execute();
            }
        }

        // Success message HTML
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
                    font-family: 'Arial', sans-serif;
                    background-color: #f4f7f6;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .container {
                    background-color: white;
                    border-radius: 8px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    padding: 30px;
                    width: 80%;
                    max-width: 600px;
                    text-align: center;
                }
                .success-message {
                    background-color: #d4edda;
                    color: #155724;
                    border: 1px solid #c3e6cb;
                    padding: 15px;
                    border-radius: 8px;
                    font-size: 18px;
                    margin-bottom: 20px;
                    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                }
                .btn-link {
                    display: inline-block;
                    background-color: #007bff;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    text-decoration: none;
                    margin: 10px 0;
                    font-size: 16px;
                    transition: background-color 0.3s ease;
                }
                .btn-link:hover {
                    background-color: #0056b3;
                }
                .icon {
                    margin-right: 8px;
                }
                .cta {
                    margin-top: 30px;
                }
                .cta a {
                    margin-right: 15px;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='success-message'>
                    <i class='fas fa-check-circle icon'></i>
                    Teaching Plan has been successfully inserted into the database.
                </div>
                <div class='cta'>
                    <a href='teacher.php' class='btn-link'>
                        <i class='fas fa-arrow-left icon'></i> Go back to form page
                    </a>
                    <a href='../teachingPlan/teachingPlan.php' class='btn-link'>
                        <i class='fas fa-eye icon'></i> View teaching plan
                    </a>
                </div>
            </div>
        </body>
        </html>";
        exit();
    } catch (PDOException $e) {
        $error_message = "Error inserting Teaching Plan: " . $e->getMessage();
        echo "<p class='error-message'>$error_message</p>";
        exit();
    }
}
?>
