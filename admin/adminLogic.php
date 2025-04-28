<?php
// Include the database connection file
require_once '../database/db_connection.php';

// ----- Branch 1: Delete Non Teaching Dates -----
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete_non_teaching_dates') {
    header('Content-Type: application/json');
    error_log("Delete non-teaching dates action triggered in adminLogic.php");
    try {
        // Use DELETE instead of TRUNCATE to avoid issues with foreign keys
        $numRows = $pdo->exec("DELETE FROM teaching_dates");
        error_log("Number of rows deleted from teaching_dates: " . $numRows);
        
        // Reset auto-increment counter (optional)
        $pdo->exec("ALTER TABLE teaching_dates AUTO_INCREMENT = 1");
        
        echo json_encode([
            'status'  => 'success',
            'message' => 'Non-teaching dates have been cleared successfully. Rows deleted: ' . $numRows
        ]);
    } catch (PDOException $e) {
        error_log("Error deleting non-teaching dates: " . $e->getMessage());
        echo json_encode([
            'status'  => 'error',
            'message' => 'Error deleting non-teaching dates: ' . $e->getMessage()
        ]);
    }
    exit;
}

// ----- Branch 2: Delete a Specific Teaching Plan Entry -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['action']) 
    && $_POST['action'] === 'delete_teaching_plan'
) {
    header('Content-Type: application/json');

    // Log the entire POST array for debugging
    error_log("Received POST data: " . print_r($_POST, true));

    // Retrieve, trim, and validate POST parameters
    $semester = isset($_POST['semester']) ? trim($_POST['semester']) : '';
    $subjectId = isset($_POST['subject']) ? trim($_POST['subject']) : ''; // subject sent as id
    $division = isset($_POST['division']) ? trim($_POST['division']) : '';

    error_log("Parameters after trimming: sem_id=[$semester], subject id=[$subjectId], division=[$division]");

    if (!$semester || !$subjectId || !$division) {
        error_log("Missing one or more parameters for deletion.");
        echo json_encode([
            'status'  => 'error',
            'message' => 'Missing parameters for deleting teaching plan entry.'
        ]);
        exit;
    }

    try {
        // Convert subject id to subject name from subject_table
        $subjectQuery = $pdo->prepare("SELECT sub FROM subject_table WHERE sub_id = ?");
        $subjectQuery->execute([$subjectId]);
        $subjectRow = $subjectQuery->fetch(PDO::FETCH_ASSOC);
        if ($subjectRow) {
            $subjectName = trim($subjectRow['sub']);
            error_log("Converted subject id [$subjectId] to subject name [$subjectName]");
        } else {
            error_log("Subject id [$subjectId] not found in subject_table.");
            echo json_encode([
                'status'  => 'error',
                'message' => "Subject id [$subjectId] not found."
            ]);
            exit;
        }

        // Debug: Check for matching rows using the given criteria in teaching_plan
        $selectStmt = $pdo->prepare("SELECT * FROM teaching_plan WHERE sem_id = ? AND subject = ? AND division = ?");
        $selectStmt->execute([$semester, $subjectName, $division]);
        $matchingRows = $selectStmt->fetchAll(PDO::FETCH_ASSOC);
        error_log("Matching rows for the given criteria in teaching_plan:\n" . print_r($matchingRows, true));

        // If no matching rows are found, log all rows from the table for inspection
        if (count($matchingRows) === 0) {
            $allStmt = $pdo->query("SELECT * FROM teaching_plan");
            $allRows = $allStmt->fetchAll(PDO::FETCH_ASSOC);
            error_log("All rows in teaching_plan table:\n" . print_r($allRows, true));
        }

        // Start a transaction to ensure both deletions succeed or fail together
        $pdo->beginTransaction();

        // Step 1: Delete from teaching_plan
        $stmt = $pdo->prepare("DELETE FROM teaching_plan WHERE sem_id = ? AND subject = ? AND division = ?");
        $stmt->execute([$semester, $subjectName, $division]);
        $affectedRowsTeachingPlan = $stmt->rowCount();
        error_log("Number of rows deleted from teaching_plan: " . $affectedRowsTeachingPlan);

        // Step 2: Delete from reference_table using sub_id 
        $stmtRef = $pdo->prepare("DELETE FROM reference_table WHERE sub_id = ? AND division = ?");
        $stmtRef->execute([$subjectId, $division]);
        $affectedRowsReference = $stmtRef->rowCount();
        error_log("Number of rows deleted from reference_table: " . $affectedRowsReference);

        // Step 3: Delete from missing_content_table using subject 
        $stmtRef = $pdo->prepare("DELETE FROM missing_content_table WHERE sem_id = ? AND subject = ? AND division = ?");
        $stmtRef->execute([$semester, $subjectName, $division]);
        $affectedRowsMCT = $stmtRef->rowCount();
        error_log("Number of rows deleted from missing_content_table: " . $affectedRowsMCT);

        // Commit the transaction
        $pdo->commit();

        if ($affectedRowsTeachingPlan > 0 || $affectedRowsReference > 0) {
            error_log("Deletion successful for: sem_id=[$semester], subject=[$subjectName], division=[$division]");
            echo json_encode([
                'status'  => 'success',
                'message' => "Successfully deleted the teaching plan entry. Rows deleted from teaching_plan: $affectedRowsTeachingPlan, from reference_table: $affectedRowsReference, from missing_content_table: $affectedRowsMCT"
            ]);
        } else {
            error_log("Deletion executed but no matching entry was found to delete in either table.");
            echo json_encode([
                'status'  => 'info',
                'message' => "No matching entries found to delete in teaching_plan or reference_table."
            ]);
        }
    } catch (PDOException $e) {
        // Roll back the transaction on error
        $pdo->rollBack();
        error_log("Error deleting teaching plan entry: " . $e->getMessage());
        echo json_encode([
            'status'  => 'error',
            'message' => "Error deleting teaching plan entry: " . $e->getMessage()
        ]);
    }
    exit;
}

