<?php
// Start output buffering
ob_start();

// (Optionally) Suppress errors and warnings for production use
error_reporting(0);

// Load TCPDF library via Composer autoload
require 'vendor/autoload.php';

// Check if form data was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    // Get the subject from the GET parameters (if available)
    $subject = isset($_GET['subject']) ? htmlspecialchars($_GET['subject']) : 'Teaching Plan';

    class MYPDF extends TCPDF {
        public function Header() {

            $imageFile = 'BW_logo.png'; // Change to the actual image path
            $this->Image($imageFile, 10, 5, 30);
            

            // Set font
            $this->SetFont('times', '', 15);
            $this->Cell(0, 10, 'Agnel Charities', 0, 1, 'C');

            $this->SetFont('times', 'B', 20);
            // Move to center alignment
            $this->Cell(0, 10, 'Fr. C. Rodrigues Institute of Technology, Vashi', 0, 1, 'C'); // Centered, new line

            $this->SetFont('times', '', 15);
            $this->Cell(0, 10, '(An Autonomous Institute and Permanently Affiliated to University of Mumbai)' . $this->subject, 0, 1, 'C'); // Centered, new line
        }
    }
    
    // Instantiate the PDF using the new class
    $pdf = new MYPDF('L', 'mm', 'A4', true, 'UTF-8');

    // Create a new PDF instance
    //$pdf = new TCPDF();
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Teaching Plan for ' . $subject);
    $pdf->setPrintHeader(true);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(10, 27, 10);
    $pdf->SetAutoPageBreak(true, 15);
    $pdf->AddPage();


    

    // Set the font to Times New Roman with size 10
    $pdf->SetFont('times', '', 10);
    $pdf->Ln(10);

    // Extract data from POST
    $proposedDates     = $_POST['proposed_date']       ?? [];
    $contents          = $_POST['content']               ?? [];
    $actualDates       = $_POST['actual_date']           ?? [];
    $contentNotCovered = $_POST['content_not_covered']    ?? [];
    $references        = $_POST['reference']             ?? [];
    $methodologies     = $_POST['methodology']           ?? [];
    $coMappings        = $_POST['co_mapping']            ?? [];

    // Initialize the HTML for the table with all columns
    $html  = '<h3 style="text-align:center;">Teaching Plan for ' . $subject . '</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4" style="width: 100%;">';
    $html .= '
        <tr>
            <th style="width: 5%;">Lecture No</th>
            <th style="width: 10%;">Proposed Date</th>
            <th style="width: 25%;">Content</th> 
            <th style="width: 10%;">Actual Date</th>
            <th style="width: 10%;">Content Not Covered</th>
            <th style="width: 10%;">Reference</th>
            <th style="width: 10%;">Methodology</th>
            <th style="width: 8%;">CO Mapping</th>
            <th style="width: 6%;">Remarks</th>
            <th style="width: 6%;">Verified by HOD</th>
        </tr>
    ';

    // Loop through the content and add rows to the table.
    // Here, we use the $pk from the POST arrays as the lecture number.
    foreach ($contents as $pk => $content) {
        $proposedDate = htmlspecialchars($proposedDates[$pk] ?? '');
        $contentSafe  = htmlspecialchars($content);
        $actualDate   = htmlspecialchars($actualDates[$pk] ?? '');
        $notCovered   = htmlspecialchars($contentNotCovered[$pk] ?? '');
        $reference    = htmlspecialchars($references[$pk] ?? '');
        $methodology  = htmlspecialchars($methodologies[$pk] ?? '');
        $coMapping    = htmlspecialchars($coMappings[$pk] ?? '');
        // Remarks and Verified by HOD are not submitted, so we leave them blank.
        $remarks      = '';
        $verified     = '';

        $html .= '<tr>';
        $html .= '<td style="width: 5%;">' . htmlspecialchars($pk) . '</td>';
        $html .= '<td style="width: 10%;">' . $proposedDate . '</td>';
        $html .= '<td style="width: 25%;">' . $contentSafe . '</td>';
        $html .= '<td style="width: 10%;">' . $actualDate . '</td>';
        $html .= '<td style="width: 10%;">' . $notCovered . '</td>';
        $html .= '<td style="width: 10%;">' . $reference . '</td>';
        $html .= '<td style="width: 10%;">' . $methodology . '</td>';
        $html .= '<td style="width: 8%;">' . $coMapping . '</td>';
        $html .= '<td style="width: 6%;">' . $remarks . '</td>';
        $html .= '<td style="width: 6%;">' . $verified . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Write the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

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
