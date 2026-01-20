<?php

declare(strict_types=1);

namespace Modules\Performance\Filament\Resources;

use Illuminate\Support\Arr;
use Modules\Lang\Actions\SaveTransAction;
use Modules\Performance\Filament\Resources\IndividualePoResource\Pages\CreateIndividualePo;
use Modules\Performance\Filament\Resources\IndividualePoResource\Pages\EditIndividualePo;
use Modules\Performance\Filament\Resources\IndividualePoResource\Pages\FillOutTheForm;
use Modules\Performance\Filament\Resources\IndividualePoResource\Pages\ListIndividualePos;
use Modules\Performance\Models\CriteriValutazione;
use Modules\Performance\Models\IndividualePo;
use Modules\Xot\Actions\GetTransKeyAction;
use Override;

use function Safe\date;

class IndividualePoResource extends IndividualeResource
{
    protected static ?string $model = IndividualePo::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-rectangle-stack';

    #[Override]
    public static function getRelations(): array
    {
        return [
        ];
    }

    #[Override]
    public static function getPages(): array
    {
        return [
            'index' => ListIndividualePos::route('/'),
            'create' => CreateIndividualePo::route('/create'),
            'edit' => EditIndividualePo::route('/{record}/edit'),
            'fill_out_the_form' => FillOutTheForm::route('/{record}/fill'),
        ];
    }

    #[Override]
    public static function getXlsFields(array $data): array
    {
        $anno = Arr::get($data, 'stabi_repar_anno.anno', intval(date('Y')) - 1);
        $criteri = CriteriValutazione::where('anno', $anno)
            ->where('post_type', 'po')
            ->orderBy('posizione')
            ->get();

        $fields = [
            'id',
            'ente',
            'matr',
            'cognome',
            'nome',
            'email',
            'dal',
            'al',
        ];
        $transKey = app(GetTransKeyAction::class)->execute(static::class);
        $trans = trans($transKey);

        foreach ($criteri as $criterio) {
            $fields[] = $criterio->nome;
            Arr::set($trans, 'fields.'.$criterio->nome, $criterio->label);
        }
        app(SaveTransAction::class)->execute($transKey, $trans);
        $fields[] = 'excellence';
        $fields[] = 'totale_punteggio';

        return $fields;
    }
}