// ----- Branch 3: Delete ALL Teaching Plan Entries -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['action']) 
    && $_POST['action'] === 'delete_all_teaching_plan'
) {
    header('Content-Type: application/json');
    error_log("Delete ALL teaching plan entries action triggered.");

    try {
        // Start a transaction to ensure both deletions succeed or fail together
        $pdo->beginTransaction();

        // Step 1: Delete all rows from teaching_plan table
        $stmt = $pdo->prepare("DELETE FROM teaching_plan");
        $stmt->execute();
        $affectedRowsTeachingPlan = $stmt->rowCount();
        error_log("Number of rows deleted from teaching_plan: " . $affectedRowsTeachingPlan);

        // Step 2: Delete all rows from reference_table
        $stmtRef = $pdo->prepare("DELETE FROM reference_table");
        $stmtRef->execute();
        $affectedRowsReference = $stmtRef->rowCount();
        error_log("Number of rows deleted from reference_table: " . $affectedRowsReference);

        // Step 3: Delete all rows from missing_content_table
        $stmt = $pdo->prepare("DELETE FROM missing_content_table");
        $stmt->execute();
        $affectedRowsMCT = $stmt->rowCount();
        error_log("Number of rows deleted from teaching_plan: " . $affectedRowsMCT);

        // Commit the transaction
        $pdo->commit();

        echo json_encode([
            'status'  => 'success',
            'message' => "All teaching plan entries have been deleted successfully. Rows deleted from teaching_plan: $affectedRowsTeachingPlan, from reference_table: $affectedRowsReference, from missing_content_table: $affectedRowsMCT"
        ]);

        // Reset auto-increment counter (optional)
        $pdo->exec("ALTER TABLE teaching_plan AUTO_INCREMENT = 1");
        $pdo->exec("ALTER TABLE reference_table AUTO_INCREMENT = 1");


    } catch (PDOException $e) {
        // Roll back the transaction on error
        $pdo->rollBack();
        error_log("Error deleting all teaching plan entries: " . $e->getMessage());
        echo json_encode([
            'status'  => 'error',
            'message' => "Error deleting all teaching plan entries: " . $e->getMessage()
        ]);
    }
    exit;
}

