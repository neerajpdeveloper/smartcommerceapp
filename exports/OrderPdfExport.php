<?php

class OrderPdfExport implements PdfExportInterface
{
    private Order $order;
    private int $userId;

    public function __construct($userId)
    {
        $this->order = new Order();
        $this->userId = $userId;
    }

    public function title(): string
    {
        return 'My Orders';
    }

    public function headings(): array
    {
        return [
            'Order No',
            'Amount',
            'Order Status',
            'Payment Status',
            'Payment Method',
            'Date'
        ];
    }

    public function collection(): array
    {
        return $this->order->getByUser($this->userId);
    }

    public function map($row): array
    {
        return [
            $row->order_no,
            $row->grand_total,
            $row->order_status,
            $row->payment_status,
            $row->payment_method,
            date('d M Y', strtotime($row->created_at))
        ];
    }
}