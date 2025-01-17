<?php
// Include the database connection file
require_once '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;

    // Validate start_date and end_date
    if (!$start_date || !$end_date) {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 70%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
        echo '<strong>Error:</strong> Please provide both a start date and an end date.';
        echo '</div>';
        exit;
    }

    // Handle CSV file upload
    $exclude_dates_array = [];
    if (isset($_FILES['exclude_dates']) && $_FILES['exclude_dates']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['exclude_dates']['tmp_name'];
        $file_type = mime_content_type($file_tmp_path);

        // Validate file type
        if ($file_type !== 'text/plain' && $file_type !== 'text/csv') {
            echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 70%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
            echo '<strong>Error:</strong> Please upload a valid CSV file.';
            echo '</div>';
            exit;
        }

        // Read and parse CSV file
        if (($handle = fopen($file_tmp_path, "r")) !== false) {
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                foreach ($data as $date) {
                    $date = trim($date);
                    if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) { // Validate date format YYYY-MM-DD
                        $exclude_dates_array[] = $date;
                    }
                }
            }
            fclose($handle);
        } else {
            echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 70%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
            echo '<strong>Error:</strong> Unable to read the uploaded file.';
            echo '</div>';
            exit;
        }
    } else {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 70%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
        echo '<strong>Error:</strong> No file uploaded or there was an error during upload.';
        echo '</div>';
        exit;
    }

    $json_excluded_dates = json_encode($exclude_dates_array);

    $pdo->beginTransaction();

    try {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO teaching_dates (start_date, end_date, exclude_dates) VALUES (?, ?, ?)");
        $stmt->execute([$start_date, $end_date, $json_excluded_dates]);
    
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
            <p>Dates have been saved successfully!</p>
        </div>
        <style>
            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(-10px); }
                to { opacity: 1; transform: translateY(0); }
            }
        </style>';
        exit;
    } catch (Exception $e) {
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
    

