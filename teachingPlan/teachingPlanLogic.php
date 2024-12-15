<?php
// Include database connection
require '../database/db_connection.php';

// Initialize variables
$message = '';
$plans = [];
$subject = '';

// Check if a subject is set via GET request
if (isset($_GET['subject']) && $_GET['subject'] !== '') {
    $subject = htmlspecialchars($_GET['subject']); // Sanitize input

    try {
        // Prepare and execute query to get current teaching plans
        $sql = "SELECT pk, teaching_date, content FROM teaching_plan WHERE subject = :subject";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['subject' => $subject]);

        // Fetch data
        $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (!$plans) {
            $message = 'No teaching plans available for the selected subject.';
        }
    } catch (PDOException $e) {
        $message = 'Error fetching data: ' . $e->getMessage();
    }
} else {
    $message = 'Please select a subject.';
}

// Save changes to the database if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $contents = $_POST['content'] ?? [];
        $actualDates = $_POST['actual_date'] ?? [];
        $remarks = $_POST['remarks'] ?? [];

        // Update each teaching plan in the database
        foreach ($contents as $pk => $content) {
            $actualDate = $actualDates[$pk] ?? null;
            $remark = $remarks[$pk] ?? null;

            // Prepare and execute the update query
            $updateSql = "UPDATE teaching_plan SET content = :content, actual_date = :actual_date, remarks = :remarks WHERE pk = :pk";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'content' => $content,
                'actual_date' => $actualDate,
                'remarks' => $remark,
                'pk' => $pk
            ]);
        }

        // Set success message
        $message = 'Data has been successfully sent to the database!';
        
    } catch (PDOException $e) {
        $message = 'Error updating data: ' . $e->getMessage();
    }
}

// Close the connection
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Plans</title>
    <style>
        /* Your existing styles here */
        
        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5); /* Background overlay */
            padding-top: 60px;
            text-align: center;
        }
        .modal-content {
            background-color: #fff;
            margin: 5% auto;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
        }
        .modal-header {
            font-size: 24px;
            font-weight: bold;
        }
        .modal-body {
            font-size: 18px;
        }
        .modal-footer {
            margin-top: 20px;
        }
        .close-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }
        .close-btn:hover {
            background-color: #45a049;
        }

        /* Additional styles for table and form */
        body { font-family: Arial, sans-serif; background-color: #f4f7fa; margin: 0; padding: 20px; color: #333; }
        h2, h3 { text-align: center; color: #4CAF50; margin-bottom: 20px; }
        table { width: 100%; margin: 0 auto; border-collapse: collapse; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        th, td { padding: 15px; text-align: left; border: 1px solid #ddd; background-color: #fff; }
        th { background-color: #4CAF50; color: white; }
        .editable-input { width: 100%; height: 50px; padding: 10px; font-size: 16px; resize: none; }
        .submit-btn { display: block; margin: 20px auto; padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 5px; font-size: 18px; cursor: pointer; }
        .submit-btn:hover { background-color: #45a049; }
        @media (max-width: 768px) {
            table { font-size: 14px; }
            .editable-input { font-size: 14px; }
        }
    </style>
</head>
<body>
    <h2>Teaching Plans for <?= htmlspecialchars($subject ?: 'Unknown') ?></h2>

    <?php if ($message): ?>
        <script>
            // Display modal when there's a message (success or error)
            window.onload = function() {
                const messageModal = document.getElementById('messageModal');
                messageModal.style.display = 'block';
            };
        </script>
    <?php endif; ?>

    <!-- Modal for success/error message -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <div class="modal-header"><?= strpos($message, 'successfully') !== false ? 'Success' : 'Error' ?></div>
            <div class="modal-body"><?= htmlspecialchars($message) ?></div>
            <div class="modal-footer">
                <button class="close-btn" onclick="document.getElementById('messageModal').style.display = 'none';">Close</button>
            </div>
        </div>
    </div>

    <!-- Teaching plan table and form -->
    <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?subject=<?= urlencode($subject) ?>">
        <table>
            <tr>
                <th>Proposed Teaching Date</th>
                <th>Content</th>
                <th>Actual Teaching Date</th>
                <th>Remarks</th>
            </tr>
            <?php foreach ($plans as $plan): ?>
                <tr>
                    <td>
                        <?php
                        // Format teaching_date as dd-mm-yyyy
                        $formattedDate = DateTime::createFromFormat('Y-m-d', $plan['teaching_date']);
                        echo htmlspecialchars($formattedDate ? $formattedDate->format('d-m-Y') : $plan['teaching_date']);
                        ?>
                    </td>
                    <td>
                        <textarea 
                            class="editable-input" 
                            name="content[<?= $plan['pk'] ?>]" 
                            placeholder="Enter content"><?= htmlspecialchars($plan['content'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <input type="date" name="actual_date[<?= $plan['pk'] ?>]" class="editable-input">
                    </td>
                    <td>
                        <textarea 
                            class="editable-input" 
                            name="remarks[<?= $plan['pk'] ?>]" 
                            placeholder="Enter remarks"></textarea>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" class="submit-btn">Save Changes</button>
    </form>
</body>
</html>
