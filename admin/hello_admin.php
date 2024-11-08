<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal</title>
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
    </style>
</head>
<body>

<div class="container">
    <!-- Adding Image Header -->
    <h1><img src="./college.jpeg" alt="Institute Logo"></h1>

    <h2>Teaching Plan Generator</h2>

    <h3>Admin Portal</h3>

    <div>
        <button class="logout">Log Out</button>
    </div>

    <!-- Divider between log out button and the form -->
    <div class="separator"></div>

    <!-- The form starts here -->
    <form action="adminLogic.php" method="POST" enctype="multipart/form-data">
    
        <label for="start_date">Start date:</label>
        <input type="date" id="start_date" name="start_date" required>

        <label for="end_date">End date:</label>
        <input type="date" id="end_date" name="end_date" required>

        <label for="exclude_dates">Exclude Dates (comma-separated, dd-mm-yyyy):</label>
        <input type="text" id="exclude_dates" name="exclude_dates" required>
        <br><br>

        <button type="submit">Submit</button>
    </form>
</div>
</body>
</html>
