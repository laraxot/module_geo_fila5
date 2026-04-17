<?php

declare(strict_types=1);

namespace Modules\Ptv\Filament\Resources\SchedaResource\Pages;

use Carbon\Carbon;
use Filament\Facades\Filament;
use Filament\Notifications\Notification;
use Filament\Pages\Actions;
use Filament\Pages\Contracts\HasFormActions;
use Filament\Resources\Pages\Concerns\HasRelationManagers;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Modules\Ptv\Filament\Resources\SchedaResource;
use Modules\Xot\Actions\GetViewAction;
use Modules\Xot\Actions\View\GetViewByModelClassAction;
use Modules\Xot\Filament\Resources\Pages\XotBasePage;

// class CompilaCondizioniLavoro extends \Modules\Xot\Filament\Resources\Pages\XotBaseEditRecord {
/**
 * Custom form implementation for compiling evaluation sheets
 * Uses form_data array instead of Filament form component
 */
class CompilaScheda extends BaseCompilaScheda
{
    
}
