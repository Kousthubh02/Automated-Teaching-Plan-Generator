<?php
// Include the database connection file
require '../database/db_connection.php';

// Get subject and subject_id from GET parameters
$subject = isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : 'Unknown';
$subject_id = filter_input(INPUT_GET, 'subject_id', FILTER_VALIDATE_INT);

$division = isset($_GET['division']) ? strtoupper($_GET['division']) : 'NONE';
$valid_divisions = ['A', 'B', 'NONE'];
if (!in_array($division, $valid_divisions)) {
  $division = 'NONE';
}

if (!$subject_id) {
  die("Invalid subject ID");
}

// Initialize variables
$lectureNumber = 1;
$message = '';
$plans = [];
$editable = 0; // Default editable status
$excludeDatesArray = [];  // Will hold dates (in Y-m-d format) that are marked as excluded
$missing_content = ''; // Initialize missing content variable

// Check if a subject is set via GET request
if ($subject !== 'Unknown') {
  try {
    // Get teaching plans for the selected subject and division
    $sql = "SELECT pk, proposed_date, content, actual_date, content_not_covered, 
                     reference, methodology, co_mapping, verified_by_hod, isNTD, sem_id
              FROM teaching_plan 
              WHERE subject = :subject 
              AND (division = :division OR division = 'NONE')";

    $stmt = $pdo->prepare($sql);
    $stmt->execute([
      'subject' => $subject,
      'division' => $division
    ]);

    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$plans) {
      $message = 'No teaching plans available for the selected subject and division.';
    }
  } catch (PDOException $e) {
    $message = 'Error fetching data: ' . $e->getMessage();
  }

  // Get editable status
  try {
    $sql = "SELECT editable FROM settings WHERE id = 1";
    $stmt = $pdo->query($sql);
    $editable = $stmt->fetchColumn();
  } catch (PDOException $e) {
    $message = 'Error fetching editable status: ' . $e->getMessage();
  }

  // Fetch exclude dates
  try {
    $sql = "SELECT exclude_dates FROM teaching_dates WHERE subject = :subject LIMIT 1";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['subject' => $subject]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row && !empty($row['exclude_dates'])) {
      $excludeDates = json_decode($row['exclude_dates'], true);
      if (is_array($excludeDates)) {
        foreach ($excludeDates as $date => $reason) {
          $dateObj = DateTime::createFromFormat('d-m-Y', $date);
          if ($dateObj) {
            $excludeDatesArray[] = $dateObj->format('Y-m-d');
          }
        }
      }
    }
  } catch (PDOException $e) {
    // Error handling remains same
  }

  // Fetch missing content if we have plans
  if (!empty($plans)) {
    try {
      $sem_id = $plans[0]['sem_id'];
      $missing_sql = "SELECT missingcontent FROM missing_content_table 
                     WHERE subject = :subject 
                     AND division = :division 
                     AND sem_id = :sem_id";
      $missing_stmt = $pdo->prepare($missing_sql);
      $missing_stmt->execute([
        ':subject' => $subject,
        ':division' => $division,
        ':sem_id' => $sem_id
      ]);
      $missing_row = $missing_stmt->fetch(PDO::FETCH_ASSOC);
      $missing_content = $missing_row['missingcontent'] ?? '';
    } catch (PDOException $e) {
      // Silence error, just leave missing_content empty
    }
  }
} else {
  $message = 'Please select a subject.';
}

