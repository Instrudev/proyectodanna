<?php

class BaseController
{
    protected function render(string $view, array $data = [], array $layout = ['layout/header.php', 'layout/footer.php']): void
    {
        extract($data);
        $baseUrl = BASE_URL;
        $assetUrl = ASSET_URL;
        $cartSession = $_SESSION[CART_SESSION_KEY] ?? [];
        $cartCount = is_array($cartSession) ? array_sum($cartSession) : 0;
        if ($layout[0]) {
            require BASE_PATH . '/views/' . $layout[0];
        }
        require BASE_PATH . '/views/' . $view;
        if ($layout[1]) {
            require BASE_PATH . '/views/' . $layout[1];
        }
    }
}

