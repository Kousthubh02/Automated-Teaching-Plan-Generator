<?php
// teachingPlanLogic.php

// Include database connection
require '../database/db_connection.php';

// Initialize message and plans
$message = '';
$plans = [];

// Check if a subject is set via GET request
if (isset($_GET['subject']) && $_GET['subject'] !== '') {
    $subject = $_GET['subject'];

    // Prepare and execute query
    $sql = "SELECT teaching_date, content FROM teaching_plan WHERE subject = :subject";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['subject' => $subject]);

    // Fetch data and check if any plans exist
    $plans = $stmt->fetchAll(PDO::FETCH_ASSOC);
    if (!$plans) {
        $message = 'No teaching plans available for the selected subject.';
    }
} else {
    $message = 'Please select a subject.';
}

// Close the connection
$pdo = null;
?>

<!-- Display Results in HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Plans</title>
    <style>
        /* Add similar styles as in index.html to maintain consistency */
        body { font-family: Arial, sans-serif; background-color: #f4f7fa; padding: 20px; color: #333; }
        h2, h3 { text-align: center; color: #4CAF50; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border: 1px solid #ddd; background-color: #fff; }
        th { background-color: #4CAF50; color: white; }
        .error-message { color: red; font-size: 18px; text-align: center; }
    </style>
</head>
<body>
    <h2>Teaching Plans for <?= htmlspecialchars($subject) ?></h2>

    <?php if ($message): ?>
        <p class="error-message"><?= htmlspecialchars($message) ?></p>
    <?php else: ?>
        <table>
            <tr>
                <th>Teaching Date</th>
                <th>Content</th>
            </tr>
            <?php foreach ($plans as $plan): ?>
                <tr>
                    <td><?= htmlspecialchars($plan['teaching_date']) ?></td>
                    <td><?= htmlspecialchars($plan['content']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
