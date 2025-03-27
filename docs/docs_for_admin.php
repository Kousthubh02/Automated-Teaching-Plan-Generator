<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Instructions</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
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
        pre {
            background-color: #f5f5f5;
            padding: 10px;
            border-radius: 4px;
            overflow-x: auto;
        }
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            table {
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Admin Portal Instructions</h1>
        
        <div class="section">
            <h2>Getting Started</h2>
            <p>Welcome to the Teaching Plan Generator Admin Portal. This guide will help you understand how to use all the features of the portal.</p>
        </div>
        
        <div class="section">
            <h2>Dates Section</h2>
            
            <div class="feature">
                <h3>Setting Academic Dates</h3>
                <p>1. <strong>Start Date</strong>: Select the beginning date of the Semester in DD-MM-YYYY format.</p>
                <p>2. <strong>End Date</strong>: Select the ending date of the Semester in DD-MM-YYYY format.</p>
                <p>3. <strong>Non-Teaching Dates</strong>: Upload a CSV file containing all non-teaching days in the semster with Semester specifications.</p>
           <p> <strong> Note:</strong>Non Teaching days include Public Holidays , Examinations , College Fests , Industrial Visits etc. </p>
            </div>
            
            <div class="feature">
                <h3>CSV Template Format</h3>
                <p>The CSV file for non-teaching dates must contain three columns with the following specifications:</p>
                
                <table>
                    <tr>
                        <th>Column</th>
                        <th>Format</th>
                        <th>Description</th>
                        <th>Examples</th>
                    </tr>
                    <tr>
                        <td>date</td>
                        <td>DD-MM-YYYY</td>
                        <td>Holiday date</td>
                        <td>26-01-2023<br>15-08-2023</td>
                    </tr>
                    <tr>
                        <td>reason</td>
                        <td>Text</td>
                        <td>Description of holiday</td>
                        <td>Republic Day<br>College Event</td>
                    </tr>
                    <tr>
                        <td>semesters</td>
                        <td>Comma-separated values or "ALL"</td>
                        <td>Which semesters this holiday applies to</td>
                        <td>3 (only sem 3)<br>3,4,5 (sems 3-5)<br>ALL (all semesters)</td>
                    </tr>
                </table>
                
                <p><strong>Example CSV Content:</strong></p>
                <pre>date,reason,semesters
26-01-2023,Republic Day,ALL
15-08-2023,Independence Day,ALL
02-10-2023,Gandhi Jayanti,ALL
25-12-2023,Christmas,ALL
01-05-2023,Labour Day,3,4,5
10-09-2023,College Event,6,7</pre>
                
                <p><strong>Important Notes:</strong></p>
                <ul>
                    <li>Use exact column headers (date, reason, semesters)</li>
                    <li>Dates must be in DD-MM-YYYY format</li>
                    <li>For semester-wide holidays, use "ALL"</li>
                    <li>For specific semesters, list them comma-separated (no spaces)</li>
                    <li>Valid semester values: 3,4,5,6,7,8 or ALL</li>
                    <li>Don't include empty rows in the CSV</li>
                </ul>
            </div>
        </div>
        
        <div class="section">
            <h2>Control Section</h2>
            
            <div class="feature">
                <h3>Editable Status</h3>
                <p>The current editable status shows whether faculty can modify their teaching plans:</p>
                <ul>
                    <li><strong>Editable</strong>: Faculty can make changes</li>
                    <li><strong>Not Editable</strong>: Faculty can only view plans</li>
                </ul>
                <p>Use the "Toggle Editable" button to change this status.</p>
            </div>
            
            <div class="feature">
                <h3>Deleting Teaching Plans</h3>
                <p>1. Select the semester, subject, and division from the dropdown menus.</p>
                <p>2. Click "DELETE" to remove that specific teaching plan.</p>
                <p>3. Use "Delete All" to remove all teaching plans (use with caution).</p>
            </div>
            
            <div class="feature">
                <h3>Non-Teaching Dates</h3>
                <p>The "Delete Non Teaching Dates" button removes all holiday/non-teaching date entries from the system.</p>
                <p>Note: This doesn't affect existing teaching plans, only the dates marked as non-teaching.</p>
            </div>
        </div>
        
        <div class="section">
            <h2>Tips</h2>
            <ul>
                <li>Always verify dates before submitting (use DD-MM-YYYY format)</li>
                <li>Download and use the CSV template to ensure proper formatting</li>
                <li>Clearly specify which semesters each holiday applies to</li>
                <li>Communicate with faculty when changing editable status</li>
                <li>Use the delete functions carefully as actions cannot be undone</li>
                <li>For college-wide holidays, use "ALL" in the semesters column</li>
            </ul>
        </div>
        
        <a href="../admin/admin_2.php" class="back-btn">Back to Admin Portal</a>
    </div>
</body>
</html>