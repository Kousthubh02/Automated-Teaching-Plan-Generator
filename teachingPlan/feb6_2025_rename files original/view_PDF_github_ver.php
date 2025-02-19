<?php
// Start output buffering
ob_start();

// Suppress errors and warnings (optional, for debugging purposes)
error_reporting(0);

// Load TCPDF library
require 'vendor/autoload.php';

// Check if form data was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Create a new PDF instance
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8');
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Your Name');
    $pdf->SetTitle('Teaching Plan PDF');
    $pdf->SetHeaderData('', 0, 'Teaching Plan', '');
    $pdf->setHeaderFont([PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN]);
    $pdf->setFooterFont([PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA]);
    $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
    $pdf->SetMargins(5, 27, 15);
    $pdf->SetAutoPageBreak(true, 15); //25
    $pdf->AddPage();

    // Extract data from POST
    $proposedDates = $_POST['proposed_date'] ?? [];
    $contents = $_POST['content'] ?? [];
    $actualDates = $_POST['actual_date'] ?? [];
    $contentNotCovered = $_POST['content_not_covered'] ?? [];
    $references = $_POST['reference'] ?? [];
    $methodologies = $_POST['methodology'] ?? [];
    $coMappings = $_POST['co_mapping'] ?? [];

    // Initialize the table
    $html = '<h3>Teaching Plan</h3>';
    $html .= '<table border="1" cellspacing="3" cellpadding="4" style="width: 100%;">';
    $html .= '
        <tr>
            <th style="width: 10%;">Proposed Date</th>
            <th style="width: 36%;">Content</th> 
            <th style="width: 10%;">Actual Date</th>
            <th style="width: 15%;">Content Not Covered</th>
            <th style="width: 15%;">Reference</th>
            <th style="width: 11%;">Methodology</th>
            <th style="width: 8%;">CO Mapping</th>
        </tr>
    '; //36 <- 31

    // Loop through the content and add rows to the table
    foreach ($contents as $pk => $content) {
        $rowHtml = '<tr>';
        $rowHtml .= '<td style="width: 10%;">' . htmlspecialchars($proposedDates[$pk] ?? '') . '</td>'; // Proposed Date
        $rowHtml .= '<td style="width: 36%;">' . htmlspecialchars($content) . '</td>'; // Content 31
        $rowHtml .= '<td style="width: 10%;">' . htmlspecialchars($actualDates[$pk] ?? '') . '</td>'; // Actual Date
        $rowHtml .= '<td style="width: 15%;">' . htmlspecialchars($contentNotCovered[$pk] ?? '') . '</td>'; // Content Not Covered
        $rowHtml .= '<td style="width: 15%;">' . htmlspecialchars($references[$pk] ?? '') . '</td>'; // Reference
        $rowHtml .= '<td style="width: 11%;">' . htmlspecialchars($methodologies[$pk] ?? '') . '</td>'; // Methodology
        $rowHtml .= '<td style="width: 8%;">' . htmlspecialchars($coMappings[$pk] ?? '') . '</td>'; // CO Mapping
        $rowHtml .= '</tr>';

        // Add the row to the HTML table
        
        $html .= $rowHtml;
    }

    $html .= '</table>';

    // Add the table to the PDF
    $pdf->writeHTML($html, true, false, true, false, '');

    // Clean the output buffer
    ob_end_clean();

    // Output the PDF
    $pdf->Output('teaching_plan.pdf', 'I'); // I = Display in browser, D = Download
    exit;

} else {
    // Clean the output buffer
    ob_end_clean();
    echo "No data received!";
    exit;
}