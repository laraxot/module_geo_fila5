<?php

declare(strict_types=1);

?>
<div>
@if (isset($profile) && $profile->isSuperAdmin())
    <x-filament::icon-button icon="user-superadmin" class="h-5 w-5 text-gray-500 dark:text-gray-400 transition-transform duration-200 hover:scale-110"
        tooltip="Super Admin" wire:click="toggleSuperAdmin" />
@endif
@if (isset($profile) && $profile->isNegateSuperAdmin())
    <x-filament::icon-button icon="user-negate-superadmin" class="h-5 w-5 text-gray-500 dark:text-gray-400 transition-all duration-200 hover:scale-110 hover:text-danger-600 dark:hover:text-danger-400"
        tooltip="Negate Super Admin" wire:click="toggleSuperAdmin" />
@endif
</div>
