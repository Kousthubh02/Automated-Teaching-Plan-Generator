<?php
// Include the database connection file
require_once '../database/db_connection.php';

// Fetch the current editable value
try {
    $sql = "SELECT editable FROM settings WHERE id = 1";
    $stmt = $pdo->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $currentValue = $row ? $row['editable'] : 0;  // Default value if no row is found
} catch (PDOException $e) {
    die("Error fetching editable status: " . $e->getMessage());
}

// Convert the editable value to a string message
$editableStatus = $currentValue == 1 ? "Editable" : "Not Editable";

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
    <title>Admin Portal</title>
    <style>
        /* Basic Styles */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
        }

        .header {
            width: 100%;
            background-color: white;
            padding: 20px;
            border-bottom: 1px solid #000;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative; /* For positioning the logout button */
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .header h1, .header h2, .header h3 {
            margin: 5px 0; /* Reduce margin for better spacing */
        }

        .main-wrapper {
            display: flex;
            gap: 20px; /* Space between the two containers */
            width: 90%;
            max-width: 1200px; /* Adjust based on your layout */
            margin-top: 20px;
        }

        .container {
            width: 100%;
            background-color: white;
            padding: 20px;
            border: 1px solid #000;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        label {
            display: block;
            margin-top: 20px;
            font-weight: bold;
        }

        input[type="text"], input[type="date"], input[type="file"], select {
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
            font-size: 1em;
        }

        button.logout {
            position: absolute; /* Position the logout button */
            top: 10px; /* Distance from the top */
            right: 50px; /* Distance from the right */
            width: auto;
            background-color: red;
            padding: 8px 12px; /* Smaller padding for smaller screens */
            font-size: 0.9em; /* Smaller font size for smaller screens */
        }

        button:hover {
            opacity: 0.9;
        }

        .separator {
            margin-top: 40px;
            border-top: 1px solid #ccc;
            padding-top: 20px;
        }

        .message {
            font-size: 1.2em;
            font-weight: bold;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            border-radius: 5px;
        }

        .editable {
            color: #4CAF50; /* Green */
            background-color: #e8f5e9;
            border: 1px solid #c3e6cb;
        }

        .not-editable {
            color: #F44336; /* Red */
            background-color: #fbe9e7;
            border: 1px solid #f5c6cb;
        }

        img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .button-group {
            display: flex;
            gap: 10px;
            margin-top: 10px;
        }

        .button-group button {
            flex: 1;
            padding: 10px;
            width: auto;
        }

        @media (max-width: 768px) {
            .main-wrapper {
                flex-direction: column; /* Stack containers vertically on smaller screens */
            }

            .container {
                width: 95%; /* Adjust width for smaller screens */
            }

            button {
                padding: 12px; /* Increase padding for better touch targets */
            }

            input[type="text"], input[type="date"], input[type="file"], select {
                padding: 12px; /* Increase padding for better touch targets */
            }

            .header {
                padding: 15px; /* Reduce padding for smaller screens */
            }

            button.logout {
                top: 5px; /* Adjust position for smaller screens */
                right: 20px; /* Adjust position for smaller screens */
                padding: 6px 10px; /* Smaller padding for smaller screens */
                font-size: 0.8em; /* Smaller font size for smaller screens */
            }

            .button-group {
                flex-direction: column;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 1.2em; /* Reduce font size for smaller screens */
            }

            button {
                padding: 12px; /* Ensure buttons are easy to tap */
            }

            input[type="text"], input[type="date"], input[type="file"], select {
                padding: 10px; /* Adjust input padding for smaller screens */
            }

            .header h1, .header h2, .header h3 {
                font-size: 1em; /* Reduce font size for smaller screens */
            }

            button.logout {
                top: 5px; /* Adjust position for smaller screens */
                right: 5px; /* Adjust position for smaller screens */
                padding: 5px 8px; /* Smaller padding for smaller screens */
                font-size: 0.7em; /* Smaller font size for smaller screens */
            }
        }


        .help-btn{
            background: linear-gradient(45deg,rgb(46, 46, 111),rgb(45, 97, 240), #0f3460,rgb(51, 141, 251));
            background-size: 300% 300%;
            font:bolder; 
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
    </style>
</head>
<body>

<!-- Header Container -->
<div class="header">
    <h1><img src="../images/logo.png" alt="Institute Logo" width="100" height="100"></h1>
    <h2>Teaching Plan Generator</h2>
    <h3>Admin Portal</h3>
    <!-- Logout Button -->
    <button class="logout">Log Out</button>
</div>

<!-- Main Wrapper -->
<div class="main-wrapper">
    <!-- Main Container -->
    <div class="container">
        <h3 style="text-align:center;">Dates Section</h3>
        <div class="separator"></div>

        <form id="adminForm" action="adminLogic.php" method="POST" enctype="multipart/form-data">
            <label for="start_date">Start Date:</label>
            <input type="date" id="start_date" name="start_date" required>

            <label for="end_date">End Date:</label>
            <input type="date" id="end_date" name="end_date" required>

            <label for="exclude_dates">Non Teaching Dates (.csv):</label>
            <input type="file" id="exclude_dates" name="exclude_dates" accept=".csv" required>

            <!-- New button group -->
            <div class="button-group">
                <button type="button" onclick="downloadCSVTemplate()" style="background-color: #28a745;">
                    Download CSV Template
                </button>
                <button type="button" class="help-btn" onclick="window.location.href='../docs/docs_for_admin.php'">
                    How to Use? <span style="font-weight: bold;">?</span>
                </button>
            </div>

            <button type="submit">Submit</button>
        </form>
    </div>

    <!-- Control Section -->
    <div class="container">
        <h3 style="text-align:center;">Control Section</h3>
        <div class="separator"></div>

        <!-- Editable Status -->
        <?php
        // Dynamic class for message
        $statusClass = $editableStatus === "Editable" ? "editable" : "not-editable";
        ?>
        <div class="message <?php echo $statusClass; ?>">
            Current Editable Status: <?php echo $editableStatus; ?>
        </div>

        <!-- Toggle Editable Button -->
        <button type="button" onclick="submitFormToToggle()">Toggle Editable</button>

        <!-- New Horizontal Selection Section -->
        <div class="horizontal-fields" style="margin-top: 20px;">
            <div style="display: flex; gap: 10px; align-items: center; margin-bottom: 15px;">
                <!-- Semester Dropdown -->
                <div style="flex: 1;">
                    <label>Semester</label>
                    <select id="control_sem" style="width: 100%; padding: 10px;">
                        <option value="">Select Semester</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                    </select>
                </div>

                <!-- Subject Dropdown -->
                <div style="flex: 1;">
                    <label>Subject</label>
                    <select id="control_subject" style="width: 100%; padding: 10px;">
                        <option value="">Select Subject</option>
                    </select>
                </div>

                <!-- Division Dropdown -->
                <div style="flex: 1;">
                    <label>Division</label>
                    <select id="control_division" style="width: 100%; padding: 10px;">
                        <option value="">Select Division</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="NONE">NONE</option>
                    </select>
                </div>

                <!-- Delete Button -->
                <div style="margin-top: 22px;">
                    <button type="button" 
                            style="background-color: red; padding: 10px 20px; width: auto;"
                            onclick="handleDelete()">
                        DELETE
                    </button>
                </div>
            </div>

            <!-- Add the new buttons here -->
            <div style="display: flex; gap: 10px; margin-top: 20px;">
                <button type="button" 
                        style="background-color: red; padding: 10px 20px; width: 100%;"
                        onclick="handleDeleteAll()">
                    Delete All
                </button>
                <button type="button" 
                        style="background-color:rgb(255, 198, 29); padding: 10px 20px; width: 100%;"
                        onclick="handleDeleteNonTeachingDates()">
                    Delete Non Teaching Dates
                </button>
            </div>
        </div>
    </div>
</div>

<script>


// Function to download CSV template
function downloadCSVTemplate() {
    // Create CSV content with semesters in a single cell
    const csvContent = "date (DD-MM-YYYY),reason,semesters\n" +
                      "26-01-2023,Republic Day,\"ALL\"\n" +
                      "15-08-2023,Independence Day,\"ALL\"\n" +
                      "02-10-2023,Gandhi Jayanti,\"ALL\"\n" +
                      "25-12-2023,Christmas,\"ALL\"\n" +
                      "01-05-2023,Labour Day,\"3,4,5\"\n" +
                      "10-09-2023,College Event,\"6,7\"";
    
    // Create download link
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const url = URL.createObjectURL(blob);
    const link = document.createElement('a');
    link.setAttribute('href', url);
    link.setAttribute('download', 'non_teaching_dates_template.csv');
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}


function handleDeleteNonTeachingDates() {
    if (confirm('Are you sure you want to delete all non-teaching dates?')) {
        fetch('adminLogic.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'action=delete_non_teaching_dates'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
            console.log(data);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

// Function to submit the form to toggle.php
function submitFormToToggle() {
    var form = document.getElementById('adminForm');
    form.action = 'toggle.php'; // Set the action to toggle.php
    form.submit(); // Submit the form
}

// Reset form action when Submit button is clicked
document.querySelector('button[type="submit"]').addEventListener('click', function () {
    var form = document.getElementById('adminForm');
    form.action = 'adminLogic.php'; // Reset the action to adminLogic.php
});

// Fetch Subjects for Control Section
document.getElementById('control_sem').addEventListener('change', function() {
    const selectedSemester = this.value;
    const subjectDropdown = document.getElementById('control_subject');
    
    if (selectedSemester) {
        fetch(`?semester=${selectedSemester}`)
            .then(response => response.json())
            .then(data => {
                subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
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
        subjectDropdown.innerHTML = '<option value="">Select Subject</option>';
    }
});

function handleDelete() {
    const semester = document.getElementById('control_sem').value;
    const subject = document.getElementById('control_subject').value;
    const division = document.getElementById('control_division').value;
    
    if (!semester || !subject || !division) {
        alert('Please select all fields before deleting');
        return;
    }
    
    if (confirm('Are you sure you want to delete this teaching plan and reference table entry?')) {
        fetch('adminLogic.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `action=delete_teaching_plan&semester=${semester}&subject=${subject}&division=${division}`
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function handleDeleteAll() {
    if (confirm('Are you sure you want to delete ALL teaching plan and reference table entries ?')) {
        fetch('adminLogic.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'action=delete_all_teaching_plan'
        })
        .then(response => response.json())
        .then(data => {
            alert(data.message);
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>

</body>
</html>