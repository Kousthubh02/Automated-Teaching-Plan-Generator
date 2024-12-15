<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Plan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            padding: 20px;
            color: #333;
        }
        h2, h3 { text-align: center; color: #4CAF50; }
        select, button {
            padding: 10px;
            font-size: 16px;
            margin: 10px auto;
            display: block;
        }
        label{ font-weight:bold; font-size:20px; ; display: block; text-align: center; }
        table { width: 80%; margin: 20px auto; border-collapse: collapse; }
        th, td { padding: 15px; text-align: left; border: 1px solid #ddd; background-color: #fff; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .error-message { color: red; font-size: 18px; text-align: center; }
    </style>
</head>
<body>
    <h2>Teaching Plan</h2>
    <form method="GET" action="teachingPlanLogic.php">
        <label for="subject">Select Subject:</label>
        <select id="subject" name="subject">
            <option value="">-- Select --</option>
            <option value="NLP">NLP</option>
            <option value="BC">BC</option>
            <option value="BDA">BDA</option>
        </select>
        <button type="submit">View Teaching Plans</button>
    </form>

    <h3>Teaching Plans:</h3>
    <table id="plans-table">
        <?php if (isset($_GET['message'])): ?>
            <tr><td colspan="3" class="error-message"><?= htmlspecialchars($_GET['message']) ?></td></tr>
        <?php endif; ?>
        <!-- Teaching plans will be displayed here -->
    </table>
</body>
</html>