// Handle form submission (Save data) via AJAX or normal POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // --- 1. Process Teaching Plan Update ---
  if (isset($_POST['content'])) {
    try {
      foreach ($_POST['content'] as $pk => $content) {
        // Convert empty values to null
        $content = trim($content);
        $content = ($content === '') ? null : $content;

        $content_not_covered = trim($_POST['content_not_covered'][$pk] ?? '');
        $content_not_covered = ($content_not_covered === '') ? null : $content_not_covered;

        // For plan_references, only set a value if at least one checkbox was checked
        $plan_reference = isset($_POST['plan_references'][$pk])
                          ? implode(', ', array_filter($_POST['plan_references'][$pk]))
                          : null;
        // For methodology, only set if a value exists
        $methodology = isset($_POST['methodology'][$pk])
                       ? implode(', ', array_filter($_POST['methodology'][$pk]))
                       : null;

        $co_mapping = trim($_POST['co_mapping'][$pk] ?? '');
        $co_mapping = ($co_mapping === '') ? null : $co_mapping;

        // Update each teaching plan record
        $sql = "UPDATE teaching_plan SET 
                        content = :content,
                        content_not_covered = :content_not_covered,
                        reference = :reference,
                        methodology = :methodology,
                        co_mapping = :co_mapping 
                        WHERE pk = :pk";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
          'content'             => $content,
          'content_not_covered' => $content_not_covered,
          'reference'           => $plan_reference,
          'methodology'         => $methodology,
          'co_mapping'          => $co_mapping,
          'pk'                  => $pk
        ]);
      }
      $message = 'Teaching plan data has been successfully saved.';
    } catch (PDOException $e) {
      $message = 'Error saving teaching plan data: ' . $e->getMessage();
    }
  }

  // --- 2. Process Subject References Update ---
  if (isset($_POST['subject_references'])) {
    if (!isset($_POST['sub_id']) || !filter_var($_POST['sub_id'], FILTER_VALIDATE_INT)) {
        die("Invalid subject ID");
    }
    $sub_id_post = filter_input(INPUT_POST, 'sub_id', FILTER_VALIDATE_INT);
    try {
        // Loop over each reference submitted (this includes both references and textbooks)
        foreach ($_POST['subject_references'] as $ref_code => $ref_content) {
            $ref_content = trim($ref_content);
            $ref_content = ($ref_content === '') ? null : $ref_content;

            // Check if a row already exists for this sub_id, division, and ref_code
            $checkSql = "SELECT COUNT(*) FROM reference_table 
                         WHERE sub_id = :sub_id 
                         AND division = :division 
                         AND ref_code = :ref_code";
            $checkStmt = $pdo->prepare($checkSql);
            $checkStmt->execute([
                ':sub_id'   => $sub_id_post,
                ':division' => $division,
                ':ref_code' => $ref_code
            ]);
            $rowCount = $checkStmt->fetchColumn();

            // If no row exists, insert the data
            if ($rowCount == 0) {
                $insertSql = "INSERT INTO reference_table (sub_id, division, ref_code, ref_content)
                               VALUES (:sub_id, :division, :ref_code, :ref_content)";
                $insertStmt = $pdo->prepare($insertSql);
                $insertStmt->execute([
                    ':sub_id'     => $sub_id_post,
                    ':division'   => $division,
                    ':ref_code'   => $ref_code,
                    ':ref_content'=> $ref_content
                ]);
            } else {
                // If a row exists, update the data
                $updateSql = "UPDATE reference_table 
                               SET ref_content = :ref_content 
                               WHERE sub_id = :sub_id 
                               AND division = :division 
                               AND ref_code = :ref_code";
                $updateStmt = $pdo->prepare($updateSql);
                $updateStmt->execute([
                    ':sub_id'     => $sub_id_post,
                    ':division'   => $division,
                    ':ref_code'   => $ref_code,
                    ':ref_content'=> $ref_content
                ]);
            }
        }
        $message .= ' References updated successfully.';
    } catch (PDOException $e) {
        $message .= ' Error updating references: ' . $e->getMessage();
    }
  }

  // --- 3. Process Missing Content Update ---
  if (isset($_POST['missing_content'])) {
    try {
        // Get sem_id from existing teaching plans
        $sem_id = null;
        if (!empty($plans)) {
            $sem_id = $plans[0]['sem_id'];
        }

        if ($sem_id) {
            $missing_content = trim($_POST['missing_content']) ?? '';
            
            // First try to update
            $update_stmt = $pdo->prepare("
                UPDATE missing_content_table 
                SET missingcontent = :missingcontent
                WHERE sem_id = :sem_id 
                AND division = :division 
                AND subject = :subject
            ");
            
            $update_stmt->execute([
                ':missingcontent' => $missing_content,
                ':sem_id' => $sem_id,
                ':division' => $division,
                ':subject' => $subject
            ]);
            
            // If no rows were updated, insert new
            if ($update_stmt->rowCount() === 0) {
                $insert_stmt = $pdo->prepare("
                    INSERT INTO missing_content_table 
                    (dept_id, sem_id, division, subject, missingcontent) 
                    VALUES 
                    (:dept_id, :sem_id, :division, :subject, :missingcontent)
                ");
                
                // Get dept_id from first existing record if available
                $dept_id = !empty($existing_records) ? $existing_records[0]['dept_id'] : null;
                
                $insert_stmt->execute([
                    ':dept_id' => $dept_id,
                    ':sem_id' => $sem_id,
                    ':division' => $division,
                    ':subject' => $subject,
                    ':missingcontent' => $missing_content
                ]);
            }
            $message .= ' Missing content updated successfully.';
        }
    } catch (PDOException $e) {
        $message .= ' Error updating missing content: ' . $e->getMessage();
    }
  }

  // Return response based on the request type (AJAX or normal)
  if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    header('Content-Type: application/json');
    echo json_encode(['message' => $message]);
    exit();
  } else {
    header("Location: " . $_SERVER['PHP_SELF'] . "?subject=" . urlencode($subject) . "&subject_id=" . $subject_id . "&division=" . urlencode($division));
    exit();
  }
}

