<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ExcelService
{
    public function export(ExportInterface $exporter)
    {
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        // Header
        $col = 'A';

        foreach ($exporter->headings() as $heading) {

            $sheet->setCellValue($col . '1', $heading);

            $col++;
        }

        $rowNumber = 2;

        foreach ($exporter->collection() as $item) {

            $mapped = $exporter->map($item);

            $col = 'A';

            foreach ($mapped as $value) {

                $sheet->setCellValue(
                    $col . $rowNumber,
                    $value
                );

                $col++;
            }

            $rowNumber++;
        }

        header(
            'Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
        );

        header(
            'Content-Disposition: attachment; filename="export.xlsx"'
        );

        $writer = new Xlsx($spreadsheet);

        $writer->save('php://output');

        exit;
    }

    public function import($file)
    {
        $spreadsheet = IOFactory::load($file);

        return $spreadsheet
            ->getActiveSheet()
            ->toArray();
    }
}