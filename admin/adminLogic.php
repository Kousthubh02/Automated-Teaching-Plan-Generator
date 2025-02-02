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

    // Initialize the array to hold key-value pairs from the CSV file
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

        // Read and parse CSV file (expecting two columns: date and reason)
        if (($handle = fopen($file_tmp_path, "r")) !== false) {
            $isFirstRow = true;
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                // If it's the header row, skip it
                if ($isFirstRow) {
                    $isFirstRow = false;
                    // Check if the first cell matches the expected date format
                    if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', trim($data[0]))) {
                        continue; // Skip header row
                    }
                }
                
                // Check if we have at least two columns
                if (count($data) >= 2) {
                    $dateStr = trim($data[0]);
                    $reason  = trim($data[1]);
                    
                    // Validate the date format: expecting dd-mm-yyyy (with dashes)
                    if (preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateStr)) {
                        // Create a DateTime object using the 'd-m-Y' format
                        $date_obj = DateTime::createFromFormat('d-m-Y', $dateStr);
                        if ($date_obj) {
                            // Store the date in dd-mm-yyyy format as the key and the reason as the value
                            $formatted_date = $date_obj->format('d-m-Y');
                            $exclude_dates_array[$formatted_date] = $reason;
                        } else {
                            // Optional: Log or display conversion issues
                            echo "Invalid date conversion: $dateStr<br>";
                        }
                    } else {
                        // Optionally, ignore or notify if the date format is invalid.
                        echo "Invalid date format: $dateStr<br>";
                    }
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

    // Convert the key-value array to JSON
    $json_excluded_dates = json_encode($exclude_dates_array);

    // Begin a transaction to handle the database insert
    $pdo->beginTransaction();

    try {
        // Insert into the database (update table/column names as needed)
        $stmt = $pdo->prepare("INSERT INTO teaching_dates (start_date, end_date, exclude_dates) VALUES (?, ?, ?)");
        $stmt->execute([$start_date, $end_date, $json_excluded_dates]);
    
        // Commit the transaction
        $pdo->commit();

        // Display success message
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
            <p>Dates and reasons have been saved successfully!</p>
        </div>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>';
        exit;
    } catch (Exception $e) {
        // Rollback the transaction if something goes wrong
        $pdo->rollBack();

        // Display error message
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
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.8s ease-in-out;
        ">
            <h2 style="margin: 0;">❌ Error:</h2>
            <p>An error occurred: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . '</p>
        </div>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>';
        exit;
    }
} else {
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
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        animation: fadeIn 0.8s ease-in-out;
    ">
        <h2 style="margin: 0;">❌ Error:</h2>
        <p>Invalid request method.</p>
    </div>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>';
}
?>
