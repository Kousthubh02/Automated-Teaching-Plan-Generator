<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start output buffering
ob_start();

// Load TCPDF library via Composer autoload
require 'vendor/autoload.php';

// Debug: Check if TCPDF is loaded
if (!class_exists('TCPDF')) {
    die('TCPDF library not found. Please install it using Composer.');
}

// Check if form data was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the subject from the GET parameters (if available)
    $subject = isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : 'Teaching Plan';

    // Retrieve isNTD from POST data
    $isNTD = json_decode($_POST['isNTD'] ?? '{}', true);
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Invalid JSON data in isNTD.');
    }

    class MYPDF extends TCPDF {
        public function Header() {
            // Custom header for each page (Logo and Institute Name)
            $imageFile = '../images/BW_logo.png'; // Change to the actual image path
            $this->Image($imageFile, 10, 5, 30);

            // Set font
            $this->SetFont('times', '', 15);
            $this->Cell(0, 10, 'Agnel Charities', 0, 1, 'C');

            $this->SetFont('times', 'B', 20);
            $this->Cell(0, 10, 'Fr. C. Rodrigues Institute of Technology, Vashi', 0, 1, 'C');

            $this->SetFont('times', '', 15);
            $this->Cell(0, 10, '(An Autonomous Institute and Permanently Affiliated to University of Mumbai)', 0, 1, 'C');
        
            if ($this->getPage() == 1) {
                $this->SetTopMargin(20); // Smaller margin for the first page
            } else {
                $this->SetTopMargin(40); // Default margin for subsequent pages
            }
        }

        public function TableHeader() {
            $html = '
                <thead>
                <tr style="background-color: #f2f2f2; border: 1px solid #000;">
                    <th style="width: 5%; border: 1px solid #000;">Lecture No</th>
                    <th style="width: 10%; border: 1px solid #000;">Proposed Date</th>
                    <th style="width: 25%; border: 1px solid #000;">Content</th> 
                    <th style="width: 10%; border: 1px solid #000;">Actual Date</th>
                    <th style="width: 10%; border: 1px solid #000;">Content Not Covered</th>
                    <th style="width: 10%; border: 1px solid #000;">Reference</th>
                    <th style="width: 10%; border: 1px solid #000;">Methodology</th>
                    <th style="width: 8%; border: 1px solid #000;">CO Mapping</th>
                    <th style="width: 6%; border: 1px solid #000;">Remarks with Signature</th>
                    <th style="width: 6%; border: 1px solid #000;">Verified by HOD</th>
                </tr>
                </thead>
            ';
            return $html;
        }
    }

    // Instantiate the PDF using the new class
    $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8');

    // Create a new PDF instance
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Teaching Plan PDF');
    $pdf->setPrintHeader(true);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(10, 27, 10);
    $pdf->SetAutoPageBreak(true, 15);

    // Add the first page
    $pdf->AddPage();

    // Set the font to Times New Roman with size 10
    $pdf->SetFont('times', '', 10);
    $pdf->Ln(10);

    // Extract data from POST
    $proposedDates     = $_POST['proposed_date']       ?? [];
    $contents          = $_POST['content']               ?? [];
    $actualDates       = $_POST['actual_date']           ?? [];
    $contentNotCovered = $_POST['content_not_covered']    ?? [];
    $references        = $_POST['plan_references']        ?? []; // Changed to plan_references
    $methodologies     = $_POST['methodology']           ?? [];
    $coMappings        = $_POST['co_mapping']            ?? [];

    // Process references data
    foreach ($references as $pk => $refArray) {
        $references[$pk] = is_array($refArray) ? implode(', ', $refArray) : $refArray;
    }

    foreach ($methodologies as $pk => $methodArray) {
        $methodologies[$pk] = is_array($methodArray) ? implode(', ', $methodArray) : $methodArray;
    }

    // Extract references data from POST
    $subjectReferences = json_decode($_POST['subject_references'] ?? '{}', true);

    // Debug: Check decoded references
    if (json_last_error() !== JSON_ERROR_NONE) {
        die('Invalid JSON data in subject_references.');
    }

    // Initialize the HTML for the table with all columns
    $html  = '<h2 style="text-align:center;">Department of Computer Engineering</h2>';
    $html .= '<h2 style="text-align:center;">Course Teaching Plan</h2>';
    $html .= '<table style="width: 100%; border-collapse: collapse; font-size: 12px;">
            <tr>
                <td style="padding: 8px; text-align: left; width: 50%;">Course Code and Name: </td>
                <td style="padding: 8px; text-align: left; width: 50%;">Academic Year: </td>
            </tr>
            <tr>
                <td style="padding: 8px; text-align: left; width: 50%;">Name of the Faculty: </td>
                <td style="padding: 8px; text-align: left; width: 50%;">Semester: </td>
            </tr>
            <tr><td></td></tr>
        </table>';
    
    $html .= "<br>";
    $html .= '<table cellspacing="0" cellpadding="4" style="width: 100%; border-collapse: collapse;">';

    // Write the header row for the table
    $html .= $pdf->TableHeader();

    // Initialize lecture number counter
    $lectureNumber = 1;

    // Loop through the content and add rows to the table
    foreach ($contents as $pk => $content) {
        $proposedDate = isset($proposedDates[$pk]) ? DateTime::createFromFormat('Y-m-d', $proposedDates[$pk])->format('d-m-Y') : '';
        $contentSafe  = htmlspecialchars($content);
        $actualDate   = htmlspecialchars($actualDates[$pk] ?? '');
        $notCovered   = htmlspecialchars($contentNotCovered[$pk] ?? '');
        $reference    = htmlspecialchars($references[$pk] ?? ''); // Now a string
        $methodology  = htmlspecialchars($methodologies[$pk] ?? '');
        $coMapping    = htmlspecialchars($coMappings[$pk] ?? '');
        $remarks      = '';
        $verified     = '';
    
        // Fetch isNTD from POST data
        $isNTDFlag = $isNTD[$pk] ?? 0; 
        $shouldExclude = $isNTDFlag == 1;
    
        // Start the row
        $html .= '<tr style="page-break-inside: avoid;">';
    
        if ($shouldExclude) {
            // Show empty cell for lecture number
            $html .= '<td style="width: 5%; text-align:center; border: 1px solid #000;"></td>';
            $html .= '<td style="width: 10%; border: 1px solid #000;">' . $proposedDate . '</td>';
            // Merge the remaining columns
            $html .= '<td colspan="8" style="text-align:center; border: 1px solid #000; font-weight: bold;">' . $contentSafe . '</td>';
        } else {
            // Normal row structure (no merging)
            $html .= '<td style="width: 5%; text-align:center; border: 1px solid #000;">' . $lectureNumber++ . '</td>';
            $html .= '<td style="width: 10%; border: 1px solid #000;">' . $proposedDate . '</td>';
            $html .= '<td style="width: 25%; border: 1px solid #000;">' . $contentSafe . '</td>';
            $html .= '<td style="width: 10%; border: 1px solid #000;">' . $actualDate . '</td>';
            $html .= '<td style="width: 10%; border: 1px solid #000;">' . $notCovered . '</td>';
            $html .= '<td style="width: 10%; border: 1px solid #000;">' . $reference . '</td>';
            $html .= '<td style="width: 10%; border: 1px solid #000;">' . $methodology . '</td>';
            $html .= '<td style="width: 8%; border: 1px solid #000;">' . $coMapping . '</td>';
            $html .= '<td style="width: 6%; border: 1px solid #000;">' . $remarks . '</td>';
            $html .= '<td style="width: 6%; border: 1px solid #000;">' . $verified . '</td>';
        }
    
        // End the row
        $html .= '</tr>';
    }
    

    $html .= '</table>';

    // Write the HTML content to the PDF
    // After writing the main table, calculate remaining space and add references table conditionally
    $pdf->writeHTML($html, true, false, true, false, '');

    // Calculate remaining space on the current page
    $remainingSpace = $pdf->getPageHeight() - $pdf->GetY(); // Get remaining vertical space
    $referencesTableHeight = 100; // Approximate height of the references table (adjust as needed)

    // Check if there's enough space for the references table
    if ($remainingSpace < $referencesTableHeight) {
        // Add a new page if there isn't enough space
        $pdf->AddPage();
    }

    // Initialize the HTML for the references table
    $html = '<h3 style="text-align:center;">References</h3>';
    $html .= '<table cellspacing="0" cellpadding="4" style="width: 100%; border-collapse: collapse; font-size: 12px;">';

    // Write the header row for the references table
    $html .= '
        <thead>
        <tr style="background-color: #f2f2f2; border: 1px solid #000;">
            <th style="width: 33%; border: 1px solid #000;">References</th>
            <th style="width: 33%; border: 1px solid #000;">Textbooks</th>
            <th style="width: 33%; border: 1px solid #000;">Others</th>
        </tr>
        </thead>
        <tbody>
    ';

    // Loop through the references and add rows to the table
    $referenceCodes = ['R1', 'R2', 'R3', 'R4', 'R5'];
    $textbookCodes = ['T1', 'T2', 'T3', 'T4', 'T5'];
    $webReferenceCodes = ['O1', 'O2', 'O3', 'O4', 'O5'];

    for ($i = 0; $i < 5; $i++) {
        $html .= '<tr>';
        
        // References column
        $html .= '<td style="width: 33%; border: 1px solid #000;">';
        $html .= '<strong>' . $referenceCodes[$i] . ':</strong> ' . htmlspecialchars($subjectReferences[$referenceCodes[$i]] ?? '');
        $html .= '</td>';
        
        // Textbooks column
        $html .= '<td style="width: 33%; border: 1px solid #000;">';
        $html .= '<strong>' . $textbookCodes[$i] . ':</strong> ' . htmlspecialchars($subjectReferences[$textbookCodes[$i]] ?? '');
        $html .= '</td>';
        
        // Others column
        $html .= '<td style="width: 33%; border: 1px solid #000;">';
        $html .= '<strong>' . $webReferenceCodes[$i] . ':</strong> ' . htmlspecialchars($subjectReferences[$webReferenceCodes[$i]] ?? '');
        $html .= '</td>';
        
        $html .= '</tr>';
    }

    $html .= '</tbody></table>';

    // Write the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');


    // Content not covered table
    $pdf->AddPage();
    $title  = '<h3 style="text-align:center;">Non-Adherance to the Teaching Plan</h3>';
    $pdf->writeHTML($title, true, false, true, false, '');

    $header = array('Sr.No', 'Lecture No.', 'Planned content', 'Content not covered as per plan', 'Justification');
    $table_width = array(15, 30, 70, 70, 90);
    foreach ($header as $key => $col_name) {
        $pdf->Cell($table_width[$key], 7, $col_name, 1, 0, 'C');
    }
    $pdf->Ln();
    for ($i = 0; $i < 5; $i++) {
        $pdf->Cell($table_width[0], 12, '', 1, 0, 'C');
        $pdf->Cell($table_width[1], 12, '', 1, 0, 'C');
        $pdf->Cell($table_width[2], 12, '', 1, 0, 'L');
        $pdf->Cell($table_width[3], 12, '', 1, 0, 'L');
        $pdf->Cell($table_width[4], 12, '', 1, 1, 'L');
    }

    //$pdf->writeHTML($html, true, false, true, false, '');
    $pdf->Ln(10); // Add space after the table

    // Define the formula text
    $formula = '<p style="font-size:12px; text-align:center;">
    <b>The percentage Adherence = 1 - </b> 
    <span style="text-decoration:underline;">Number of lectures in which the content is not covered as per the plan</span> <br>
    <span>Total number of lectures</span>
    <br><br>
    </p>';
    
    // Write the formula to the PDF
    $pdf->writeHTML($formula, true, false, true, false, '');
    
    // Add a blank space for handwritten percentage
    $pdf->Ln(5);
    $pdf->SetFont('times', 'B', 12);
    $pdf->Cell(0, 10, 'The percentage Adherence =  ________________ %', 0, 1, 'C');

    $pdf->Ln(25); // Add space for signatures

    // Signature section
    $signature = '
    <table width="100%">
        <tr>
            <td style="text-align:center; width: 50%;">
                <b>Signature of Course Coordinator</b><br>
            </td>
            <td style="text-align:center; width: 50%;">
                <b>Head of the Department</b><br>
                <span style="font-weight:normal;">Department of Computer Engg.</span>
            </td>
        </tr>
    </table>';
    
    // Write the signature section to the PDF
    $pdf->writeHTML($signature, true, false, true, false, '');        

    // Clean the output buffer
    ob_end_clean();

    // Output the PDF in the browser (I = inline display, D = force download)
    $pdf->Output('teaching_plan.pdf', 'I');
    exit;
} else {
    // Clean the output buffer and display an error message if no data is received.
    ob_end_clean();
    echo "No data received!";
    exit;
}
