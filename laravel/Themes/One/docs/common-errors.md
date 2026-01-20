# common errors

## filament form schema senza chiavi (novembre 2025)

- **Sintomo**: nei form Progressioni alcune section risultano vuote o l'ordinamento dei campi è incoerente; PHPStan segnala `array<int, Component>` invece di `array<string, Component>`.
- **Causa**: le risorse Filament del modulo restituivano array numerici; Filament nel tema One non riesce a mappare correttamente le colonne quando il form arriva senza chiavi.
- **Soluzione rapida**: ogni voce del form deve essere referenziata con una chiave stabile (`'general' => Section::make(...)`). Vedi [analisi Progressioni](../../Modules/Progressioni/docs/phpstan-errors-analysis.md#avanzamento--tipizzazione-getformschema-novembre-2025).
- **Impatto tema**: gli stylesheet del tema One assumono la presenza di chiavi per applicare le classi Tailwind dinamiche; senza chiavi, alcuni componenti ricevono classi errate. Dopo l'allineamento delle risorse, non è necessario modificare ulteriormente il tema, ma monitorare questo file per regressioni future.

