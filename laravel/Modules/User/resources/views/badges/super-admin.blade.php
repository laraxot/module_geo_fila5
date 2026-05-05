<?php

declare(strict_types=1);

?>
@if (isset($_profile) && $_profile->isSuperAdmin())
    <x-filament::icon-button icon="user-superadmin" class="h-5 w-5 text-gray-500 dark:text-gray-400 transition-transform duration-200 hover:scale-110"
        tooltip="Super Admin" />
@endif
