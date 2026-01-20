<?php

/**
 * ---.
 */
declare(strict_types=1);

namespace App;

use Safe\Exceptions\FilesystemException;

use function Safe\realpath;

class Application extends \Illuminate\Foundation\Application
{
    public function publicPath($path = ''): string
    {
        $publicRoot = $this->basePath.'/../public_html';
        $relativePath = ltrim((string) $path, '/\\');
        $candidate = $publicRoot.'/'.($relativePath === '' ? '' : $relativePath);
        $normalizedCandidate = str_replace(['/', '\\'], [DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR], $candidate);

        try {
            return realpath($normalizedCandidate);
        } catch (FilesystemException $exception) {
            // Try fallback root resolution below.
        }

        try {
            $resolvedRoot = realpath($publicRoot);
            if ($relativePath === '') {
                return $resolvedRoot;
            }

            return rtrim($resolvedRoot, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR.$relativePath;
        } catch (FilesystemException $exception) {
            // Fall through to the normalized candidate.
        }

        return $normalizedCandidate;
    }
}