// Fetch existing subject references so that the form can be pre-filled
try {
  $sql = "SELECT ref_code, ref_content FROM reference_table WHERE sub_id = :sub_id AND division = :division";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':sub_id' => $subject_id,
    ':division' => $division
  ]);
  $references = $stmt->fetchAll(PDO::FETCH_KEY_PAIR) ?? [];
} catch (PDOException $e) {
  $references = [];
}

// Count total lectures (based solely on the plans array)
$totalLectures = count($plans);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Teaching Plans</title>
  <style>
    /* Reduced Padding and Margin for a more compact layout */
    body {
      font-family: Arial, sans-serif;
      background-color: #f4f7fa;
      margin: 0;
      padding: 10px;
      /* Reduced padding */
      color: #333;
    }

    h2 {
      text-align: center;
      color: #007bff;
      margin-bottom: 10px;
      /* Reduced margin */
    }

    table {
      width: 100%;
      margin: 0 auto;
      border-collapse: collapse;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
      padding: 4px 6px;
      /* Reduced padding in table cells */
      text-align: left;
      border: 1px solid #ddd;
      background-color: #fff;
    }

    th {
      background-color: #007bff;
      color: white;
    }

    input[type="checkbox"] {
      transform: scale(1.2);
    }

    .editable-input {
      width: 100%;
      padding: 6px;
      /* Reduced padding */
      font-size: 14px;
      box-sizing: border-box;
      resize: none;
    }

    input[type="date"] {
      position: relative;
      z-index: 1;
    }

    .submit-btn {
      display: block;
      margin: 10px auto;
      /* Reduced margin */
      padding: 8px 16px;
      /* Slightly reduced padding */
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      /* Slightly reduced font size */
      cursor: pointer;
      flex: 1;
    }

    .submit-btn:hover {
      background-color: #45a049;
    }

    .button-container {
      display: flex;
      justify-content: center;
      gap: 50px; /* Adjust the space between buttons */
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
        font-size: 12px;
      }
    }

    .total-lectures-box {
      background-color: #007bff;
      color: white;
      padding: 10px;
      /* Reduced padding */
      text-align: center;
      font-size: 16px;
      /* Reduced font size */
      margin-top: 10px;
      border-radius: 5px;
      width: 300px;
      margin: 10px auto;
    }

    /* References Table Styling */
    .references-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 14px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .references-table th {
      background-color: #007BFF;
      color: white;
      padding: 6px;
      /* Reduced padding */
      text-align: center;
      font-size: 14px;
    }

    .references-table td {
      padding: 6px;
      /* Reduced padding */
      border: 1px solid #ddd;
      background-color: #fff;
      text-align: center;
    }

    .references-label {
      font-weight: bold;
      display: block;
      margin-bottom: 3px;
      /* Reduced margin */
      color: #333;
    }

    .references-textarea {
      width: 90%;
      height: 50px;
      padding: 4px;
      /* Reduced padding */
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background: #fff;
      resize: none;
      transition: 0.3s;
    }

    .references-textarea:focus {
      border-color: #007BFF;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      outline: none;
    }

    .missing-content-textarea {
      width: calc(100% - 10px);
      height: 50px;
      padding: 4px;
      font-size: 14px;
      border: 1px solid #ccc;
      border-radius: 5px;
      background: #fff;
      resize: none;
      transition: 0.3s;
      margin: 10px auto;
    }

    .missing-content-textarea:focus {
      border-color: #007BFF;
      box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
      outline: none;
    }

    .missing-content-warning {
      color: #ff0000;
      background-color: #ffe6e6;
      padding: 8px;
      border: 1px solid #ff9999;
      border-radius: 5px;
      margin: 10px auto;
      text-align: center;
      display: none; /* Hidden by default */
      width: 80%;
    }

    @media (max-width: 768px) {
      .references-table {
        font-size: 12px;
      }

      .references-textarea {
        font-size: 12px;
      }

      .missing-content-textarea {
        font-size: 12px;
        padding: 3px;
      }
    }

    /* Modal Popup Styling */
    .modal {
      position: fixed;
      top: 10px;
      /* Adjusted for reduced spacing */
      left: 50%;
      transform: translateX(-50%);
      background-color: #007bff;
      color: white;
      padding: 8px 16px;
      /* Reduced padding */
      border-radius: 5px;
      display: none;
      z-index: 1000;
      font-size: 14px;
      box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.2);
      opacity: 1;
      transition: opacity 0.5s ease-out, top 0.5s ease-out;
    }

    .modal.error {
      background-color: #f44336;
    }

    .modal.success {
      background-color: #4CAF50;
    }

    .modal.error {
      background-color: #f44336;
    }

    .modal.success {
      background-color: #4CAF50;
    }

    .modal.fade-out {
      opacity: 0;
      top: 0;
    }
  </style>
