<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal</title>
    <style>
        /* Reset and Basic Styles */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f4f4f4
            color: #333;
        }

        .container {
            width: 100%;
            max-width: 600px;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        h1 img {
            max-width: 100px;
            display: block;
            margin: 0 auto 20px;
        }

        h2 {
            text-align: center;
            color: #007BFF;
            margin-bottom: 10px;
        }

        h3 {
            text-align: center;
            font-size: 1.2rem;
            color: #555;
            margin-bottom: 20px;
        }

        label {
            display: block;
            font-weight: bold;
            margin: 10px 0 5px;
        }

        input[type="text"], input[type="date"], select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 1rem;
        }

        button {
            width: 100%;
            padding: 12px;
            font-size: 1rem;
            color: #fff;
            background-color: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.logout {
            width: auto;
            padding: 8px 15px;
            background-color: #dc3545;
            float: right;
            margin-top: -10px;
        }

        button:hover {
            background-color: #0056b3;
        }

        button.logout:hover {
            background-color: #c82333;
        }

        .separator {
            margin: 20px 0;
            border-top: 1px solid #ccc;
        }

        .message {
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            font-size: 1rem;
        }

        .success-message {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error-message {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            h2 {
                font-size: 1.5rem;
            }

            button {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Adding Image Header -->
    <h1><img src="./college.jpeg" alt="Institute Logo"></h1>

    <h2>Teaching Plan Generator</h2>
    <h3>Teacher's Portal</h3>

    <button class="logout">Log Out</button>

    <div class="separator"></div>

    <!-- Form Section -->
    <form action="/code/teacher/teacherLogic.php" method="POST" enctype="multipart/form-data">
        <label for="current_year">Current Year</label>
        <select id="current_year" name="current_year">
            <?php
            $currentYear = date("Y");
            $startYear = $currentYear; 
            $endYear = $currentYear + 10;
            for ($i = $startYear; $i <= $endYear; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select>

        <label for="current_sem">Current Semester</label>
        <select name="current_sem" id="current_sem" required>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
        </select>

        <label for="subject">Subject</label>
        <input id="subject" name="subject" type="text" required placeholder="Enter subject name">

        <label for="days">Days</label>
        <input id="days" name="days" type="text" required placeholder="Enter number of days">

        <button type="submit">Generate</button>
    </form>
</div>
</body>
</html>
