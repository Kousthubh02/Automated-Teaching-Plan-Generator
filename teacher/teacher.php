<?php
require '../database/db_connection.php'; // Include the database connection

// Handle AJAX request for subjects
if (isset($_GET['semester'])) {
    $semester = intval($_GET['semester']); // Get the selected semester

    // Prepare the query to fetch subjects for the selected semester
    $query = "
        SELECT s.sub_id, s.sub 
        FROM subject_table s
        JOIN sem sem ON s.sem_id = sem.sem_id
        WHERE sem.sem_id = :semester
    ";

    // Prepare and execute the SQL statement using PDO
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_INT); // Bind the semester ID to the query
        $stmt->execute();

        // Fetch the subjects
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Set the correct content type for JSON response
        header('Content-Type: application/json');
        // Send the subjects as a JSON response
        echo json_encode($subjects);
        exit; // End the script to avoid rendering extra HTML
    } catch (PDOException $e) {
        // Handle errors
        echo json_encode(['error' => 'Database query failed: ' . $e->getMessage()]);
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: #f4f4f4;
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
    </style>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const semesterDropdown = document.getElementById("current_sem");
            const subjectDropdown = document.getElementById("subject");

            semesterDropdown.addEventListener("change", function () {
                const selectedSemester = this.value;
                console.log('Selected semester:', selectedSemester);  // Debugging log

                if (selectedSemester) {
                    fetch(`teacher.php?semester=${selectedSemester}`)
                        .then(response => {
                            console.log('Response status:', response.status); // Log the status code
                            return response.text(); // Get the raw response as text
                        })
                        .then(data => {
                            console.log('Raw response data:', data); // Log the raw response data
                            try {
                                const jsonResponse = JSON.parse(data); // Parse JSON only if valid
                                if (jsonResponse.error) {
                                    console.error('Error:', jsonResponse.error);
                                    return;
                                }
                                // Clear existing options in the subject dropdown
                                subjectDropdown.innerHTML = '<option value="">Select a subject</option>';
                                
                                // Populate the subject dropdown with new options
                                jsonResponse.forEach(subject => {
                                    const option = document.createElement("option");
                                    option.value = subject.sub;
                                    option.textContent = subject.sub;
                                    subjectDropdown.appendChild(option);
                                });
                            } catch (error) {
                                console.error("Error parsing JSON:", error);
                            }
                        })
                        .catch(error => {
                            console.error("Error fetching subjects:", error);
                        });
                } else {
                    // Reset subject dropdown if no semester is selected
                    subjectDropdown.innerHTML = '<option value="">Select a subject</option>';
                }
            });
        });
    </script>
</head>
<body>
<div class="container">
    <h1><img src="./college.jpeg" alt="Institute Logo"></h1>
    <h2>Teaching Plan Generator</h2>
    <h3>Teacher's Portal</h3>
    <button class="logout">Log Out</button>
    <div class="separator"></div>
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
    <option value="" disabled selected>Select Semester</option>
    <option value="3">3</option>
    <option value="4">4</option>
    <option value="5">5</option>
    <option value="6">6</option>
    <option value="7">7</option>
    <option value="8">8</option>
</select>


        <label for="subject">Subject</label>
        <select id="subject" name="subject" required>
            <option value="">Select a subject</option>
        </select>

        <label for="days">Days</label>
        <input id="days" name="days" type="text" required placeholder="Enter the days of the week in which you are teaching">

        <button type="submit">Generate</button>
    </form>
</div>
</body>
</html>
