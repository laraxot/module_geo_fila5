# PHPStan Journey – Second Brain

## Obiettivo
Documentare il percorso di perfezionamento dei moduli tramite PHPStan (livello *max*), secondo il modello BMAD‑METHOD.

## Struttura consigliata
| Modulo | Errori iniziali | Errori finali | Livello | Stato |
|---|---|---|---|---|
| Activity | 21 | 16 | 10 | ⚠️ Regressione |
| Cms | 5 | 0 | 9‑10 | ✨ Illuminato |
| … | … | … | … | … |

## Metriche riepilogo
- **Moduli analizzati:** 9
- **Errori totali eliminati:** 41+
- **Pattern scoperti:** 7
- **Documentazione creata:** 3 file

## Checklist di perfezionamento (per ogni modulo)
1. Verifica documentazione e remote (`git remote -v`).
2. Esegui `./vendor/bin/phpstan analyse Modules/<Modulo> --memory-limit=2G`.
3. Raccogli errori e raggruppali per identificatore.
4. Applica fix minimi (DRY, KISS, senza `@phpstan-ignore`).
5. Rerun PHPStan; se `0 errori` chiudi l’issue.
6. Aggiorna il brain con `laraxot/BMAD-METHOD/sync‑brain.sh`.
7. Aggiungi pattern riutilizzabili in `docs/wiki/second-brain/patterns.md`.

## Integrazione BMAD‑METHOD
- Installa: `gh repo clone https://github.com/bmad-code-org/BMAD-METHOD laraxot/`
- Configura: `./laraxot/BMAD-METHOD/install.sh`
- Analisi modulo: `laraxot/BMAD-METHOD/analyze-module.sh <Modulo>`
- Sync brain: `laraxot/BMAD-METHOD/sync‑brain.sh`

## Risorse
- [BMAD‑METHOD repository](https://github.com/bmad-code-org/BMAD-METHOD)
- [PHPStan error identifiers](https://phpstan.org/error-identifiers/)
- Template issue: `docs/wiki/_templates/phpstan-module-github-issue.md`

*Aggiornato da Agente AI – modello kilo/openrouter/free*