<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal</title>
    <!-- <title>Fr. C. Rodrigues Institute of Technology - Teacher's Portal</title> -->
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .container {
            width: 90%;
            max-width: 600px;
            background-color: white;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
        }

        h1, h2 ,h3{
            text-align: center;
            margin: 10px 0;
        }

        label {
            display: block;
            margin-top: 20px;
        }

        input[type="text"], input[type="date"], input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        button {
            margin-top: 20px;
            padding: 10px;
            width: 100%;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button.logout {
            float: right;
            width: auto;
            background-color: red;
            padding: 10px 15px;
        }

        /* Divider between sections */
        .separator {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .message {
            color: green;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        /* Media Queries for responsiveness */
        @media (max-width: 768px) {
            .container {
                width: 95%;
            }

            button {
                padding: 15px;
            }

            input[type="text"], input[type="date"], input[type="file"] {
                padding: 12px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.2em;
            }

            button {
                padding: 12px;
            }

            input[type="text"], input[type="date"], input[type="file"] {
                padding: 10px;
            }
        }

         .success-message {
            color: #155724;
            background-color: #d4edda;
            border: 1px solid #c3e6cb;
            border-radius: 5px;
            padding: 15px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            font-size: 18px;
            font-weight: bold;
        }

        .error-message {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            border-radius: 5px;
            padding: 15px;
            margin: 20px auto;
            width: 80%;
            max-width: 600px;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-link {
            display: inline-block;
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            margin-top: 10px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .btn-link:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Adding Image Header -->
    <h1><img src="./college.jpeg" alt="Institute Logo"></h1>

    <h2>Teaching Plan Generator</h2>

    <h3>Teacher's portal</h3>

    <div>
        <button class="logout">Log Out</button>
    </div>

    <!-- Divider between log out button and the form -->
    <div class="separator"></div>

    <!-- The form starts here -->
    <form action="/code/teacher/teacherLogic.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ''; ?>">
        <input type="hidden" name="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ''; ?>">
        <input type="hidden" name="exclude_dates" value="<?php echo isset($_POST['exclude_dates']) ? $_POST['exclude_dates'] : ''; ?>">


        <label for="current_year">Current Year</label><br>
        <select id="current_year" name="current_year">
            <?php
            $currentYear = date("Y");
            // $startYear = $currentYear - 10; // 50 years in the past
            $startYear = $currentYear; 
            $endYear = $currentYear + 10;   // 50 years in the future
            for ($i = $startYear; $i <= $endYear; $i++) {
                echo "<option value='$i'>$i</option>";
            }
            ?>
        </select><br><br>

        <label for="current_sem">Current Semester</label><br>
        <select name="current_sem" id="current_sem" required>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
        <option value="6">6</option>
        <option value="7">7</option>
        <option value="8">8</option>
         </select><br><br>

        <label for="subject">Subject</label><br>
        <select name="subject" id="subject">
        <option value="BC">BC</option>
        <option value="BDA">BDA</option>
        <option value="ML">ML</option>
        <option value="NLP">NLP</option>
        <option value="ILOC">ILOC</option>
        </select><br><br>

        <!-- Subject Mapping -->
        <label for="submap">Subject Mapping (subject: days, comma-separated for multiple days):</label><br>
        <textarea id="submap" name="submap" rows="6" cols="50" placeholder="Example: BC: Monday,Tuesday; BDA: Monday,Tuesday,Friday"></textarea>
        <br><br>


        <button type="submit">Generate</button>
    </form>


</div>
        
</body>
</html>