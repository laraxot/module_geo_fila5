# Struttura dei prompt

## Scopo
I prompt definiscono regole operative riutilizzabili tra progetti. Devono essere portabili, coerenti e senza riferimenti al progetto specifico.

## Regole principali
- **Posizione**: `bashscripts/tools/prompts/`.
- **Formato**: Markdown consentito; se un prompt richiede una singola riga, dichiararlo esplicitamente nel file.
- **Portabilita'**: vietati percorsi assoluti e nomi di progetto; usare segnaposto (`<project_root>`, `<module>`, `<theme>`).
- **Coerenza**: allineare i prompt alle regole e alla documentazione dei moduli/temi.

## Processo di aggiornamento
1. Studiare la documentazione del modulo/tema coinvolto.
2. Aggiornare il prompt con esempi generici e path relativi.
3. Aggiornare le regole/memorie pertinenti se richiesto.
4. Verificare che i prompt restino project-agnostic.

## Collegamenti
- [regole prompt consolidate](./consolidated/prompt-rules.md)
- [organizzazione bashscripts](./bashscripts-organization-1.md)
- [regole documentazione](./consolidated/documentation-rules.md)
- [prompts consolidati](./consolidated/prompts.md)
- [indice documentazione](./00-index.md)
