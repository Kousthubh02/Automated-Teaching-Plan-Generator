<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teaching Plan</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            width: 100%;
            max-width: 800px;
            background-color: white;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            color: #4CAF50;
        }

        label {
            font-weight: 500;
            font-size: 18px;
            margin-bottom: 10px;
            display: block;
            text-align: center;
        }

        select, button {
            padding: 12px 20px;
            font-size: 16px;
            margin: 10px auto;
            display: block;
            width: 100%;
            max-width: 300px;
            border-radius: 8px;
            border: 1px solid #ddd;
            outline: none;
            transition: all 0.3s ease;
        }

        select:focus, button:focus {
            border-color: #4CAF50;
            box-shadow: 0 0 8px rgba(76, 175, 80, 0.3);
        }

        button {
            background-color: #4CAF50;
            color: white;
            cursor: pointer;
            font-weight: bold;
        }

        button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: red;
            font-size: 18px;
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            background-color: white;
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f1f1f1;
        }

        .cta {
            text-align: center;
            margin-top: 30px;
        }

        .cta a {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            margin: 10px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .cta a:hover {
            background-color: #0056b3;
        }

        /* Responsive design */
        @media (max-width: 600px) {
            select, button {
                max-width: 100%;
                width: 90%;
            }

            table {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="container">
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
        
        <table id="plans-table">
            <?php if (isset($_GET['message'])): ?>
                <tr><td colspan="3" class="error-message"><?= htmlspecialchars($_GET['message']) ?></td></tr>
            <?php endif; ?>
        </table>

        <div class="cta">
            <a href="teacher.php">Go Back to Form</a>
            <a href="viewPlans.php">View All Teaching Plans</a>
        </div>
    </div>

</body>
</html>
