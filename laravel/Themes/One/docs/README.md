# Documentazione del Tema One

Questa cartella contiene documentazione interna per il tema One.

## Struttura e Personalizzazione
- `app/`: componenti PHP e Blade specifici del tema
- `resources/`: viste, CSS e JS basati su Tailwind + Vite
- `public/`: asset compilati
- `lang/`: file di traduzione dedicati

Per personalizzare:
1. Aggiornare componenti/layout in `resources/views/`
2. Modificare gli stili in `resources/css/`
3. Eseguire `npm run build` (o `npm run dev`) per rigenerare gli asset

## UI/UX Patterns
- [Readonly Field Styling](./readonly-field-styling.md) - Pattern per campi readonly/calcolati nei form Filament

Ricordare di documentare ogni variante o layout personalizzato nella cartella `docs/`.

## 🤖 AI Development Tools & Skills
- [Claude Context (Laravel)](../../../CLAUDE.md)
- [AI Agents Guide](../../../../AGENTS.md)
- [Cursor Rules & Skills](../../../../.cursor/README.md)
- [Skills di progetto](../../../../.cursor/skills/)

### Metodo di lavoro (BMAD + Laraxot)

Per le attività sul tema One si segue un flusso coerente con il metodo BMAD e le regole Laraxot:

1. **Analisi**: chiarire scopo della modifica (business logic, pagina, utente finale).
2. **Design leggero**: scegliere la soluzione UI/UX più semplice che riusa pattern e componenti esistenti.
3. **Implementazione**: applicare cambiamenti minimi, leggibili, coerenti con Tailwind e i layout del tema.
4. **Verifica**: controllare resa visiva (anche responsive) ed eseguire i comandi di build/lint necessari.
5. **Documentazione**: aggiornare/creare (se manca) la pagina `docs` pertinente descrivendo scopo, decisioni e impatti.

## 🔁 CI & Semantic Versioning
Il tema include il workflow locale in `.github/workflows/semantic-versioning.yml`.
Include anche l’attestazione build provenance con `actions/attest-build-provenance@v3`.
Workflow root progetto: `/.github/workflows/*.yml`.

## 🚀 Release su GitHub
Le release sono basate su tag Git e possono includere release notes generate automaticamente.
Workflow locale: `.github/workflows/release.yml`.


## 📄 License & Authors

**Authors:**
- Marco Sottana <marco.sottana@gmail.com>

**License:** MIT
