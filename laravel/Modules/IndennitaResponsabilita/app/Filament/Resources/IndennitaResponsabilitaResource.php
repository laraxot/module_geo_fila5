<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Filament\Resources;

use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\CompilaIndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\SendMailIndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages\ListSchedaLogActivities;
use Override;
use Illuminate\Support\Arr;
use Filament\Forms\Components\TextInput;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\Xot\Filament\Resources\XotBaseResource;
use Modules\Ptv\Filament\Forms\Components\SelectValutatore;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Filament\Resources\IndennitaResponsabilitaResource\Pages;

class IndennitaResponsabilitaResource extends XotBaseResource
{
    protected static ?string $model = IndennitaResponsabilita::class;

    public static function getFormSchema(): array
    {
        
        return [
            'matr' => TextInput::make('matr')->required(),
            'cognome' => TextInput::make('cognome')->required(),
            'nome' => TextInput::make('nome')->required(),
            'email' => TextInput::make('email')->email()->required(),
            'valutatore_id' => SelectValutatore::make('valutatore_id')->where(function (IndennitaResponsabilita $record) {
                return [
                    'anno' => $record->anno,
                ];
            }),
        ];
    }

    
    

    
    public static function getPages(): array
    {
        return [
            ...parent::getPages(),
            'compila' => CompilaIndennitaResponsabilita::route('/{record}/compila'),
            'send-mail' => SendMailIndennitaResponsabilita::route('/send/mail'),
            'log-activity' => ListSchedaLogActivities::route('/{record}/activities'),
        ];
    }

    public static function getXlsFields(array $data): array
    {
        $anno=Arr::get($data, 'anno/valutatore.anno',null);
        if($anno==null){
            return [];
        }
        //$ratings=Rating::withExtraAttributes(['anno' => $anno])->get();

        return [
            'matr',
            'cognome',
            'nome',
            'email',/*
            'valutatore_id',
            'ratings.3',
            'ratings.3.value',
            'ratings.3.pivot.value',
            */
        ];
    }
}
