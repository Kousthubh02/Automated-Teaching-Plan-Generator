<?php
// Include the database connection file
require_once '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'] ?? null;
    $end_date   = $_POST['end_date'] ?? null;

    // Validate start_date and end_date
    if (!$start_date || !$end_date) {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; 
              background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
              border-radius: 5px; text-align: center;">
              <strong>Error:</strong> Please provide both a start date and an end date.
              </div>';
        exit;
    }

    // Initialize the array to hold date information
    $exclude_dates_array = [];

    // Handle CSV file upload
    if (isset($_FILES['exclude_dates']) && $_FILES['exclude_dates']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['exclude_dates']['tmp_name'];
        $file_type     = mime_content_type($file_tmp_path);

        // Validate file type
        if ($file_type !== 'text/plain' && $file_type !== 'text/csv') {
            echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; 
                  background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
                  border-radius: 5px; text-align: center;">
                  <strong>Error:</strong> Please upload a valid CSV file.
                  </div>';
            exit;
        }

        // Read and parse CSV file (expecting three columns: date, reason, semester)
        if (($handle = fopen($file_tmp_path, "r")) !== false) {
            $isFirstRow = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                // Skip empty rows
                if (count($data) === 0 || (count($data) === 1 && trim($data[0]) === '')) {
                    continue;
                }

                // If it's the header row, skip it
                if ($isFirstRow) {
                    $isFirstRow = false;
                    // Check if the first cell matches the expected date format
                    if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', trim($data[0]))) {
                        continue; // Skip header row
                    }
                }
                
                // Check if we have at least three columns
                if (count($data) >= 3) {
                    $dateStr  = trim($data[0]);
                    $reason   = trim($data[1]);
                    $semester = trim($data[2]);
                    
                    // Validate the date format
                    if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateStr)) {
                        $date_obj = DateTime::createFromFormat('d-m-Y', $dateStr);
                        if ($date_obj) {
                            $formatted_date = $date_obj->format('d-m-Y');
                            // Store date with reason and semester
                            $exclude_dates_array[$formatted_date] = [
                                'reason'   => $reason,
                                'semester' => $semester
                            ];
                        }
                    }
                } else {
                    echo "Skipped invalid row: " . implode(', ', $data) . "<br>";
                }
            }
            fclose($handle);
        } else {
            echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; 
                  background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
                  border-radius: 5px; text-align: center;">
                  <strong>Error:</strong> Unable to read the uploaded file.
                  </div>';
            exit;
        }
    } else {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; 
              background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
              border-radius: 5px; text-align: center;">
              <strong>Error:</strong> No file uploaded or there was an error during upload.
              </div>';
        exit;
    }

    // Convert the array to JSON
    $json_excluded_dates = json_encode($exclude_dates_array);

    // Database insertion
    $pdo->beginTransaction();
    try {
        $stmt = $pdo->prepare("INSERT INTO teaching_dates (start_date, end_date, exclude_dates) VALUES (?, ?, ?)");
        $stmt->execute([$start_date, $end_date, $json_excluded_dates]);
        $pdo->commit();

        // Success message
        echo '
        <div style="
            font-family: Arial, sans-serif;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
            border-radius: 8px;
            text-align: center;
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        ">
            <h2 style="margin: 0;">🎉 Success!</h2>
            <p>Dates, reasons, and semesters have been saved successfully!</p>
        </div>';
    } catch (Exception $e) {
        $pdo->rollBack();
        echo '
        <div style="
            font-family: Arial, sans-serif;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 8px;
            text-align: center;
            width: 90%;
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
        ">
            <h2 style="margin: 0;">❌ Error:</h2>
            <p>An error occurred: ' . htmlspecialchars($e->getMessage()) . '</p>
        </div>';
    }
} else {
    // Invalid request method message
    echo '
    <div style="
        font-family: Arial, sans-serif;
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        border-radius: 8px;
        text-align: center;
        width: 90%;
        max-width: 500px;
        margin: 50px auto;
        padding: 20px;
    ">
        <h2 style="margin: 0;">❌ Error:</h2>
        <p>Invalid request method.</p>
    </div>';
}
?>