// ----- Branch 4: Toggle Lock Teaching Dates -----
if ($_SERVER['REQUEST_METHOD'] === 'POST' 
    && isset($_POST['action']) 
    && $_POST['action'] === 'toggle_lock_teaching_plan'
) {
    try {
        // Fetch the current editable value
        $sql = "SELECT editable FROM settings WHERE id = 1";
        $stmt = $pdo->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // In adminLogic.php (toggle_lock_teaching_plan branch)
        if ($row) {
            $currentValue = $row['editable'];
            $newValue = $currentValue == 1 ? 0 : 1;
            
            $updateSql = "UPDATE settings SET editable = :newValue WHERE id = 1";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute(['newValue' => $newValue]);
            
            // Return JSON instead of redirecting
            header('Content-Type: application/json');
            echo json_encode([
                'status' => 'success',
                'newValue' => $newValue,
                'message' => 'Editable status updated'
            ]);
            exit;
        } else {
            die("No record found with id = 1");
        }
    } catch (PDOException $e) {
        die("Error updating record: " . $e->getMessage());
    }
}

// ----- Branch 5: CSV Upload/Inserting Teaching Dates -----
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'] ?? null;
    $end_date   = $_POST['end_date'] ?? null;

    // Validate start_date and end_date
    if (!$start_date || !$end_date) {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px auto; 
              background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
              border-radius: 5px; text-align: center; width: 90%; max-width: 500px;">
              <h2 style="margin: 0 0 15px 0;">❌ Error:</h2>
              <p style="margin-bottom: 20px;">Please provide both a start date and an end date.</p>
              <div style="text-align: center;">
                  <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                     background-color: #dc3545; color: white; text-decoration: none;
                     border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                     Go Back to Home Page
                  </a>
              </div>
              </div>';
        exit;
    }

    // Handle CSV file upload
    if (isset($_FILES['exclude_dates']) && $_FILES['exclude_dates']['error'] == UPLOAD_ERR_OK) {
        $file_tmp_path = $_FILES['exclude_dates']['tmp_name'];
        $file_type     = mime_content_type($file_tmp_path);

        // Validate file type
        if ($file_type !== 'text/plain' && $file_type !== 'text/csv') {
            echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px auto; 
                  background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
                  border-radius: 5px; text-align: center; width: 90%; max-width: 500px;">
                  <h2 style="margin: 0 0 15px 0;">❌ Error:</h2>
                  <p style="margin-bottom: 20px;">Please upload a valid CSV file.</p>
                  <div style="text-align: center;">
                      <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                         background-color: #dc3545; color: white; text-decoration: none;
                         border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                         Go Back to Home Page
                      </a>
                  </div>
                  </div>';
            exit;
        }

        // Initialize variables for validation
        $exclude_dates_array = [];
        $invalid_dates = [];
        $has_errors = false;
        $error_message = '';

        // Read and parse CSV file
        if (($handle = fopen($file_tmp_path, "r")) !== false) {
            $line_number = 0;
            $isFirstRow = true;
            
            while (($data = fgetcsv($handle, 1000, ",")) !== false) {
                $line_number++;
                
                // Skip empty rows
                if (count($data) === 0 || (count($data) === 1 && trim($data[0]) === '')) {
                    continue;
                }

                // Check if it's the header row
                if ($isFirstRow && !preg_match('/^\d{2}-\d{2}-\d{4}$/', trim($data[0]))) {
                    $isFirstRow = false;
                    continue;
                }

                // Validate row has at least 3 columns
                if (count($data) < 3) {
                    $has_errors = true;
                    $error_message .= "• Line $line_number: Invalid format (expected date, reason, semester)<br>";
                    continue;
                }

                $dateStr  = trim($data[0]);
                $reason   = trim($data[1]);
                $semester = trim($data[2]);
                
                // Validate the date format
                if (!preg_match('/^\d{2}-\d{2}-\d{4}$/', $dateStr)) {
                    $has_errors = true;
                    $invalid_dates[] = $dateStr;
                    $error_message .= "• Line $line_number: Invalid date format '$dateStr' (must be DD-MM-YYYY)<br>";
                    continue;
                }

                // Validate the date is actually valid (e.g., not 31-02-2023)
                $date_parts = explode('-', $dateStr);
                if (!checkdate($date_parts[1], $date_parts[0], $date_parts[2])) {
                    $has_errors = true;
                    $invalid_dates[] = $dateStr;
                    $error_message .= "• Line $line_number: Invalid date '$dateStr' (not a valid calendar date)<br>";
                    continue;
                }

                // If we got here, the date is valid
                $exclude_dates_array[$dateStr] = [
                    'reason'   => $reason,
                    'semester' => $semester
                ];
            }
            fclose($handle);
        } else {
            echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px auto; 
                  background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
                  border-radius: 5px; text-align: center; width: 90%; max-width: 500px;">
                  <h2 style="margin: 0 0 15px 0;">❌ Error:</h2>
                  <p style="margin-bottom: 20px;">Unable to read the uploaded file.</p>
                  <div style="text-align: center;">
                      <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                         background-color: #dc3545; color: white; text-decoration: none;
                         border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                         Go Back to Home Page
                      </a>
                  </div>
                  </div>';
            exit;
        }

        // If there were any invalid dates, show error and don't proceed
        if ($has_errors) {
            echo '<div style="font-family: Arial, sans-serif; padding: 25px; margin: 20px auto; 
                  background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; 
                  border-radius: 8px; max-width: 800px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                  <h3 style="margin: 0 0 15px 0; color: #d58512;">⚠️ Invalid Dates Found in CSV File</h3>
                  <p style="margin-bottom: 15px;">Please correct these errors and upload again:</p>
                  <div style="background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #ffc107; 
                       margin: 0 auto 20px auto; text-align: left; font-family: monospace; white-space: pre-wrap; max-width: 90%;">
                  ' . $error_message . '
                  </div>
                  <p style="margin-bottom: 20px;">All dates must be in DD-MM-YYYY format and valid calendar dates.</p>
                  <div style="text-align: center;">
                      <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                         background-color: #ffc107; color: #856404; text-decoration: none;
                         border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                         Go Back to Home Page
                      </a>
                  </div>
                  </div>';
            exit;
        }

        // If we got here, all dates are valid - proceed with database insertion
        $json_excluded_dates = json_encode($exclude_dates_array);

        // Insert the new teaching dates data into the database
        $pdo->beginTransaction();
        try {
            $stmt = $pdo->prepare("INSERT INTO teaching_dates (start_date, end_date, exclude_dates) VALUES (?, ?, ?)");
            $stmt->execute([$start_date, $end_date, $json_excluded_dates]);
            $pdo->commit();

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
                <h2 style="margin: 0 0 15px 0;">🎉 Success!</h2>
                <p style="margin-bottom: 15px;">All dates were valid and have been saved successfully!</p>
                <p style="margin-bottom: 20px;">' . count($exclude_dates_array) . ' dates processed.</p>
                <div style="text-align: center;">
                    <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                       background-color: #28a745; color: white; text-decoration: none;
                       border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                       Go Back to Home Page
                    </a>
                </div>
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
                <h2 style="margin: 0 0 15px 0;">❌ Database Error:</h2>
                <p style="margin-bottom: 20px;">' . htmlspecialchars($e->getMessage()) . '</p>
                <div style="text-align: center;">
                    <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                       background-color: #dc3545; color: white; text-decoration: none;
                       border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                       Go Back to Home Page
                    </a>
                </div>
            </div>';
        }
        exit;
    } else {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px auto; 
              background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; 
              border-radius: 5px; text-align: center; width: 90%; max-width: 500px;">
              <h2 style="margin: 0 0 15px 0;">❌ Error:</h2>
              <p style="margin-bottom: 20px;">No file uploaded or there was an error during upload.</p>
              <div style="text-align: center;">
                  <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
                     background-color: #dc3545; color: white; text-decoration: none;
                     border-radius: 5px; transition: all 0.3s; font-weight: 500;">
                     Go Back to Home Page
                  </a>
              </div>
              </div>';
        exit;
    }
}

// If the request method isn't POST, show an error message.
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
    <h2 style="margin: 0 0 15px 0;">❌ Error:</h2>
    <p style="margin-bottom: 20px;">Invalid request method.</p>
    <div style="text-align: center;">
        <a href="../admin/admin_2.php" style="display: inline-block; padding: 10px 25px;
           background-color: #dc3545; color: white; text-decoration: none;
           border-radius: 5px; transition: all 0.3s; font-weight: 500;">
           Go Back to Home Page
        </a>
    </div>
</div>';
?>