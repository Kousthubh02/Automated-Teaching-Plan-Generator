<?php
require '../database/db_connection.php'; // Database connection file

// This part handles the subject fetch based on the semester via GET
if (isset($_GET['semester'])) {
    $semester = $_GET['semester'];

    // Prepare SQL to get subjects for the selected semester
    $query = "
        SELECT s.sub_id, s.sub
        FROM subject_table s
        JOIN sem sem ON s.sem_id = sem.sem_id
        WHERE sem.sem_id = :semester
    ";

    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':semester', $semester, PDO::PARAM_INT);
        $stmt->execute();

        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Send response as JSON
        header('Content-Type: application/json');
        echo json_encode($subjects);
        exit; // End script
    } catch (PDOException $e) {
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
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
        }
        .header img {
            max-width: 200px;
            height: auto;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 30px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin: 8px;
            margin-bottom: 4px;
            font-weight: bold;
        }
        select, input[type="number"], input[type="text"] {
            width: 100%;
            padding: 10px;
            margin: 5px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .button-container {
            margin-top: 20px;
            display: flex;
            justify-content: center;
        }
        button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .button-container button {
            margin: 0 10px;
        }
        .dynamic-days {
            margin-top: 20px;
        }
        .day-container {
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
        }
        .day-container input {
            width: 30%;
        }
        .day-container select {
            width: 30%;
        }
        .day-container button {
            width: 20%;
            margin-top: 0;
        }
    </style>
</head>
<body>

    <!-- Institute Logo Header -->
    <div class="header">
        <img src="path_to_logo.png" alt="Institute Logo">
    </div>

    <div class="container">
        <h2>Teacher Portal</h2>
        <form method="post" action="teacherLogic.php">

        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const semesterDropdown = document.getElementById("current_sem");
                const subjectDropdown = document.getElementById("subject_id");
                const subjectNameInput = document.getElementById("subject");

                semesterDropdown.addEventListener("change", function () {
                    const selectedSemester = this.value;

                    if (selectedSemester) {
                        fetch(`?semester=${selectedSemester}`)
                            .then(response => response.json())
                            .then(data => {
                                if (data.error) {
                                    console.error('Error:', data.error);
                                    return;
                                }
                                subjectDropdown.innerHTML = '<option value="">Select a subject</option>';
                                data.forEach(subject => {
                                    const option = document.createElement("option");
                                    option.value = subject.sub_id;
                                    option.textContent = subject.sub;
                                    subjectDropdown.appendChild(option);
                                });
                            })
                            .catch(error => {
                                console.error("Error fetching subjects:", error);
                            });
                    } else {
                        subjectDropdown.innerHTML = '<option value="">Select a subject</option>';
                    }
                });

                subjectDropdown.addEventListener("change", function () {
                    const selectedOption = subjectDropdown.options[subjectDropdown.selectedIndex];
                    const subjectName = selectedOption.text;
                    subjectNameInput.value = subjectName;
                });
            });
        </script>

        <!-- Semester Dropdown -->
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

        <!-- Subject Dropdown (Dynamic) -->
        <label for="subject">Subject</label>
        <select id="subject_id" name="subject" required>
            <option value="">Select a subject</option>
        </select>

        <!-- Hidden field to store the subject name -->
        <input type="hidden" name="subject" id="subject">

        <!-- First Week Details -->
        <div class="dynamic-days">
            <label>Days in First Week</label>
            <div id="first-week-days-container">
                <div class="day-container">
                    <select name="first_week_details[0][day]" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                    <input type="number" name="first_week_details[0][lectures]" placeholder="Lectures per Day" min="1" required>
                    <button type="button" class="add-first-week-day-btn">Add Day</button>
                </div>
            </div>
        </div>

        <!-- Regular Week Details -->
        <div class="dynamic-days">
            <label>Days in Regular Week</label>
            <div id="regular-week-days-container">
                <div class="day-container">
                    <select name="regular_week_details[0][day]" required>
                        <option value="Monday">Monday</option>
                        <option value="Tuesday">Tuesday</option>
                        <option value="Wednesday">Wednesday</option>
                        <option value="Thursday">Thursday</option>
                        <option value="Friday">Friday</option>
                        <option value="Saturday">Saturday</option>
                        <option value="Sunday">Sunday</option>
                    </select>
                    <input type="number" name="regular_week_details[0][lectures]" placeholder="Lectures per Day" min="1" required>
                    <button type="button" class="add-regular-week-day-btn">Add Day</button>
                </div>
            </div>
        </div>

        <!-- Buttons -->
        <div class="button-container">
            <button type="submit">Generate</button>
        </div>
        </form>
    </div>

    <script>
        // Add day functionality for first week
        document.querySelector('.add-first-week-day-btn').addEventListener('click', function() {
            const newDayContainer = document.createElement('div');
            newDayContainer.classList.add('day-container');
            newDayContainer.innerHTML = `
                <select name="first_week_details[][day]" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
                <input type="number" name="first_week_details[][lectures]" placeholder="Lectures per Day" min="1" required>
                <button type="button" class="remove-day-btn">Remove</button>
            `;
            document.getElementById('first-week-days-container').appendChild(newDayContainer);

            // Add remove functionality
            newDayContainer.querySelector('.remove-day-btn').addEventListener('click', function() {
                newDayContainer.remove();
            });
        });

        // Add day functionality for regular week
        document.querySelector('.add-regular-week-day-btn').addEventListener('click', function() {
            const newDayContainer = document.createElement('div');
            newDayContainer.classList.add('day-container');
            newDayContainer.innerHTML = `
                <select name="regular_week_details[][day]" required>
                    <option value="Monday">Monday</option>
                    <option value="Tuesday">Tuesday</option>
                    <option value="Wednesday">Wednesday</option>
                    <option value="Thursday">Thursday</option>
                    <option value="Friday">Friday</option>
                    <option value="Saturday">Saturday</option>
                    <option value="Sunday">Sunday</option>
                </select>
                <input type="number" name="regular_week_details[][lectures]" placeholder="Lectures per Day" min="1" required>
                <button type="button" class="remove-day-btn">Remove</button>
            `;
            document.getElementById('regular-week-days-container').appendChild(newDayContainer);

            // Add remove functionality
            newDayContainer.querySelector('.remove-day-btn').addEventListener('click', function() {
                newDayContainer.remove();
            });
        });
    </script>
</body>
</html>
