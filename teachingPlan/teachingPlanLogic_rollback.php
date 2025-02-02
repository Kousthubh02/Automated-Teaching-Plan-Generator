<?php
// Include the database connection file
require '../database/db_connection.php';

// Initialize variables
$lectureNumber = 1;
$message = '';
$plans = [];
$subject = isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : 'Unknown'; // Safe initialization of subject
$editable = 0; // Default editable status

// Check if a subject is set via GET request
if ($subject !== 'Unknown') {
    try {
        // Prepare and execute query to get current teaching plans with the specified columns
        $sql = "SELECT tp.pk, tp.proposed_date, tp.content, tp.actual_date, tp.content_not_covered, tp.reference, tp.methodology, tp.co_mapping, tp.verified_by_hod 
                FROM teaching_plan tp
                LEFT JOIN teaching_dates td ON tp.proposed_date = td.exclude_date
                WHERE tp.subject = :subject";
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

// Handle form submission (Save data)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Process the data and save it to the database here
    try {
        foreach ($_POST['content'] as $pk => $content) {
            $content_not_covered = $_POST['content_not_covered'][$pk];
            $reference = $_POST['reference'][$pk];
            $methodology = $_POST['methodology'][$pk];
            $co_mapping = $_POST['co_mapping'][$pk];

            // Prepare your update query here
            $sql = "UPDATE teaching_plan SET 
                    content = :content,
                    content_not_covered = :content_not_covered,
                    reference = :reference,
                    methodology = :methodology,
                    co_mapping = :co_mapping 
                    WHERE pk = :pk";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'content' => $content,
                'content_not_covered' => $content_not_covered,
                'reference' => $reference,
                'methodology' => $methodology,
                'co_mapping' => $co_mapping,
                'pk' => $pk
            ]);
        }
        $message = 'Data has been successfully saved.';
        header("Location: " . $_SERVER['PHP_SELF'] . "?subject=" . urlencode($subject));
        exit();
    } catch (PDOException $e) {
        $message = 'Error saving data: ' . $e->getMessage();
    }
}

// Close the connection
$pdo = null;

// Calculate total lectures count
$totalLectures = count($plans);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Plans</title>
    <style>
        /* Existing styles */

        .grey-row {
            background-color: #d3d3d3;
        }

        .editable-input.grey-input {
            background-color: #b0b0b0;
        }

        .empty-lecture {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Teaching Plans for <?= htmlspecialchars($subject ?: 'Unknown') ?></h2>

    <!-- Small Popup Modal -->
    <div id="messageModal" class="modal">
        <div class="modal-content">
            <span id="messageText"></span>
        </div>
    </div>

    <!-- Teaching plan table and form -->
    <form id="teachingplan" method="post"
        action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?subject=<?= urlencode($subject) ?>"
        onsubmit="saveData(event)">
        <table>
            <tr>
                <th>Lecture Number</th>
                <th>Proposed Date</th>
                <th>Content</th>
                <th>Actual Date</th>
                <th>Content Not Covered</th>
                <th>Reference</th>
                <th>Methodology</th>
                <th>CO Mapping</th>
                <th>Remarks</th>
                <th>Verified by HOD</th>
            </tr>
            <?php foreach ($plans as $plan): ?>
                <?php
                // Determine if the row is a non-teaching day.
                // If the proposed_date is in the teaching_dates table, then no lecture number is assigned.
                if ($plan['exclude_date']) {
                    $lectureNumberCell = '';
                    $rowClass = 'grey-row';
                    $inputClass = 'grey-input';
                } else {
                    $lectureNumberCell = $lectureNumber++;
                    $rowClass = '';
                    $inputClass = '';
                }
                ?>
                <tr class="<?= $rowClass ?>">
                    <td class="empty-lecture"><?= $lectureNumberCell ?></td>
                    <td>
                        <input type="hidden" name="proposed_date[<?= $plan['pk'] ?>]"
                            value="<?= htmlspecialchars($plan['proposed_date']) ?>">
                        <?php
                        // Format the date from Y-m-d to d-m-Y if possible
                        $formattedDate = DateTime::createFromFormat('Y-m-d', $plan['proposed_date']);
                        echo htmlspecialchars($formattedDate ? $formattedDate->format('d-m-Y') : $plan['proposed_date']);
                        ?>
                    </td>
                    <td>
                        <textarea class="editable-input <?= $inputClass ?>" name="content[<?= $plan['pk'] ?>]"
                            placeholder="Enter content" <?= $editable == 0 ? 'readonly' : '' ?>
                            oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"><?= htmlspecialchars($plan['content'] ?: '') ?></textarea>
                    </td>
                    <td></td>
                    <td>
                        <textarea class="editable-input <?= $inputClass ?>" name="content_not_covered[<?= $plan['pk'] ?>]"
                            placeholder="Enter content not covered" <?= $editable == 0 ? 'readonly' : '' ?>
                            oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"><?= htmlspecialchars($plan['content_not_covered'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <textarea class="editable-input <?= $inputClass ?>" name="reference[<?= $plan['pk'] ?>]"
                            placeholder="Enter references" <?= $editable == 0 ? 'readonly' : '' ?>
                            oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"><?= htmlspecialchars($plan['reference'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <textarea class="editable-input <?= $inputClass ?>" name="methodology[<?= $plan['pk'] ?>]"
                            placeholder="Enter methodology" <?= $editable == 0 ? 'readonly' : '' ?>
                            oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"><?= htmlspecialchars($plan['methodology'] ?: '') ?></textarea>
                    </td>
                    <td>
                        <select class="editable-input <?= $inputClass ?>" name="co_mapping[<?= $plan['pk'] ?>]"
                            <?= $editable == 0 ? 'disabled' : '' ?>>
                            <option value="">Select CO</option>
                            <option value="CO1" <?= $plan['co_mapping'] == 'CO1' ? 'selected' : '' ?>>CO1</option>
                            <option value="CO2" <?= $plan['co_mapping'] == 'CO2' ? 'selected' : '' ?>>CO2</option>
                            <option value="CO3" <?= $plan['co_mapping'] == 'CO3' ? 'selected' : '' ?>>CO3</option>
                            <option value="CO4" <?= $plan['co_mapping'] == 'CO4' ? 'selected' : '' ?>>CO4</option>
                            <option value="CO5" <?= $plan['co_mapping'] == 'CO5' ? 'selected' : '' ?>>CO5</option>
                            <option value="CO6" <?= $plan['co_mapping'] == 'CO6' ? 'selected' : '' ?>>CO6</option>
                        </select>
                    </td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>

        </table>
        <button type="submit" class="submit-btn" <?= $editable == 0 ? 'disabled' : '' ?>>Save Changes</button>
    </form>

    <!-- Display message on submission -->
    <div class="total-lectures-box">
        Total Lectures: <?= $totalLectures ?>
    </div>

    <script>
        // Existing JavaScript code
    </script>
</body>

</html>