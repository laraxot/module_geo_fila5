<?php

declare(strict_types=1);

if (! function_exists('getRouteParameters')) {
    /** @return array<string, mixed> */
    function getRouteParameters(): array
    {
        return request()->route()?->parameters() ?? [];
    }
}
