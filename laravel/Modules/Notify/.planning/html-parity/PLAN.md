# HTML Parity Phase - Piano di Esecuzione

## Obiettivo
Raggiungere il 90% di parità struttura HTML tra reference (design-comuni-pagine-statiche) e implementazione locale (FixCity).

## Contesto
- **Reference**: https://italia.github.io/design-comuni-pagine-statiche/sito/<pagina>.html
- **Locale**: http://127.0.0.1:8000/it/tests/<pagina>
- **Blade**: `laravel/Themes/Sixteen/resources/views/pages/tests/[slug].blade.php`
- **JSON**: `laravel/config/local/fixcity/database/content/pages/tests.<pagina>.json`

## Requisiti Chiave

### 1. Confronto HTML
- Estraggo il BODY HTML puro (no `<script>`, no `<style>`, solo markup+text)
- Confronto elemento per elemento la struttura (tag, attributi, classi)
- Genero report dettagliato con:
  - ✅ Elementi identici
  - ❌ Elementi mancanti
  - ⚠️ Elementi con differenze
  - 📊 Parity score (es. 87% match)
- Salvo output in `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/`

### 2. Regole di Traduzione
- Formato: `fixcity::context.collection.element.type` (5 livelli)
- ❌ SBAGLIATO: `fixcity::context.element.type` (manca collection)
- ❌ SBAGLIATO: `SEGNALAZIONE::SEGNALAZIONE.ELENCO.TITLE` (namespace errato)
- ✅ CORRETTO: `fixcity::segnalazione.fields.title.label`
- ✅ CORRETTO: `fixcity::rating.fields.star.5.label`

### 3. Bootstrap Italia
- ✅ Bootstrap class names SI nel HTML (row, col-12, btn, card, ecc.) per HTML parity
- ❌ Bootstrap CSS/JS NO (MAI caricare file)
- ✅ TailwindCSS @apply per styling (style-apply.css)
- Differenza chiave: Reference usa Bootstrap Italia CSS/JS, noi usiamo TailwindCSS + Alpine.js

### 4. Semantic HTML
- Usare SEMPRE gli stessi tag semantici: `<nav>`, `<ol>`, `<li>`, ecc.
- Classi CSS devono essere le stesse (Bootstrap classes per parity)

### 5. Blade Philosophy
- Utilizzare `<x-layouts.app>` NON `<x-layouts.design-comuni>`
- Stessa filosofia di `laravel/Themes/Sixteen/resources/views/pages/[container0]/[slug].blade.php`
- Niente hardcoded strings, tutto tradotto
- Multilingua: usare `app()->getLocale()` e traduzioni

### 6. Struttura bashscripts
- `bashscripts/` è AGNOSTICO (usato in molti progetti)
- Script HTML: `bashscripts/html/`
- Documentazione script: `bashscripts/docs/` con indici
- Output confronto: `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/`
- Documentazione page-specific: `laravel/Themes/Sixteen/docs/prompts/<pagina>/`

### 7. Git
- Con git andiamo solo AVANTI
- NON ripristinare mai vecchie versioni
- Studiare vecchie versioni per contesto, MAI fare revert
- Git commit solo alla fine di una fase intera

## Fasi di Esecuzione

### Fase 1: Organizzazione Script (bashscripts/html/)
1. ✅ Verificare struttura esistente
2. Spostare `compare-html-body.sh` → `bashscripts/html/compare-html-body.sh`
3. Spostare `compare-html-similarity.py` → `bashscripts/html/compare-html-similarity.py`
4. Creare `bashscripts/html/html-structure-compare.sh` (wrapper principale)
5. Aggiornare tutti i percorsi negli script

### Fase 2: Miglioramento Script
1. Estrazione BODY HTML (no script, no style)
2. Confronto elemento per elemento (tag, attributi, classi, id)
3. Calcolo parity score (%)
4. Generazione report dettagliato
5. Salvataggio output in `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/`

### Fase 3: Documentazione (bashscripts/docs/)
1. Creare `bashscripts/docs/html-comparison-tools.md`
2. Aggiornare `bashscripts/docs/00-INDEX.md` con link a html-comparison-tools
3. Creare indici bidirezionali
4. Documentare utilizzo, esempi, output

### Fase 4: Testing e Validazione
1. Testare script su `segnalazione-dettaglio`
2. Verificare output report
3. Correggere eventuali bug
4. Validare parity score

### Fase 5: Utilizzo Script
1. Eseguire confronto per tutte le pagine
2. Generare report completi
3. Spostare file temporanei in percorsi corretti
4. Aggiornare documentazione Sixteen/docs

## Output Attesi

### Script
- `bashscripts/html/html-structure-compare.sh` (wrapper principale)
- `bashscripts/html/compare-html-body.py` (Python, più robusto)
- `bashscripts/html/compare-html-similarity.py` (similarità token-based)

### Documentazione
- `bashscripts/docs/html-comparison-tools.md` (guida completa)
- `bashscripts/docs/html-comparison-index.md` (indice)

### Output
- `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/report.md`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/reference_body.html`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/local_body.html`
- `laravel/Themes/Sixteen/docs/body-structure-comparison/<pagina>/diff.json`

### File da Spostare
- `/var/www/_bases/base_fixcity_fila5/local_segnalazioni.html` → `laravel/Themes/Sixteen/docs/prompts/tests/local_segnalazioni.html`

## Criteri di Accettazione
- [ ] Script funzionante e documentato
- [ ] Output salvato nei percorsi corretti
- [ ] bashscripts agnostico (nessun riferimento diretto al tema)
- [ ] Documentazione completa con indici
- [ ] Parity score ≥90% per tutte le pagine
- [ ] Traduzioni formato 5 livelli
- [ ] Nessun hardcoded string nelle blade
