# story 7-50: wizard schemas overview alignment

## stato

ready-for-dev

## richiesta

Riallineare il widget alla documentazione Filament Schemas v5 e correggere la scelta componenti read-only nel wizard.

## intervento

- rimosso uso di componenti Infolists dai metodi schema del form;
- adottati componenti Schemas (`Text`, `Section`, `Grid`);
- corretto import `Action` (`Filament\Actions\Action`);
- mantenuta parity visuale e semantica sugli step.

## verifica

- lint PHP widget: OK
- smoke endpoint wizard: `200`
- smoke endpoint step 2: `200`

## impatto

- miglior coerenza architetturale con Filament v5 Schemas;
- riduzione rischio regressioni namespace/runtime da mix cross-package.
