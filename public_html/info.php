<?php

declare(strict_types=1);
if(!isset($_GET['pwd'])) {
    echo 'Access denied';
    exit;
}

if ('123456' !== $_GET['pwd']) {
    echo 'Access denied';
    exit;
}

phpinfo();
