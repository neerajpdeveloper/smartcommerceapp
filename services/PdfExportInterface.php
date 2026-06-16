<?php

interface PdfExportInterface
{
    public function title(): string;

    public function headings(): array;

    public function collection(): array;

    public function map($row): array;
}