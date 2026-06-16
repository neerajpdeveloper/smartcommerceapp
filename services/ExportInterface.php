<?php

interface ImportExportInterface
{
    public function headings(): array;

    public function collection(): array;

    public function map($row): array;
}