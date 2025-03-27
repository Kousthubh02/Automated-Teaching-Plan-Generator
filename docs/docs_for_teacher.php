<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Portal Documentation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
        }
        h2 {
            margin-top: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }
        .section {
            margin-bottom: 30px;
        }
        .feature {
            background: #f9f9f9;
            padding: 15px;
            border-left: 4px solid #007BFF;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .feature h3 {
            margin-top: 0;
            color: #007BFF;
        }
        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-btn:hover {
            background: #0056b3;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Teacher Portal Documentation</h1>
        
        <div class="section">
            <h2>Getting Started</h2>
            <p>Welcome to the Teaching Plan Generator Teacher Portal. This guide will help you understand how to create and update your teaching plans.</p>
        </div>
        
        <div class="section">
            <h2>Creating a Teaching Plan</h2>
            
            <div class="feature">
                <h3>Basic Information</h3>
                <p>1. <strong>Select Semester</strong>: Choose the semester you're teaching (3-8)</p>
                <p>2. <strong>Select Subject</strong>: Choose your subject from the dropdown (populated based on semester)</p>
                <p>3. <strong>Select Division</strong>: Choose the division (A, B, or NONE if applicable)</p>
            </div>
            
            <div class="feature">
                <h3>First Week Schedule</h3>
                <p>Set up your teaching days for the first week:</p>
                <ul>
                    <li>Click "Add Day" to add additional teaching days</li>
                    <li>Select the day of the week (Monday-Friday)</li>
                    <li>Enter the number of lectures for that day</li>
                    <li>Click "Remove" to delete a day if needed</li>
                </ul>
                <p><strong>Note:</strong> You cannot select the same day twice in the same week.</p>
            </div>
            
            <div class="feature">
                <h3>Regular Week Schedule</h3>
                <p>Set up your standard weekly teaching schedule:</p>
                <ul>
                    <li>Click "Add Day" to add additional teaching days</li>
                    <li>Select the day of the week (Monday-Friday)</li>
                    <li>Enter the number of lectures for that day</li>
                    <li>Click "Remove" to delete a day if needed</li>
                </ul>
                <p><strong>Note:</strong> You cannot select the same day twice in the same week.</p>
            </div>
        </div>
        
        <div class="section">
            <h2>Generating and Updating Plans</h2>
            
            <div class="feature">
                <h3>Generate Dates</h3>
                <p>Click "Generate Dates" to:</p>
                <ul>
                    <li>Create a new teaching plan with your schedule</li>
                    <li>Automatically calculate teaching dates based on academic calendar</li>
                    <li>Exclude non-teaching days (holidays, etc.)</li>
                </ul>
            </div>
            
            <div class="feature">
                <h3>Update Dates</h3>
                <p>Click "Update Dates" to:</p>
                <ul>
                    <li>Modify an existing teaching plan</li>
                    <li>Update your schedule while preserving other data</li>
                    <li>Recalculate dates if the academic calendar changes</li>
                </ul>
            </div>
        </div>
        
        <div class="section">
            <h2>Troubleshooting</h2>
            <div class="feature">
                <h3>Common Issues</h3>
                <table>
                    <tr>
                        <th>Issue</th>
                        <th>Solution</th>
                    </tr>
                    <tr>
                        <td>Subject not appearing</td>
                        <td>Verify you've selected the correct semester</td>
                    </tr>
                    <tr>
                        <td>Can't select a day</td>
                        <td>Check if the day is already selected in that week</td>
                    </tr>
                    <tr>
                        <td>Error messages</td>
                        <td>Ensure all required fields are filled (marked with *)</td>
                    </tr>
                </table>
            </div>
        </div>
        
        <div class="section">
            <h2>Best Practices</h2>
            <ul>
                <li>Double-check your schedule before submitting</li>
                <li>Coordinate with colleagues teaching the same subject</li>
                <li>Use "Update Dates" rather than creating new plans for changes</li>
                <li>Contact admin if you need to modify a locked plan</li>
            </ul>
        </div>
        
        <a href="../teacher/teacher.php" class="back-btn">Back to Teacher Portal</a>
    </div>
</body>
</html>