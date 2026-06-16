<?php 
class UserController extends Controller
{
    protected $cart;
    protected $address;
    protected $orders;

    public function __construct()
    {
        if (!isLoggedIn()) {

            header("Location:".siteUrl()."/login");
            exit;
        }

        $this->cart = new Cart();
        $this->address = new CustomerAddress();
        $this->orders = new Order();
    }

    public function dashboard()
    {
        $data = [

            'user' => user(),
            'totalOrders' => $this->orders->countByUser(user()['id']),

            'cartItems' => $this->cart
                ->totalQty(user()['id']),

            'totalAddresses' => $this->address
                ->countByUser(user()['id'])

        ];

        return $this->view(
            'account/dashboard',
            $data
        );
    }

    public function addresses()
    {
        $data = [

            'addresses' => $this->address
                ->getByUser(user()['id'])

        ];

        return $this->view(
            'account/addresses',
            $data
        );
    }

    public function addAddress()
    {
        return $this->view(
            'account/address-add'
        );
    }

    public function saveAddress()
    {
        $this->address->create([

            'customer_id' => user()['id'],

            'full_name' => $_POST['full_name'],

            'mobile' => $_POST['mobile'],

            'address_line' => $_POST['address_line'],

            'city' => $_POST['city'],

            'state' => $_POST['state'],

            'pincode' => $_POST['pincode'],

            'is_default' => !empty($_POST['is_default']) ? 1 : 0

        ]);

        header(
            "Location:".siteUrl()."/user/addresses"
        );
        exit;
    }

    public function editAddress($id)
    {
        $data = [

            'address' => $this->address
                ->getById($id)

        ];

        return $this->view(
            'account/address-edit',
            $data
        );
    }

    public function updateAddress($id)
    {
        $this->address->updateAddress(
            $id,
            $_POST
        );

        header(
            "Location:".siteUrl()."/user/addresses"
        );
        exit;
    }

    public function deleteAddress($id)
    {
        $this->address->deleteAddress(
            $id,
            user()['id']
        );

        header(
            "Location:".siteUrl()."/user/addresses"
        );
        exit;
    }

    public function defaultAddress($id)
    {
        $this->address->setDefault(
            $id,
            user()['id']
        );

        header(
            "Location:".siteUrl()."/user/addresses"
        );
        exit;
    }

    public function order(){


        $data = [

            'order' => $this->orders->getByUser(user()['id']),
            'totalOrders' => $this->orders->countByUser(user()['id']),

        ];

        return $this->view(
            'account/orders',
            $data
        );
    }

   public function orderDetails($orderId)
{
    $userId = user()['id'];

    $orderModel = new Order();
    $orderService = new OrderService($orderModel);

    $data = $orderService->getOrderDetail($userId, $orderId);

    return $this->view('account/order-detail', [
        'order' => $data
    ]);
}

public function exportOrders()
{
    $excel = new ExcelService();

    $excel->export(
        new OrderExport(
            user()['id']
        )
    );
} 

public function exportProducts()
{
    $excel = new ExcelService();

    $excel->export(new ProductsExport());
} 


public function importProducts()
{
    if (empty($_FILES['excel']['tmp_name'])) {
        return;
    }

    $excel = new ExcelService();

    $rows = $excel->import(
        $_FILES['excel']['tmp_name']
    );

    $importer = new ProductImport();

    $importer->import($rows);

    $_SESSION['success'] = 'Products imported successfully';

}


public function exportPdfOrders()
{
    $pdf = new PdfService();

    $pdf->export(
        new OrderPdfExport(
            user()['id']
        )
    );
} 

}