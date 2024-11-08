<?php
// Include the database connection file
require_once '../database/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $start_date = $_POST['start_date'] ?? null;
    $end_date = $_POST['end_date'] ?? null;
    $exclude_dates = $_POST['exclude_dates'] ?? '';

    // Validate start_date and end_date
    if (!$start_date || !$end_date) {
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 70%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
        echo '<strong>Error:</strong> Please provide both a start date and an end date.';
        echo '</div>';
        exit;
    }

    // Convert excluded dates to an array if provided
    $exclude_dates_array = [];
    if (!empty($exclude_dates)) {
        $exclude_dates_array = array_map('trim', explode(',', $exclude_dates));
    }

    $json_excluded_dates = json_encode($exclude_dates_array);

    $pdo->beginTransaction();

    try {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO teaching_dates (start_date, end_date, exclude_dates) VALUES (?, ?, ?)");
        $stmt->execute([$start_date, $end_date, $json_excluded_dates]);

        $pdo->commit();

        // Display success message with fixed width and height
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px; text-align: center; width: 70%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; min-height: 100px;">';
        echo '<strong>Success!</strong> Dates have been saved successfully! ';
        echo '</div>';

        // Redirection would be handled here
        exit;
    } catch (Exception $e) {
        $pdo->rollBack();

        // Display error message
        echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 80%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
        echo '<strong>Error:</strong> An error occurred: ' . $e->getMessage();
        echo '</div>';
        exit;
    }
} else {
    echo '<div style="font-family: Arial, sans-serif; padding: 20px; margin: 20px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px; text-align: center; width: 80%; max-width: 600px; margin: auto; display: flex; justify-content: center; align-items: center; height: 100vh;">';
    echo '<strong>Error:</strong> Invalid request method.';
    echo '</div>';
}
?>
