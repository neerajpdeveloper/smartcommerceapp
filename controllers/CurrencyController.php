<?php 
class CurrencyController extends Controller
{
    public function change()
    {
        $code = $_POST['code'];

        $service = new CurrencyService();
        $service->setCurrency($code);

        header("Location: " . $_SERVER['HTTP_REFERER']);
    }
}