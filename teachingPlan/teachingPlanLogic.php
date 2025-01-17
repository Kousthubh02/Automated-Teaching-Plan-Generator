<?php
// Include the database connection file
require '../database/db_connection.php';

// Initialize variables
$message = '';
$plans = [];
$subject = '';
$editable = 0; // Default editable status

// Check if a subject is set via GET request
if (isset($_GET['subject']) && $_GET['subject'] !== '') {
    $subject = htmlspecialchars($_GET['subject']); // Sanitize input

    try {
        // Prepare and execute query to get current teaching plans with the specified columns
        $sql = "SELECT pk, proposed_date, content, actual_date, content_not_covered, reference, methodology FROM teaching_plan WHERE subject = :subject";
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

    // Get the current editable status from settings table
    try {
        $sql = "SELECT editable FROM settings WHERE id = 1"; // Assuming settings has id = 1
        $stmt = $pdo->query($sql);
        $editable = $stmt->fetchColumn();
    } catch (PDOException $e) {
        $message = 'Error fetching editable status: ' . $e->getMessage();
    }
} else {
    $message = 'Please select a subject.';
}

// Save changes to the database if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Get data from the form
        $contents = $_POST['content'] ?? [];
        $actualDates = $_POST['actual_date'] ?? [];
        $contentNotCovered = $_POST['content_not_covered'] ?? [];
        $references = $_POST['reference'] ?? [];
        $methodologies = $_POST['methodology'] ?? [];

        // Update each teaching plan in the database
        foreach ($contents as $pk => $content) {
            $actualDate = $actualDates[$pk] ?? null;
            $contentNotCoveredText = $contentNotCovered[$pk] ?? null;
            $reference = $references[$pk] ?? null;
            $methodology = $methodologies[$pk] ?? null;

            // Prepare and execute the update query
            $updateSql = "UPDATE teaching_plan SET content = :content, actual_date = :actual_date, content_not_covered = :content_not_covered, reference = :reference, methodology = :methodology WHERE pk = :pk";
            $updateStmt = $pdo->prepare($updateSql);
            $updateStmt->execute([
                'content' => $content,
                'actual_date' => $actualDate,
                'content_not_covered' => $contentNotCoveredText,
                'reference' => $reference,
                'methodology' => $methodology,
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
     /* Modal and table styles */
body { 
    font-family: Arial, sans-serif; 
    background-color: #f4f7fa; 
    margin: 0; 
    padding: 20px; 
    color: #333; 
}
h2 { 
    text-align: center; 
    color: #4CAF50; 
    margin-bottom: 20px; 
}
table { 
    width: 100%; 
    margin: 0 auto; 
    border-collapse: collapse; 
    box-shadow: 0 2px 4px rgba(0,0,0,0.1); 
}
th, td { 
    padding: 15px; 
    text-align: left; 
    border: 1px solid #ddd; 
    background-color: #fff; 
}
th { 
    background-color: #4CAF50; 
    color: white; 
}
.editable-input { 
    width: 100%; 
    height: 50px; 
    padding: 10px; 
    font-size: 16px; 
    resize: none; 
    box-sizing: border-box;
}

/* To prevent calendar icon overlap */
input[type="date"] {
    position: relative;
    z-index: 1; /* Ensures the calendar icon is above other elements */
}

/* Button styles */
.submit-btn { 
    display: block; 
    margin: 20px auto; 
    padding: 10px 20px; 
    background-color: #4CAF50; 
    color: white; 
    border: none; 
    border-radius: 5px; 
    font-size: 18px; 
    cursor: pointer; 
}
.submit-btn:hover { 
    background-color: #45a049; 
}

/* Modal styles */
.modal { 
    display: none; 
    position: fixed; 
    top: 0; 
    left: 0; 
    width: 100%; 
    height: 100%; 
    background-color: rgba(0, 0, 0, 0.5); 
    z-index: 1000; /* Ensure modal appears on top */
}
.modal-content { 
    background-color: #fff; 
    margin: 15% auto; 
    padding: 20px; 
    border-radius: 5px; 
    width: 80%; 
    max-width: 500px; 
}
.modal-header { 
    font-size: 20px; 
    font-weight: bold; 
    color: #4CAF50; 
}
.modal-body { 
    padding: 15px; 
}
.modal-footer { 
    text-align: center; 
}
.close-btn { 
    padding: 10px 20px; 
    background-color: #4CAF50; 
    color: white; 
    border: none; 
    border-radius: 5px; 
    cursor: pointer; 
}
.close-btn:hover { 
    background-color: #45a049; 
}

/* Responsive styles */
@media (max-width: 768px) {
    table { font-size: 14px; }
    .editable-input { font-size: 14px; }
}

    </style>
</head>
<body>

    <h2>Teaching Plans for <?= htmlspecialchars($subject ?: 'Unknown') ?></h2>

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
                <th>Proposed Date</th>
                <th>Content</th>
                <th>Actual Date</th>
                <th>Content Not Covered</th>
                <th>Reference</th>
                <th>Methodology</th>
            </tr>
            <?php foreach ($plans as $plan): ?>
                <tr>
                    <td>
                        <?php
                        // Format proposed_date as dd-mm-yyyy
                        $formattedDate = DateTime::createFromFormat('Y-m-d', $plan['proposed_date']);
                        echo htmlspecialchars($formattedDate ? $formattedDate->format('d-m-Y') : $plan['proposed_date']);
                        ?>
                    </td>
                    <td>
                        <textarea 
                            class="editable-input" 
                            name="content[<?= $plan['pk'] ?>]" 
                            placeholder="Enter content" <?= $editable == 0 ? 'readonly' : '' ?>><?= htmlspecialchars($plan['content'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <input type="date" name="actual_date[<?= $plan['pk'] ?>]" class="editable-input" value="<?= htmlspecialchars($plan['actual_date'] ?: '') ?>" <?= $editable == 0 ? 'readonly' : '' ?>>
                    </td>
                    <td>
                        <textarea 
                            class="editable-input" 
                            name="content_not_covered[<?= $plan['pk'] ?>]" 
                            placeholder="Enter content not covered" <?= $editable == 0 ? 'readonly' : '' ?>><?= htmlspecialchars($plan['content_not_covered'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <textarea 
                            class="editable-input" 
                            name="reference[<?= $plan['pk'] ?>]" 
                            placeholder="Enter reference" <?= $editable == 0 ? 'readonly' : '' ?>><?= htmlspecialchars($plan['reference'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <textarea 
                            class="editable-input" 
                            name="methodology[<?= $plan['pk'] ?>]" 
                            placeholder="Enter methodology" <?= $editable == 0 ? 'readonly' : '' ?>><?= htmlspecialchars($plan['methodology'] ?: '') ?></textarea>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
        <button type="submit" class="submit-btn">Save Changes</button>
    </form>

    <script>
        <?php if ($message): ?>
            // Display the error or success message modal on page load
            window.onload = function() {
                document.getElementById('messageModal').style.display = 'block';
            };
        <?php endif; ?>
    </script>

</body>
</html>
