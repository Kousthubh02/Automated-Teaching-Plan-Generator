<?php
require '../database/db_connection.php'; // Include the database connection

// Handle AJAX request for subjects based on selected semester
if (isset($_GET['semester'])) {
    $semester = intval($_GET['semester']); // Get the selected semester

    // Prepare the query to fetch subjects for the selected semester
    $query = "
        SELECT s.sub_id, s.sub
        FROM subject_table s
        JOIN sem sem ON s.sem_id = sem.sem_id
        WHERE sem.sem_id = ?
    ";

    // Prepare and execute the SQL statement
    try {
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(1, $semester, PDO::PARAM_INT);
        $stmt->execute();

        // Fetch the subjects
        $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Return subjects as JSON response
        header('Content-Type: application/json');
        echo json_encode($subjects);
        exit; // End the script to avoid rendering extra HTML
    } catch (PDOException $e) {
        // If query fails, return an error
        header('Content-Type: application/json');
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


            .division-options {
            margin: 15px auto;
            text-align: center;
        }
        .division-btn {
            padding: 8px 20px;
            margin: 0 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background-color: #6c757d;
            color: white;
        }
        .division-btn.active {
            background-color: #4CAF50;
        }
        }
    </style>
</head>
<body>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const semesterDropdown = document.getElementById("current_sem");
        const subjectDropdown = document.getElementById("subject_id");
        const subjectNameInput = document.getElementById("subject"); // Hidden input to store subject name

        semesterDropdown.addEventListener("change", function () {
            const selectedSemester = this.value;

            if (selectedSemester) {
                fetch(`teachingplan.php?semester=${selectedSemester}`)
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

        // Set subject name in hidden input when a subject is selected
        subjectDropdown.addEventListener("change", function () {
            const selectedOption = subjectDropdown.options[subjectDropdown.selectedIndex];
            const subjectName = selectedOption.text;
            subjectNameInput.value = subjectName; // Store subject name in the hidden input
        });
    });
</script>

    <div class="container">
        <h2>Teaching Plan</h2>
        
        <form method="GET" action="teachingPlanLogic.php">
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
            <select id="subject_id" name="subject_id" required>
                <option value="">Select a subject</option>
            </select>

            <!-- Hidden field to hold subject name -->
            <input type="hidden" name="subject" id="subject">

            <label for="division">Division</label>
            <select name="division" id="division" required>
                <option value="NONE" selected>No division</option>
                <option value="A">A</option>
                <option value="B">B</option>
            </select>

            <button type="submit">View Teaching Plans</button>
        </form>
        
        <table id="plans-table">
            <?php if (isset($_GET['message'])): ?>
                <tr><td colspan="3" class="error-message"><?= htmlspecialchars($_GET['message']) ?></td></tr>
            <?php endif; ?>
        </table>

        <div class="cta">
            <a href="teachingplan.php">Go Back to Form</a>
            <a href="viewPlans.php">View All Teaching Plans</a>
        </div>
    </div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
    const form = document.querySelector("form");
    form.reset(); // Reset the form to its default state
});

</script>
</body>
</html>