</head>

<body>
  <h2>Teaching Plans for <?= htmlspecialchars($subject ?: 'Unknown') ?></h2>

  <!-- Popup Modal for messages -->
  <div id="messageModal" class="modal">
    <div class="modal-content">
      <span id="messageText"></span>
    </div>
  </div>

  <!-- Teaching Plan and References Form -->
  <form id="teachingplan" method="post"
    action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>?subject=<?= urlencode($subject) ?>&subject_id=<?= $subject_id ?>&division=<?= urlencode($division) ?>" >
  
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
        <th>Remarks with Signature</th>
        <th>Verified by HOD</th>
      </tr>

      <?php foreach ($plans as $plan): ?>
      <?php
      // If the proposed_date is empty, in the exclude dates list, or flagged as NTD, render a grey row without a lecture number.
      if (empty($plan['proposed_date']) || in_array($plan['proposed_date'], $excludeDatesArray) || $plan['isNTD'] == 1) {
        $lectureNumberCell = '';
        $rowClass = 'grey-row';
        $inputClass = 'grey-input';
      } else {
        $lectureNumberCell = $lectureNumber++;
        $rowClass = '';
        $inputClass = '';
      }
      // Determine if fields should be editable based on both $editable and isNTD
      $isEditable = ($editable == 1 && $plan['isNTD'] != 1);
      ?>
      <tr class="<?= $rowClass ?>">
        <td class="empty-lecture"><?= $lectureNumberCell ?></td>
        <td>
          <input type="hidden" name="proposed_date[<?= $plan['pk'] ?>]"
            value="<?= htmlspecialchars($plan['proposed_date']) ?>">
          <?php
          // Format date from Y-m-d to d-m-Y (if possible)
          $formattedDate = DateTime::createFromFormat('Y-m-d', $plan['proposed_date']);
          echo htmlspecialchars($formattedDate ? $formattedDate->format('d-m-Y') : $plan['proposed_date']);
          ?>
        </td>
        <td>
          <textarea class="editable-input <?= $inputClass ?>" name="content[<?= $plan['pk'] ?>]"
            placeholder="Enter content" <?= $isEditable ? '' : 'readonly' ?>
            oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
            onfocus="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"><?= htmlspecialchars($plan['content'] ?: '') ?></textarea>
        </td>
        <td></td>
        <td>
          <textarea class="editable-input <?= $inputClass ?>" name="content_not_covered[<?= $plan['pk'] ?>]"
            placeholder="Enter content not covered" 
            oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
            onfocus="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"><?= htmlspecialchars($plan['content_not_covered'] ?: '') ?></textarea>
        </td>
        <td>
          <table>
            <tr>
              <th></th>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <th><?= $i ?></th>
              <?php endfor; ?>
            </tr>
            <tr>
              <td>Textbook</td>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <td>
                  <input type="checkbox" name="plan_references[<?= $plan['pk'] ?>][]" value="T<?= $i ?>"
                    <?= (isset($plan['reference']) && in_array("t$i", array_map('trim', explode(',', strtolower($plan['reference']))))) ? 'checked' : '' ?> 
                    <?= $isEditable ? '' : 'disabled' ?>>
                  T<?= $i ?>
                </td>
              <?php endfor; ?>
            </tr>
            <tr>
              <td>References</td>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <td>
                  <input type="checkbox" name="plan_references[<?= $plan['pk'] ?>][]" value="R<?= $i ?>"
                    <?= (isset($plan['reference']) && in_array("r$i", array_map('trim', explode(',', strtolower($plan['reference']))))) ? 'checked' : '' ?> 
                    <?= $isEditable ? '' : 'disabled' ?>>
                  R<?= $i ?>
                </td>
              <?php endfor; ?>
            </tr>
            <tr>
              <td>Others</td>
              <?php for ($i = 1; $i <= 5; $i++): ?>
                <td>
                  <input type="checkbox" name="plan_references[<?= $plan['pk'] ?>][]" value="O<?= $i ?>"
                    <?= (isset($plan['reference']) && in_array("o$i", array_map('trim', explode(',', strtolower($plan['reference']))))) ? 'checked' : '' ?> 
                    <?= $isEditable ? '' : 'disabled' ?>>
                  O<?= $i ?>
                </td>
              <?php endfor; ?>
            </tr>
          </table>
        </td>
        <td>
          <?php
          $selectedMethods = explode(', ', $plan['methodology'] ?? '');
          ?>
          <label>
            <input type="checkbox" name="methodology[<?= $plan['pk'] ?>][]" value="Board" 
              <?= in_array('Board', $selectedMethods) ? 'checked' : '' ?> 
              <?= $isEditable ? '' : 'disabled' ?>> Board
          </label><br>
          <label>
            <input type="checkbox" name="methodology[<?= $plan['pk'] ?>][]" value="PPT" 
              <?= in_array('PPT', $selectedMethods) ? 'checked' : '' ?> 
              <?= $isEditable ? '' : 'disabled' ?>> PPT
          </label><br>
          <label>
            <input type="checkbox" name="methodology[<?= $plan['pk'] ?>][]" value="Other" 
              <?= in_array('Other', $selectedMethods) ? 'checked' : '' ?> 
              <?= $isEditable ? '' : 'disabled' ?>> Other
          </label>
        </td>
        <td>
          <select class="editable-input <?= $inputClass ?>" name="co_mapping[<?= $plan['pk'] ?>]" 
            <?= $isEditable ? '' : 'disabled' ?>>
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

    <h2>References</h2>
    <!-- Hidden input to pass the subject ID -->
    <input type="hidden" name="sub_id" value="<?= $subject_id ?>">
    <table class="references-table">
      <tr>
        <th>Reference Books</th>
        <th>Textbooks</th>
        <th>Others</th>
      </tr>
      <tr>
        <td>
          <?php
          $referenceCodes = ['R1', 'R2', 'R3', 'R4', 'R5'];
          foreach ($referenceCodes as $code): ?>
            <label class="references-label"><?= $code ?></label>
            <textarea oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
                      onfocus="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';" class="references-textarea" name="subject_references[<?= $code ?>]"
              placeholder="Enter reference book used"><?= isset($references[$code]) ? htmlspecialchars($references[$code]) : '' ?></textarea><br>
          <?php endforeach; ?>
        </td>
        <td>
          <?php
          $textbookCodes = ['T1', 'T2', 'T3', 'T4', 'T5'];
          foreach ($textbookCodes as $code): ?>
            <label class="references-label"><?= $code ?></label>
            <textarea oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
                      onfocus="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';" class="references-textarea" name="subject_references[<?= $code ?>]"
              placeholder="Enter textbook used"><?= isset($references[$code]) ? htmlspecialchars($references[$code]) : '' ?></textarea><br>
          <?php endforeach; ?>
        </td>
        <td>
          <?php
          $webReferenceCodes = ['O1', 'O2', 'O3', 'O4', 'O5'];
          foreach ($webReferenceCodes as $code): ?>
            <label class="references-label"><?= $code ?></label>
            <textarea oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
                      onfocus="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';" class="references-textarea" name="subject_references[<?= $code ?>]"
              placeholder="Enter any other reference used"><?= isset($references[$code]) ? htmlspecialchars($references[$code]) : '' ?></textarea><br>
          <?php endforeach; ?>
        </td>
      </tr>
    </table>

    <h2>Missing Content</h2>
    <textarea oninput="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';"
              onfocus="this.style.height = 'auto'; this.style.height = (this.scrollHeight) + 'px';" 
              class="missing-content-textarea" 
              name="missing_content"
              placeholder="All topics from last year covered!"><?= htmlspecialchars($missing_content) ?></textarea>

    <div id="missingContentWarning" class="missing-content-warning">
    ⚠️ Warning: Missing content has been specified! Please ensure this is accurate before saving.
    </div>

    <div class="button-container">
      <button type="submit" id="saveBtn" class="submit-btn" <?= $editable == 0 ? 'disabled' : '' ?>>Save Changes</button>
      <button type="button" class="submit-btn" onclick="view_PDF()">View PDF</button>
    </div>
  </form>

  <!-- Display total lectures -->
  <div class="total-lectures-box">
    Total Lectures: <?= $lectureNumber - 1 ?>
  </div>

  <script>
  // Attach a submit event listener to handle AJAX saving
