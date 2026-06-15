<?php
class AuthController extends Controller
{
    protected $user;
    protected $google;
    protected $facebook;

    public function __construct()
    {
        $this->user = new User();
        $this->google = new GoogleService();
        $this->facebook = new FacebookService();
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

    public function googleLogin()
{
    header(
        'Location: ' .
        $this->google->loginUrl()
    );

    exit;
}

/*
|--------------------------------------------------------------------------
| GOOGLE CALLBACK
|--------------------------------------------------------------------------
*/

public function googleCallback()
{
    try {

        $code = $_GET['code'] ?? '';

        if (!$code) {

            $_SESSION['error'] =
                'Google authentication failed';

            header(
                'Location:' .
                siteUrl() .
                '/login'
            );

            exit;
        }

        $accessToken =
            $this->google
            ->getAccessToken($code);

        if (!$accessToken) {

            throw new Exception(
                'Unable to get Google access token'
            );
        }

        $googleUser =
            $this->google
            ->getUser($accessToken);

        if (
            empty($googleUser['email'])
        ) {

            throw new Exception(
                'Google account email not found'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | CHECK USER
        |--------------------------------------------------------------------------
        */

        $user =
            $this->user
            ->getByEmail(
                $googleUser['email']
            );

        /*
        |--------------------------------------------------------------------------
        | REGISTER IF NOT EXISTS
        |--------------------------------------------------------------------------
        */
        if (!$user) {

            $userId =
                $this->user
                ->create([

                    'name' =>
                    $googleUser['name'],

                    'email' =>
                    $googleUser['email'],

                    'mobile' => '',
                    'password' => null,
                    'google_id' =>
                    $googleUser['id'],
                    'facebook_id' =>
                    null,
                    'avatar' =>
                    $googleUser['picture']
                    ?? null,

                    
                ]);

            $user =
                $this->user
                ->getByID($userId);
        }

        /*
        |--------------------------------------------------------------------------
        | LOGIN SESSION
        |--------------------------------------------------------------------------
        */

        $_SESSION['user'] = [

            'id' =>
            $user->id,

            'name' =>
            $user->name,

            'email' =>
            $user->email
        ];

        header(
            'Location:' .
            siteUrl()
        );


    } catch (Throwable $e) {

        ErrorHandler::log(
            'GOOGLE_LOGIN_ERROR',
            $e->getMessage()
        );

        $_SESSION['error'] =
            $e->getMessage();

        header(
            'Location:' .
            siteUrl() .
            '/login'
        );

        exit;
    }
}

    public function facebookLogin()
{
    header(
        "Location: " .
        $this->facebook->loginUrl()
    );

    exit;
}

    public function facebookCallback()
{
    $code =
        $_GET['code'] ?? '';

    if (!$code) {

        die(
            'Facebook Authorization Failed'
        );
    }

    $token =
        $this->facebook
        ->getAccessToken($code);

    if (!$token) {

        die(
            'Facebook Access Token Failed'
        );
    }

    $fbUser =
        $this->facebook
        ->getUser($token);

    $user =
        $this->user
        ->getByEmail(
            $fbUser['email']
        );

    if (!$user) {

        $userId =
            $this->user
            ->create([

                'name' =>
                $fbUser['name'],

                'email' =>
                $fbUser['email'],
                
                'mobile' => '',
                'password' => '',
                'google_id' => '',
                'facebook_id' =>
                $fbUser['id'],

                'avatar' =>
                $fbUser['picture']['data']['url']
                ?? null,

            ]);

        $user =
            $this->user
            ->getByID($userId);
    }

    $_SESSION['user'] = [

        'id' =>
        $user->id,

        'name' =>
        $user->name,

        'email' =>
        $user->email
    ];

    header(
        "Location:" .
        siteUrl()
    );

    exit;
}
}