<?php

class Router {

    public function handle()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

        // ✅ REMOVE BASE FOLDER
        $baseFolder = '/smartcommerceapp';

        if (strpos($uri, $baseFolder) === 0) {
            $uri = substr($uri, strlen($baseFolder));
        }

        $uri = trim($uri, '/');

        $segments = explode('/', $uri);

        $controller = $segments[0] ?? 'home';
        $param = $segments[1] ?? null;

        switch ($controller) {

            case 'product':
                $obj = new ProductController();
                if (!empty($param)) {
                    $obj->productBySlug($param);
                } else {
                    $obj->index();
                }
                break;

            case 'category':
                $obj = new CategoryController();

                if (!empty($param)) {
                    $obj->detail($param);
                } else {
                    $obj->index();
                }
                break;
            case 'brands':
                $obj = new BrandController();

                if (!empty($param)) {
                    $obj->detail($param);
                } else {
                    $obj->index();
                }
                break;

            case 'currency':
            $obj = new CurrencyController();
            $obj->change();
            break;

            case 'login':
            $obj = new AuthController();
            $obj->loginForm();
            break;

            case 'login-post':
                $obj = new AuthController();
                $obj->login();
                break;

            case 'register':
                $obj = new AuthController();
                $obj->registerForm();
                break;

            case 'register-post':
                $obj = new AuthController();
                $obj->register();
                break;

            case 'logout':
                $obj = new AuthController();
                $obj->logout();
                break;

            case 'cart':
                $obj = new CartController();
                $obj->index();
                break;

            default:
                $obj = new HomeController();
                $obj->index();
        }
    }
}