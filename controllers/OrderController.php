<?php

class OrderController extends Controller
{
    public function orderSuccess($id = null)
    {
        if (!$id) {

            header("Location: ".siteUrl());
            exit;
        }

        $orderModel = new Order();

$order = $orderModel->getOrderWithUser($id);


 /*
        |--------------------------------------------------------------------------
        | Send Order Confirmation Email
        |--------------------------------------------------------------------------
        */

try {
    // Pichle method ke hisab se '$order->email' ab '$order->customer_email' ban gaya hai
    if (!empty($order->customer_email)) {

        $html = TemplateService::render(
            'order-confirmation',
            [
                'customer_name'   => $order->customer_name,
                'order_no'        => $order->order_no,
                'amount'          => number_format($order->grand_total, 2),
                'payment_method'  => $order->payment_method,
                'payment_status'  => $order->payment_status,
                'order_status'    => $order->order_status,
                'currency_symbol' => $order->currency_symbol ?? '₹', // Fallback agar currency save na ho
                'order_date'      => date('d M Y h:i A', strtotime($order->created_at))
            ]
        );

        (new MailService())->send(
            $order->customer_email, // Updated column name
            'Order Confirmation - #' . $order->order_no,
            $html
        );
    }

} catch (Throwable $e) {
    $errorMessage = $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine();
    // Exception object ko poora paas karna behtar hota hai taaki file aur line number bhi log ho sakein
    ErrorHandler::log(
        'ORDER_EMAIL_ERROR',
        $errorMessage,
        ['exception' => $e] 
    );
}


        $data = [

            'order' => $orderModel->getById($id)

        ];

        return $this->view(
            'order-success',
            $data
        );
    }
}