document.getElementById('teachingplan').addEventListener('submit', saveData);

function saveData(event) {
  event.preventDefault(); // Prevent the form's default submission
  const form = event.target;
  const formData = new FormData(form);
  const saveBtn = document.getElementById('saveBtn');
  saveBtn.disabled = true; // Disable the button while saving

  fetch(form.action, {
    method: 'POST',
    headers: {
      'X-Requested-With': 'XMLHttpRequest'
    },
    body: formData
  })
    .then(response => response.json())
    .then(data => {
      // Store the save message in localStorage
      localStorage.setItem('saveMessage', data.message);
      // Reload the page immediately
      window.location.reload();
    })
    .catch(error => {
      console.error('Error:', error);
      showModal('Error saving data.', 'error');
      saveBtn.disabled = false; // Re-enable button on error
    });
}

// Function to display the modal popup
function showModal(message, type) {
  const modal = document.getElementById('messageModal');
  const messageText = document.getElementById('messageText');
  modal.style.display = 'block';
  messageText.innerText = message;
  modal.classList.add(type);
  setTimeout(() => {
    modal.style.opacity = 0;
    modal.style.top = '-20px';
    setTimeout(() => {
      modal.style.display = 'none';
      modal.style.opacity = 1;
      modal.style.top = '10px';
      modal.classList.remove(type);
    }, 500);
  }, 3000);
}

