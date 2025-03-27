<?php
require '../database/db_connection.php'; // Database connection file

if (isset($_GET['semester'])) {
    $semester = $_GET['semester'];
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
        header('Content-Type: application/json');
        echo json_encode($subjects);
        exit;
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
            margin-bottom: 80px; /* Added space for floating button */
        }
        h2 {
            text-align: center;
            font-size: 24px;
            margin-bottom: 10px;
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
            gap: 10px;
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
        .dynamic-days {
            margin-top: 20px;
        }
        .day-container {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }
        .day-container select,
        .day-container input {
            width: 30%;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .day-container button {
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .day-container .add-day-btn {
            background-color: #007bff;
            color: white;
        }
        .day-container .remove-day-btn {
            background-color: red;
            color: white;
        }
        /* Floating Help Button Styles */
        .floating-help-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            padding: 12px 20px;
            background: linear-gradient(45deg,rgb(46, 46, 111),rgb(45, 97, 240), #0f3460,rgb(51, 141, 251));
            background-size: 300% 300%;
            color: white;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            font-weight: bold;
            box-shadow: 0 0 0 0 rgba(56, 109, 216, 0.7);
            z-index: 1000;
            animation: gradientBG 8s ease infinite, 
                       initialPulse 3s ease 1,
                       pulse 2s ease infinite 3s;
            transition: all 0.3s ease;
        }

        
        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }
        @keyframes initialPulse {
            0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(56, 109, 216, 0.7); }
            50% { transform: scale(1.2); box-shadow: 0 0 0 15px rgba(56, 109, 216, 0); }
            100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(56, 109, 216, 0); }
        }
        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(0, 174, 239, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(0, 174, 239, 0); }
            100% { box-shadow: 0 0 0 0 rgba(0, 174, 239, 0); }
        }
        @media (max-width: 768px) {
            .day-container {
                flex-direction: column;
                align-items: flex-start;
            }
            .day-container select,
            .day-container input,
            .day-container button {
                width: 100%;
            }
            .floating-help-btn {
                padding: 10px 15px;
                font-size: 14px;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="header">
        <img src="../images/logo.png" alt="Institute Logo" width="100" height="100">
    </div>
    <div class="container">
        <h2>Teacher Portal</h2>
        <form id="subDaysForm" method="post" action="teacherLogic.php">
            <label for="sem_id">Current Semester</label>
            <select name="sem_id" id="current_sem" required>
                <option value="" disabled selected>Select Semester</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
                <option value="6">6</option>
                <option value="7">7</option>
                <option value="8">8</option>
            </select>
            <label for="subject_id">Subject</label>
            <select id="subject_id" name="subject_id" required>
                <option value="">Select a subject</option>
            </select>
            <input type="hidden" name="subject" id="subject">
            <label for="division">Division</label>
            <select name="division" id="division" required>
                <option value="" selected>Select Division</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="NONE">NONE</option>
            </select>
            <div class="dynamic-days">
                <label>Days in First Week</label>
                <div id="first-week-days-container">
                    <div class="day-container">
                        <select name="first_week_details[0][day]" required>
                            <option value="">Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                        <input type="number" name="first_week_details[0][lectures]" placeholder="Lectures per Day" min="1" required>
                        <button type="button" class="add-day-btn">Add Day</button>
                    </div>
                </div>
            </div>
            <div class="dynamic-days">
                <label>Days in Regular Week</label>
                <div id="regular-week-days-container">
                    <div class="day-container">
                        <select name="regular_week_details[0][day]" required>
                            <option value="">Select Day</option>
                            <option value="Monday">Monday</option>
                            <option value="Tuesday">Tuesday</option>
                            <option value="Wednesday">Wednesday</option>
                            <option value="Thursday">Thursday</option>
                            <option value="Friday">Friday</option>
                        </select>
                        <input type="number" name="regular_week_details[0][lectures]" placeholder="Lectures per Day" min="1" required>
                        <button type="button" class="add-day-btn">Add Day</button>
                    </div>
                </div>
            </div>
            <div class="button-container">
                <button type="submit" id="generate">Generate Dates</button>
                <button type="submit" onclick="updateDates()">Update Dates</button>
            </div>
        </form>
    </div>

    <!-- Floating Help Button -->
    <button class="floating-help-btn" onclick="window.location.href='../docs/docs_for_teacher.php'">
        How to Use? <span style="font-weight: bold;"></span>
    </button>

    <script>
        // Global list of days: Monday to Friday only
        const allDays = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday"];

        // Helper: Return an array of already selected days within a container element
        function getSelectedDays(container) {
            const selects = container.querySelectorAll("select");
            let selected = [];
            selects.forEach(select => {
                if (select.value) {
                    selected.push(select.value);
                }
            });
            return selected;
        }

        // Helper: Create HTML for a dropdown (select) that shows only available days
        function createDayDropdownHTML(index, availableDays, namePrefix) {
            let optionsHTML = '<option value="">Select Day</option>';
            availableDays.forEach(day => {
                optionsHTML += `<option value="${day}">${day}</option>`;
            });
            return `<select name="${namePrefix}[${index}][day]" required>
                        ${optionsHTML}
                    </select>`;
        }

        // First Week Days Event Listener with filtering for repeated days
        document.getElementById('first-week-days-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('add-day-btn')) {
                const container = document.getElementById('first-week-days-container');
                const selectedDays = getSelectedDays(container);
                const availableDays = allDays.filter(day => !selectedDays.includes(day));
                
                if (availableDays.length === 0) {
                    alert("All days have been selected for the First Week.");
                    return;
                }
                
                const index = container.querySelectorAll('.day-container').length;
                const dropdownHTML = createDayDropdownHTML(index, availableDays, "first_week_details");

                const newDiv = document.createElement("div");
                newDiv.classList.add("day-container");
                newDiv.innerHTML = `
                    ${dropdownHTML}
                    <input type="number" name="first_week_details[${index}][lectures]" placeholder="Lectures per Day" min="1" required>
                    <button type="button" class="add-day-btn">Add Day</button>
                    <button type="button" class="remove-day-btn">Remove</button>
                `;
                container.appendChild(newDiv);
            } else if (event.target.classList.contains('remove-day-btn')) {
                event.target.parentElement.remove();
            }
        });

        // Regular Week Days Event Listener with filtering for repeated days
        document.getElementById('regular-week-days-container').addEventListener('click', function(event) {
            if (event.target.classList.contains('add-day-btn')) {
                const container = document.getElementById('regular-week-days-container');
                const selectedDays = getSelectedDays(container);
                const availableDays = allDays.filter(day => !selectedDays.includes(day));
                
                if (availableDays.length === 0) {
                    alert("All days have been selected for the Regular Week.");
                    return;
                }
                
                const index = container.querySelectorAll('.day-container').length;
                const dropdownHTML = createDayDropdownHTML(index, availableDays, "regular_week_details");

                const newDiv = document.createElement("div");
                newDiv.classList.add("day-container");
                newDiv.innerHTML = `
                    ${dropdownHTML}
                    <input type="number" name="regular_week_details[${index}][lectures]" placeholder="Lectures per Day" min="1" required>
                    <button type="button" class="add-day-btn">Add Day</button>
                    <button type="button" class="remove-day-btn">Remove</button>
                `;
                container.appendChild(newDiv);
            } else if (event.target.classList.contains('remove-day-btn')) {
                event.target.parentElement.remove();
            }
        });

        // Fetch Subjects Based on Semester
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

        function updateDates() {
            var form = document.getElementById('subDaysForm');
            form.action = 'updateLogic.php'; // Set the action to updateLogic.php
        }

        // Reset form action when Submit button is clicked (if needed)
        document.querySelector('button#generate').addEventListener('click', function () {
            var form = document.getElementById('subDaysForm');
            form.action = 'teacherLogic.php';
        });
    </script>
</body>
</html>