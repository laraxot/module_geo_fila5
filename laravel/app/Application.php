<?php

/**
 * ---.
 */
declare(strict_types=1);

namespace App;

use Safe\Exceptions\FilesystemException;

//use function Safe\realpath;

class Application extends \Illuminate\Foundation\Application
{
    public function publicPath($path = ''): string
    {
        $publicRoot = $this->basePath.'/../public_html';
        $relativePath = ltrim((string) $path, '/\\');
        $candidate = $publicRoot.'/'.$relativePath;
        $normalizedCandidate = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $candidate);
        return $normalizedCandidate;
        
    }
}
