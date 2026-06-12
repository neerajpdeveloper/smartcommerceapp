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
                $obj->productBySlug($param);
                break;

            case 'category':
                $obj = new CategoryController();

                if (!empty($param)) {
                    $obj->detail($param);
                } else {
                    $obj->index();
                }
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