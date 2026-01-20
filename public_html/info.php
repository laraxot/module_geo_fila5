<?php

declare(strict_types=1);

if ('123456' !== $_GET['pwd']) {
    echo 'Access denied';
    exit;
}

phpinfo();
