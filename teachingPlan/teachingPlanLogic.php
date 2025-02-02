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
        $sql = "SELECT pk, proposed_date, content, actual_date, content_not_covered, reference, methodology, co_mapping, verified_by_hod FROM teaching_plan WHERE subject = :subject";
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
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
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
            padding: 10px;
            font-size: 16px;
            box-sizing: border-box;
            resize: none;
        }

        input[type="date"] {
            position: relative;
            z-index: 1;
        }

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

        .grey-row {
            background-color: #d3d3d3;
        }

        .editable-input.grey-input {
            background-color: #b0b0b0;
        }

        .empty-lecture {
            text-align: center;
        }

        @media (max-width: 768px) {
            table {
                font-size: 14px;
            }

            .editable-input {
                font-size: 14px;
            }
        }

        .total-lectures-box {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            border-radius: 5px;
            width: 300px;
            margin: 20px auto;
        }

        .pdf-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
        }

        .pdf-btn:hover {
            background-color: #0056b3;
        }

        /* Styling for the modal */
        .modal {
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #4CAF50;
            /* Default success color */
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            display: none;
            z-index: 1000;
            font-size: 16px;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
            opacity: 1;
            transition: opacity 0.5s ease-out, top 0.5s ease-out;
        }

        .modal.error {
            background-color: #f44336;
            /* Error color */
        }

        .modal.success {
            background-color: #4CAF50;
            /* Success color */
        }

        /* Add fade-out effect */
        .modal.fade-out {
            opacity: 0;
            top: 0;
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
                // For example, if the proposed_date is empty, then no lecture number is assigned.
                if (empty($plan['proposed_date'])) {
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
        // Display modal with message
        function showModal(message, type) {
            const modal = document.getElementById('messageModal');
            const messageText = document.getElementById('messageText');
            modal.style.display = 'block';
            messageText.innerText = message;
            modal.classList.add(type); // Add success or error class
            setTimeout(() => {
                modal.style.opacity = 0;
                modal.style.top = '-20px';
                setTimeout(() => {
                    modal.style.display = 'none';
                    modal.style.opacity = 1;
                    modal.style.top = '20px';
                    modal.classList.remove(type);
                }, 500);
            }, 3000);
        }

        // Handle form submission
        function saveData(event) {
            event.preventDefault(); // Prevent default form submission
            const form = document.getElementById('teachingplan');
            const formData = new FormData(form);
            const subject = new URLSearchParams(window.location.search).get('subject');

            // Use AJAX to submit the form data to the same page (without reloading)
            fetch(window.location.href + '?subject=' + encodeURIComponent(subject), {
                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    showModal('Data saved successfully!', 'success');
                    // Optionally, you can refresh the page after form submission if needed
                    setTimeout(() => window.location.reload(), 1000);
                })
                .catch(error => {
                    showModal('An error occurred while saving the data.', 'error');
                });
        }

    </script>
</body>

</html>