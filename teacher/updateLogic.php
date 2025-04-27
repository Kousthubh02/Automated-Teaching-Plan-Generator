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

    // Check if data exists for this combination before allowing update
    try {
        $checkStmt = $pdo->prepare("
            SELECT COUNT(*) as count 
            FROM teaching_plan 
            WHERE subject = :subject 
            AND division = :division 
            AND sem_id = :sem_id
        ");
        $checkStmt->execute([
            ':subject' => $subject_name,
            ':division' => $division,
            ':sem_id' => $sem_id
        ]);
        $result = $checkStmt->fetch(PDO::FETCH_ASSOC);
        
        if ($result['count'] == 0) {
            // Data doesn't exist for this combination
            echo "
            <!DOCTYPE html>
            <html lang='en'>
            <head>
                <meta charset='UTF-8'>
                <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                <title>Error - No Data Found</title>
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
                    .error-message { 
                        color: #dc3545; 
                        font-size: 24px; 
                        margin-bottom: 25px; 
                    }
                    .error-message i { 
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
                    <div class='error-message'>
                        <span style='font-size: 50px;'>❌</span>
                        <p>No existing data found for <strong>{$subject_name}</strong> in semester <strong>{$sem_id}</strong>, division <strong>{$division}</strong>.</p>
                        <p>Please use the <strong>Generate Dates</strong> button first.</p>
                    </div>
                    <a href='teacher.php' class='btn-link'>Go Back</a>
                </div>
            </body>
            </html>";
            exit();
        }
    } catch (PDOException $e) {
        echo "<p class='error-message'>Database error while checking existing data: " . $e->getMessage() . "</p>";
        exit();
    }

    // [Rest of your existing updateLogic.php code remains the same...]
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

    // [Continue with the rest of your existing update logic...]
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

    // [Rest of your existing update logic...]
    // Initialize dictionary to store data
    $teaching_plan_data = [];
    $pk = 1; // Primary key counter

    // Loop through all dates and prepare data
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

        // If it's a non-teaching day and has at least one lecture, add NTD entry
        if ($isNTD === 1 && $hasLecture) {
            $teaching_plan_data[$pk] = [
                'sem_id' => $sem_id,
                'division' => $division,
                'subject' => $subject_name,
                'proposed_date' => $date,
                'isNTD' => $isNTD,
                'content' => $content,
                'dept_id' => null, // Will be populated from existing data
                'reference' => '', // Will be populated from existing data
                'methodology' => '', // Will be populated from existing data
                'co_mapping' => '' // Will be populated from existing data
            ];
            $pk++; // Increment primary key
        }

        // If it's a teaching day and has lectures, add lecture entries
        if ($isNTD === 0 && $hasLecture) {
            foreach ($details as $detail) {
                if (isset($detail['day'], $detail['lectures']) && $detail['day'] === $current_day) {
                    for ($i = 0; $i < (int)$detail['lectures']; $i++) {
                        $teaching_plan_data[$pk] = [
                            'sem_id' => $sem_id,
                            'division' => $division,
                            'subject' => $subject_name,
                            'proposed_date' => $date,
                            'isNTD' => 0, // Lectures are always teaching days
                            'content' => '',
                            'dept_id' => null, // Will be populated from existing data
                            'reference' => '', // Will be populated from existing data
                            'methodology' => '', // Will be populated from existing data
                            'co_mapping' => '' // Will be populated from existing data
                        ];
                        $pk++; // Increment primary key
                    }
                }
            }
        }
    }

    // [Continue with the rest of your existing update logic...]
    // 1. Count number of keys aka length of the dictionary, store it in a variable called max_lectures
    $max_lectures = count($teaching_plan_data);

    // 2. Create a counter variable lectures_added initialized to 0
    $lectures_added = 0;

    // 3. Create a blank string called missing_content
    $missing_content = "";

    // 4. Fetch existing records from database using semester, subject, and division parameters from form data where isNTD=0
    try {
        $stmt = $pdo->prepare("SELECT * FROM teaching_plan WHERE sem_id = :sem_id AND subject = :subject AND division = :division AND isNTD = 0");
        $stmt->execute([
            ':sem_id' => $sem_id,
            ':subject' => $subject_name,
            ':division' => $division
        ]);
        $existing_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "<p class='error-message'>Database error: " . $e->getMessage() . "</p>";
        exit();
    }

    // Algorithm implementation
    reset($teaching_plan_data);

    foreach ($existing_records as $old_row) {
        // Stop processing if we've reached the max_lectures limit
        if ($lectures_added >= $max_lectures) {
            break;
        }

        // Get current key and row
        $current_key = key($teaching_plan_data);
        $new_row = current($teaching_plan_data);

        // Skip non-teaching days (isNTD === 1)
        while ($new_row !== false && $new_row['isNTD'] === 1) {
            next($teaching_plan_data);
            $current_key = key($teaching_plan_data);
            $new_row = current($teaching_plan_data);
        }

        // If $new_row is false, we've reached the end of the array
        if ($new_row === false) {
            break; // Exit the loop early
        }

        // Copy content from old row to new row IN THE ORIGINAL ARRAY
        if ($current_key !== null) {
            $teaching_plan_data[$current_key]['content'] = $old_row['content'];
            $teaching_plan_data[$current_key]['dept_id'] = $old_row['dept_id'];
            $teaching_plan_data[$current_key]['reference'] = $old_row['reference'];
            $teaching_plan_data[$current_key]['methodology'] = $old_row['methodology'];
            $teaching_plan_data[$current_key]['co_mapping'] = $old_row['co_mapping'];
            $lectures_added++;
            next($teaching_plan_data);
        }
    }

    // After the loop, check if there are remaining $old_row entries in $existing_records
    if ($lectures_added < count($existing_records)) {
        // Get the remaining $old_row entries
        $remaining_records = array_slice($existing_records, $lectures_added);

        // Append their content to $missing_content
        foreach ($remaining_records as $old_row) {
            $missing_content .= $old_row['content'] . "\n\n";
        }
    }

    // Begin transaction for atomic operations
    try {
        $pdo->beginTransaction();

        // 1. Delete existing records (the ones we fetched earlier)
        if (!empty($existing_records)) {
            $delete_stmt = $pdo->prepare("DELETE FROM teaching_plan WHERE sem_id = :sem_id AND subject = :subject AND division = :division");
            $delete_stmt->execute([
                ':sem_id' => $sem_id,
                ':subject' => $subject_name,
                ':division' => $division
            ]);
        }

        // 2. Insert the new plan into the table (without using staff_id and current_year from old records)
        $insert_stmt = $pdo->prepare("
            INSERT INTO teaching_plan 
            (dept_id, sem_id, division, subject, proposed_date, isNTD, content, reference, methodology, co_mapping) 
            VALUES 
            (:dept_id, :sem_id, :division, :subject, :proposed_date, :isNTD, :content, :reference, :methodology, :co_mapping)
        ");

        $insert_count = 0;
        foreach ($teaching_plan_data as $row) {
            $insert_stmt->execute([
                ':dept_id' => $row['dept_id'] ?? null,
                ':sem_id' => $row['sem_id'],
                ':division' => $row['division'],
                ':subject' => $row['subject'],
                ':proposed_date' => $row['proposed_date'],
                ':isNTD' => $row['isNTD'],
                ':content' => $row['content'],
                ':reference' => $row['reference'],
                ':methodology' => $row['methodology'],
                ':co_mapping' => $row['co_mapping']
            ]);
            $insert_count++;
        }

        // 3. If missing content string is not empty, handle missing_content_table
        if (!empty(trim($missing_content))) {
            // First try to update any existing record
            $update_stmt = $pdo->prepare("
                UPDATE missing_content_table 
                SET missingcontent = :missingcontent
                WHERE sem_id = :sem_id 
                AND division = :division 
                AND subject = :subject
            ");
            
            $update_stmt->execute([
                ':missingcontent' => rtrim($missing_content, "; "),
                ':sem_id' => $sem_id,
                ':division' => $division,
                ':subject' => $subject_name
            ]);
            
            // If no rows were updated, insert a new record
            if ($update_stmt->rowCount() === 0) {
                $insert_stmt = $pdo->prepare("
                    INSERT INTO missing_content_table 
                    (dept_id, sem_id, division, subject, missingcontent) 
                    VALUES 
                    (:dept_id, :sem_id, :division, :subject, :missingcontent)
                ");
                
                $insert_stmt->execute([
                    ':dept_id' => !empty($existing_records) ? $existing_records[0]['dept_id'] : NULL,
                    ':sem_id' => $sem_id,
                    ':division' => $division,
                    ':subject' => $subject_name,
                    ':missingcontent' => rtrim($missing_content, "; ")
                ]);
            }
        }

        $pdo->commit();

        // Display success page after insertion
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Teaching Plan Updated</title>
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
                    <span style='font-size: 50px;'>✅</span>
                    <p>Updated teaching plan dates for <strong>{$subject_name}</strong>.</p>
                </div>
                <a href='teacher.php' class='btn-link'>Go Back</a>
                <a href='../teachingPlan/teachingPlan.php' class='btn-link'>View Teaching Plan</a>
            </div>
        </body>
        </html>";

    } catch (PDOException $e) {
        $pdo->rollBack();
        echo "<p class='error-message'>Database error: " . $e->getMessage() . "</p>";
        exit();
    }
}
?>