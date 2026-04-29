# Validazione Story 7-1-unified-segnalazione-crea-ticket-wizard

**Story**: `7-1-unified-segnalazione-crea-ticket-wizard`  
**File story**: `_bmad-output/implementation-artifacts/7-1-unified-segnalazione-crea-ticket-wizard.md`  
**Esito**: ✅ *valida per dev-story* (con correzioni consigliate sotto)

## Contesto verificato (anti “reinventare la ruota”)

Questa story NON parte da zero: gli artefatti chiave **esistono già** nel repo.

- **Widget**: `laravel/Modules/Fixcity/app/Filament/Widgets/CreateTicketWizardWidget.php` (già implementato)  
- **View widget**: `laravel/Modules/Fixcity/resources/views/filament/widgets/ticket-create-wizard.blade.php` (già presente)  
- **Blocco tema**: `laravel/Themes/Sixteen/resources/views/components/blocks/tests/segnalazione-crea.blade.php` (già presente, monta Livewire widget)  
- **CMS JSON pagina**: `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json` (già presente, include `issue_types`, placeholders, testi privacy, contatti, ecc.)  
- **Docs modulo**:  
  - `laravel/Modules/Fixcity/docs/ticket-wizard-frontoffice.md` (decisione: 3 step + submit step 3 + conferma separata)  
  - `laravel/Modules/Fixcity/docs/CreateTicketWizardWidget.md` (overview, naming, flow)

**Implicazione**: l’implementazione dovrebbe essere principalmente **verifica + allineamenti/parità** (non “creazione”).

## 🚨 Critical issues (da correggere prima di dev-story)

1. **Scope ambiguo su “creare nuova pagina / json / blocchi”**  
   La story dice “creare il JSON se mancante”, ma nel repo esiste già `tests.segnalazione-crea.json` + blocco Blade + widget.  
   - **Rischio**: il dev agent duplica o sostituisce la pagina/blocco e introduce regressioni.
   - **Fix suggerito**: cambiare Task 1 in “verificare e correggere wiring e contenuto esistente” (no creazione salvo assenza reale).

2. **AC1 troppo generica sul path**  
   AC1 parla di “path equivalente”. Qui il path è noto e già in docs.
   - **Fix suggerito**: rendere AC1 assertiva: *“il file `laravel/config/local/fixcity/database/content/pages/tests.segnalazione-crea.json` esiste e viene caricato dalla pagina `/it/tests/segnalazione-crea`”*.

3. **Testing non abbastanza prescrittivo**  
   È indicato “test manuale”, ma manca un criterio minimo oggettivo (es. presenza widget e stepper).
   - **Fix suggerito**: aggiungere 2–3 check “must pass” (UI e redirect) e, se presente infrastruttura, 1 test Pest/HTTP che verifica che la route risponda e contenga marker prevedibile (es. wrapper `.segnalazione-crea-wrapper`).

## ⚡ Enhancement opportunities (migliorano esito e riducono errori)

1. **Documentare il “perché” del naming** direttamente in story (Ticket vs Segnalazione)  
   È già citato, ma conviene esplicitare: “Segnalazione” solo in chiavi i18n.

2. **Chiarire dove vive la parità**  
   La parità “step 1 come segnalazione-01-privacy” dovrebbe specificare *cosa* confrontare:
   - layout/hero/stepper/checkbox privacy
   - copy/struttura blocchi principali

3. **Coordinamento multi-agente**  
   Già presente; consigliato aggiungere una nota: evitare toccare contemporaneamente `ticket-create-wizard.blade.php` e css parity nello stesso momento se altri agenti sono in corso.

## ✨ LLM optimization (chiarezza e token-efficiency)

- Sostituire frasi condizionali (“se mancanti”) con fatti già verificati (“sono presenti, verificare che…”).
- Mettere i path *esatti* in Acceptance Criteria (1 riga per path, senza alternative).

## Raccomandazione

Procedere con `bmad-dev-story`, ma prima **ritoccare la story 7-1** per:

- rendere esplicito che **tutti i file esistono già**
- trasformare le Task in **verifica + bugfix/parity work**, evitando creazione duplicata

---

## Aggiornamento (applicato)

Le correzioni **critical** sopra sono state incorporate in:

- `_bmad-output/implementation-artifacts/7-1-unified-segnalazione-crea-ticket-wizard.md`

