<?php
class AuthController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = new User();
    }

    // 📄 REGISTER FORM
    public function registerForm()
    {
        return $this->view('register');
    }

    // 📝 REGISTER PROCESS
    public function register()
    {
        $name = $_POST['name'];
        $email = $_POST['email'];
        $mobile = $_POST['mobile'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

        $exists = $this->user->getByEmail($email);

        if ($exists) {
            echo "Email already exists";
            return;
        }

        $this->user->create([
            'name' => $name,
            'email' => $email,
            'mobile' => $mobile,
            'password' => $password
        ]);

        header("Location:".siteUrl()."/login");
    }

    // 🔐 LOGIN FORM
    public function loginForm()
    {
        return $this->view('login');
    }

    // 🔑 LOGIN PROCESS
    public function login()
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        $user = $this->user->getByEmail($email);

        if (!$user || !password_verify($password, $user->password)) {
            echo "Invalid login";
            return;
        }

        $_SESSION['user'] = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];

        header("Location:".siteUrl());
    }

    // 🚪 LOGOUT
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();

        header("Location:".siteUrl());
    }
}