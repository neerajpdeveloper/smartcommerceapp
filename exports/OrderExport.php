<?php

class OrderExport implements ExportInterface
{
    protected $orderModel;
    protected $userId;

    public function __construct($userId = null)
    {
        $this->orderModel = new Order();
        $this->userId = $userId;
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
        if ($this->userId) {
            return $this->orderModel->getByUser($this->userId);
        }
    }

public function map($row): array
{
    return [
        is_array($row) ? $row['order_no'] : $row->order_no,
        is_array($row) ? $row['grand_total'] : $row->grand_total,
        is_array($row) ? $row['order_status'] : $row->order_status,
        is_array($row) ? $row['payment_status'] : $row->payment_status,
        is_array($row) ? $row['payment_method'] : $row->payment_method,
        is_array($row) ? $row['created_at'] : $row->created_at,
    ];
}
}