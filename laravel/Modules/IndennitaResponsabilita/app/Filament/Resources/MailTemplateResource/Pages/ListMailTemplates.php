<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources\MailTemplateResource\Pages;

use Modules\IndennitaResponsabilita\Filament\Resources\MailTemplateResource;
use Modules\Notify\Filament\Resources\MailTemplateResource\Pages\ListMailTemplates as NotifyListMailTemplates;

class ListMailTemplates extends NotifyListMailTemplates
{
    public static string $resource = MailTemplateResource::class;
}
