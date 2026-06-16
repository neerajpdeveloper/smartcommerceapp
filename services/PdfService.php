<?php

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfService
{
    public function export(PdfExportInterface $exporter)
    {
        $html = '';

        $html .= '<h2>' . $exporter->title() . '</h2>';

        $html .= '<table border="1" width="100%" cellspacing="0" cellpadding="8">';
        $html .= '<thead><tr>';

        foreach ($exporter->headings() as $heading) {
            $html .= '<th>' . $heading . '</th>';
        }

        $html .= '</tr></thead><tbody>';

        foreach ($exporter->collection() as $row) {

            $html .= '<tr>';

            foreach ($exporter->map($row) as $value) {
                $html .= '<td>' . htmlspecialchars($value) . '</td>';
            }

            $html .= '</tr>';
        }

        $html .= '</tbody></table>';

        $options = new Options();
        $options->set('isRemoteEnabled', true);

        $pdf = new Dompdf($options);

        $pdf->loadHtml($html);

        $pdf->setPaper('A4', 'landscape');

        $pdf->render();

        $pdf->stream(
            strtolower(str_replace(' ', '-', $exporter->title())) . '.pdf',
            ['Attachment' => true]
        );

        exit;
    }
}