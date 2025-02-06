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
            // Custom header for each page (Logo and Institute Name)
            // uncomment extension=gd from C:\xampp\php\php.ini
            $imageFile = 'BW_logo.png'; // Change to the actual image path
            $this->Image($imageFile, 10, 5, 30);

            // Set font
            $this->SetFont('times', '', 15);
            $this->Cell(0, 10, 'Agnel Charities', 0, 1, 'C');

            $this->SetFont('times', 'B', 20);
            $this->Cell(0, 10, 'Fr. C. Rodrigues Institute of Technology, Vashi', 0, 1, 'C');

            $this->SetFont('times', '', 15);
            $this->Cell(0, 10, '(An Autonomous Institute and Permanently Affiliated to University of Mumbai)' . $this->subject, 0, 1, 'C');
        
            $this->SetTopMargin(50);
        }

        // This function is used to set a table header on each page
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
                    <th style="width: 6%; border: 1px solid #000;">Remarks</th>
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
    $pdf->SetTitle('Teaching Plan for ' . $subject);
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
    $references        = $_POST['reference']             ?? [];
    $methodologies     = $_POST['methodology']           ?? [];
    $coMappings        = $_POST['co_mapping']            ?? [];

    // Initialize the HTML for the table with all columns
    $html  = '<h3 style="text-align:center;">Teaching Plan for ' . $subject . '</h3>';
    $html .= '<table cellspacing="0" cellpadding="4" style="width: 100%; border-collapse: collapse;">';

    // Write the header row for the table
    $html .= $pdf->TableHeader(); // Add the table header row here

    // Loop through the content and add rows to the table.
    foreach ($contents as $pk => $content) {
        $proposedDate = htmlspecialchars($proposedDates[$pk] ?? '');
        $contentSafe  = htmlspecialchars($content);
        $actualDate   = htmlspecialchars($actualDates[$pk] ?? '');
        $notCovered   = htmlspecialchars($contentNotCovered[$pk] ?? '');
        $reference    = htmlspecialchars($references[$pk] ?? '');
        $methodology  = htmlspecialchars($methodologies[$pk] ?? '');
        $coMapping    = htmlspecialchars($coMappings[$pk] ?? '');
        $remarks      = '';
        $verified     = '';

        $html .= '<tr style="page-break-inside: avoid;">';
        $html .= '<td style="width: 5%; text-align:center; border: 1px solid #000;">' . htmlspecialchars($pk) . '</td>';
        $html .= '<td style="width: 10%; border: 1px solid #000;">' . $proposedDate . '</td>';
        $html .= '<td style="width: 25%; border: 1px solid #000;">' . $contentSafe . '</td>';
        $html .= '<td style="width: 10%; border: 1px solid #000;">' . $actualDate . '</td>';
        $html .= '<td style="width: 10%; border: 1px solid #000;">' . $notCovered . '</td>';
        $html .= '<td style="width: 10%; border: 1px solid #000;">' . $reference . '</td>';
        $html .= '<td style="width: 10%; border: 1px solid #000;">' . $methodology . '</td>';
        $html .= '<td style="width: 8%; border: 1px solid #000;">' . $coMapping . '</td>';
        $html .= '<td style="width: 6%; border: 1px solid #000;">' . $remarks . '</td>';
        $html .= '<td style="width: 6%; border: 1px solid #000;">' . $verified . '</td>';
        $html .= '</tr>';
    }

    $html .= '</table>';

    // Write the HTML content to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Add a new page and repeat the header if necessary
    //$pdf->AddPage();
    //$html = '<table cellspacing="0" cellpadding="4" style="width: 100%; border-collapse: collapse;">';
    //$html .= $pdf->TableHeader(); // Repeating the header row here
    
    // You can loop through the next data if you have more
    // Continue adding content to the table (if necessary)

    //$html .= '</table>';
    //$pdf->writeHTML($html, true, false, true, false, '');

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
