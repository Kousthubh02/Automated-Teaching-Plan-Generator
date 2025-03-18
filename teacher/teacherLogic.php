<?php
// Enable error reporting (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include your PDO database connection
require '../database/db_connection.php';

// Function to generate all dates between start and end dates (excluding weekends)
function getAllDates($start_date, $end_date) {
    $dates = [];
    $start = new DateTime($start_date);
    $end   = new DateTime($end_date);

    $current = clone $start;
    while ($current <= $end) {
        if ($current->format('N') < 6) {
            $dates[] = $current->format('Y-m-d');
        }
        $current->modify('+1 day');
    }
    return $dates;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $subject_name = isset($_POST['subject']) ? (is_array($_POST['subject']) ? trim(end($_POST['subject'])) : trim($_POST['subject'])) : '';
    $division = isset($_POST['division']) ? trim($_POST['division']) : '';
    $sem_id = isset($_POST['sem_id']) ? trim($_POST['sem_id']) : '';

    // Validate inputs
    if (empty($subject_name)) {
        echo "<p class='error-message'>Subject is required.</p>";
        exit();
    }
    if (empty($division)) {
        echo "<p class='error-message'>Division is required.</p>";
        exit();
    }
    if (empty($sem_id)) {
        echo "<p class='error-message'>Semester is required.</p>";
        exit();
    }

    // Retrieve dynamic week details
    $first_week_details = isset($_POST['first_week_details']) ? array_values($_POST['first_week_details']) : [];
    $regular_week_details = isset($_POST['regular_week_details']) ? array_values($_POST['regular_week_details']) : [];

    // Get teaching dates from database
    try {
        $stmt = $pdo->prepare("SELECT start_date, end_date, exclude_dates FROM teaching_dates ORDER BY created_at DESC LIMIT 1");
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$row) {
            echo "<p class='error-message'>No teaching dates found.</p>";
            exit();
        }
        
        $start_date = $row['start_date'];
        $end_date = $row['end_date'];
        $exclude_dates = json_decode($row['exclude_dates'], true);
    } catch (PDOException $e) {
        echo "<p class='error-message'>Database error: " . $e->getMessage() . "</p>";
        exit();
    }

    // Process excluded dates
    $formatted_exclude_dates = [];
    foreach ($exclude_dates as $date_str => $data) {
        $date_obj = DateTime::createFromFormat('d-m-Y', $date_str);
        if ($date_obj) {
            $formatted_date = $date_obj->format('Y-m-d');
            $formatted_exclude_dates[$formatted_date] = [
                'reason' => $data['reason'],
                'semester' => $data['semester']
            ];
        }
    }

    // Generate teaching dates
    $all_dates = getAllDates($start_date, $end_date);
    $firstWeekEnd = DateTime::createFromFormat('Y-m-d', $start_date)->modify('+6 days');

    // Prepare insert statement
    try {
        $pdo->beginTransaction();
        $stmt_insert = $pdo->prepare("
            INSERT INTO teaching_plan 
            (subject, division, sem_id, proposed_date, content, isNTD) 
            VALUES (:subject, :division, :sem_id, :date, :content, :isNTD)
        ");


    // Insert teaching plan data
    foreach ($all_dates as $date) {
        $currentDateObj = DateTime::createFromFormat('Y-m-d', $date);
        $current_day = $currentDateObj->format('l');
        
        // Initialize flags
        $isNTD = 0;
        $content = '';
        $hasLecture = false; // Flag to check if there is at least one lecture on this date

        // Check if date is excluded for this semester
        if (isset($formatted_exclude_dates[$date])) {
            $excl_data = $formatted_exclude_dates[$date];
            $excl_sem = $excl_data['semester'];
            
            // Check semester match
            if ($excl_sem === 'ALL' || in_array($sem_id, explode(',', $excl_sem))) {
                $isNTD = 1;
                $content = $excl_data['reason'];
            }
        }

        // Determine which week details to use
        $details = ($currentDateObj <= $firstWeekEnd) ? $first_week_details : $regular_week_details;

        // Check if there is at least one lecture on this date
        foreach ($details as $detail) {
            if (isset($detail['day'], $detail['lectures']) && $detail['day'] === $current_day) {
                $hasLecture = true; // At least one lecture exists for this date
                break; // No need to check further
            }
        }

        // If it's a non-teaching day and has at least one lecture, insert NTD entry
        if ($isNTD === 1 && $hasLecture) {
            $stmt_insert->execute([
                ':subject' => $subject_name,
                ':division' => $division,
                ':sem_id' => $sem_id,
                ':date' => $date,
                ':content' => $content,
                ':isNTD' => $isNTD
            ]);
        }

        // If it's a teaching day and has lectures, insert lecture entries
        if ($isNTD === 0 && $hasLecture) {
            foreach ($details as $detail) {
                if (isset($detail['day'], $detail['lectures']) && $detail['day'] === $current_day) {
                    for ($i = 0; $i < (int)$detail['lectures']; $i++) {
                        $stmt_insert->execute([
                            ':subject' => $subject_name,
                            ':division' => $division,
                            ':sem_id' => $sem_id,
                            ':date' => $date,
                            ':content' => $content,
                            ':isNTD' => 0 // Lectures are always teaching days
                        ]);
                    }
                }
            }
        }
    }

    $pdo->commit();
    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<p class='error-message'>Insert error: " . $e->getMessage() . "</p>";
        exit();
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
            <p>Your teaching plan has been successfully submitted for <strong>{$subject_name}</strong>.</p>
        </div>
        <a href='teacher.php' class='btn-link'>Go Back</a>
        <a href='../teachingPlan/teachingPlan.php' class='btn-link'>View Teaching Plan</a>
    </div>
</body>
</html>";
}
?>