// On page load, display the popup
document.addEventListener('DOMContentLoaded', () => {
  // Check if there's a save message from a previous save
  const saveMessage = localStorage.getItem('saveMessage');
  if (saveMessage) {
    showModal(saveMessage, 'success');
    localStorage.removeItem('saveMessage'); // Clear the message after displaying
  } else {
    // Default message for manual reloads or initial loads
    showModal('Page reloaded.', 'success');
  }
});

// Check missing content on load and whenever it changes
const missingContentTextarea = document.querySelector('.missing-content-textarea');
const missingContentWarning = document.getElementById('missingContentWarning');

function checkMissingContent() {
  if (missingContentTextarea.value.trim() !== '') {
    missingContentWarning.style.display = 'block';
  } else {
    missingContentWarning.style.display = 'none';
  }
}

// Initial check on page load
document.addEventListener('DOMContentLoaded', () => {
  checkMissingContent();
  
  // Also check whenever the content changes
  missingContentTextarea.addEventListener('input', checkMissingContent);
});

// Function to view PDF (opens in a new tab)
function view_PDF() {
  var form = document.getElementById('teachingplan');
  var originalAction = form.action;
  var originalTarget = form.target;

  // Create hidden inputs for subject_references, excludeDatesArray, and isNTD
  var subjectReferencesInput = document.createElement('input');
  subjectReferencesInput.type = 'hidden';
  subjectReferencesInput.name = 'subject_references';
  subjectReferencesInput.value = JSON.stringify(<?= json_encode($references) ?>);

  var excludeDatesArrayInput = document.createElement('input');
  excludeDatesArrayInput.type = 'hidden';
  excludeDatesArrayInput.name = 'excludeDatesArray';
  excludeDatesArrayInput.value = JSON.stringify(<?= json_encode($excludeDatesArray) ?>);

  var isNTDInput = document.createElement('input');
  isNTDInput.type = 'hidden';
  isNTDInput.name = 'isNTD';
  isNTDInput.value = JSON.stringify(<?= json_encode(array_column($plans, 'isNTD', 'pk')) ?>);

  // Append the hidden inputs to the form
  form.appendChild(subjectReferencesInput);
  form.appendChild(excludeDatesArrayInput);
  form.appendChild(isNTDInput);

  // Set form attributes for PDF generation
  form.target = '_blank'; // Open PDF in a new tab
  form.action = 'view_PDF_borders.php';
  form.method = 'POST';
  form.submit();

  // Restore original form attributes
  form.action = originalAction;
  form.target = originalTarget;

  // Remove the hidden inputs after submission
  form.removeChild(subjectReferencesInput);
  form.removeChild(excludeDatesArrayInput);
  form.removeChild(isNTDInput);
}
  </script>
</body>
</html>