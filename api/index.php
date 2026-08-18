<?php
// api/index.php - Vercel Router & Entrypoint for Cippy Dimsum POS

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (strpos($uri, '/api/pos.php') !== false) {
    require __DIR__ . '/pos.php';
} elseif (strpos($uri, '/api/menu_crud.php') !== false) {
    require __DIR__ . '/menu_crud.php';
} elseif ($uri === '/reports.php' || $uri === '/reports') {
    require __DIR__ . '/../reports.php';
} elseif ($uri === '/menu.php' || $uri === '/menu') {
    require __DIR__ . '/../menu.php';
} else {
    require __DIR__ . '/../index.php';
}
