<?php

class TemplateService
{
    public static function render(
        string $template,
        array $data = []
    )
    {
        extract($data);

        ob_start();

$templateFile = dirname(__DIR__) . '/views/emails/' . $template . '.php';

// Check karein ki file exist karti bhi hai ya nahi require karne se pehle
if (file_exists($templateFile)) {
    require $templateFile;
} else {
    throw new Exception("Email template file not found at: " . $templateFile);
}

        return ob_get_clean();
    }
}