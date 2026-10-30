---
title: "Niente testi fissi nelle Blade del modulo Geo (multilingua it/en/de/es)"
type: story
status: implemented
module: Geo
updated: 2026-10-30
tags: [i18n, blade, multilingua]
---

# Niente testi fissi nelle Blade del modulo Geo

## Scopo

Il sito risponde in italiano, inglese, tedesco e spagnolo: un testo scritto dentro una Blade esce uguale in ogni lingua. Il `fallback_locale` e' `it`, quindi una chiave mancante in `en`/`de`/`es` non da' errore e mostra l'italiano.

## Regola operativa

- Ogni testo visibile passa da `{{ __('geo::contesto.collezione.chiave.tipo') }}`: cinque elementi, dove `contesto` e' il nome del file lingua e `tipo` il genere di testo (`label`, `title`, `description`, `placeholder`, `tooltip`, `helper_text`, `message`, `aria_label`, `alt`; [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md)). Mai la frase come chiave: nessun file la traduce, e il traduttore ignora `['default' => ...]`.
- La stringa va in `Modules/Geo/lang/{it,en,de,es}/<contesto>.php`, con le stesse chiavi e gli stessi `:parametri` nelle quattro lingue. `it` e' l'originale; `en`, `de`, `es` sono traduzioni vere.
- Vale anche per `aria-label`, `placeholder`, `title`, `alt` e, in PHP, per `->label()`, `->placeholder()`, `->tooltip()`, `->helperText()`.
- Frasi con variabili: segnaposto `:param` e `trans_choice` per i plurali; il markup resta nella Blade e la frase si spezza solo dove serve.
- Link a pagine CMS: niente `href="/it/..."`, niente `url('/...')`, niente nomi di rotta inventati per pagina. Si usa la rotta generica della shell Folio, `route('container0.view', ['container0' => 'area-personale', 'slug0' => 'notifiche'])`: il prefisso lingua lo aggiunge Folio. L'indice ha un nome diverso per tema (`container0` in Two e Meetup, `container0.index` in Sixteen e TwentyOne): una vista di modulo condivisa tra temi usa `view` oppure riceve l'URL dal chiamante. I nomi Folio veri (`home`, `login`, `logout`) restano validi.
- Non sono errori: marchi e nomi propri, sigle, coordinate e numeri, valori che arrivano dal modello.

## Cosa e' stato fatto

- Rilevatore `bashscripts/tools/i18n/find-hardcoded-blade-text.py` sul modulo: da 261 occorrenze in 17 file a 212 in 13 file (stesso strumento, commit di partenza contro stato attuale). Di queste, 183 sono nel sito statico di terzi descritto sotto.
- 9 Blade convertite: home, widget della mappa, ricerca indirizzi per categoria, scheda luogo, widget latitudine e longitudine, mappa Webbingbrasil, selettore di coordinate.
- Creati file lingua in `it`, `en`, `de`, `es`: `home`, `geo_map_widget`, `form_search_address_categories` (32 chiavi per lingua in totale); `lat_lng`, `place`, `webbingbrasil-map` e `coordinate-picker` completati nelle lingue mancanti (`de`, `es`).

## Residui dichiarati (212 occorrenze)

| Categoria | N |
|---|---:|
| Sito statico di terzi non instradato (copia vendored in tedesco, licenza MIT) e una copia della sua barra laterale: non e' interfaccia del progetto | 183 |
| Stub Laravel e scaffold nWidart non instradati | 15 |
| Pagine di sviluppo e dati finti (debug, esempi) | 10 |
| Direttive Blade e binding Alpine: falsi positivi | 3 |
| Marchio | 1 |

Testi in PHP non toccati: circa 14 chiamate `->label()`, `->placeholder()`, `->tooltip()` con testo fisso (conteggio euristico).

## Limiti

- Nessuna verifica a video: chiavi e compilazione sono controllate in modo statico.
- Il sito statico di terzi non e' stato tradotto per scelta: non e' parte dell'interfaccia del progetto.
- Una parte delle chiavi (`home`, `geo_map_widget`, `form_search_address_categories`, scheda luogo, widget coordinate) e' nata con tre o quattro elementi invece di cinque: funziona in tutte le lingue ma non e' stata rinominata.
- Verifica del 2026-10-30: PHPStan sui moduli senza errori, compilazione Blade dei file convertiti senza errori, nessuna chiave usata dalla campagna manca in `it`, `en`, `de`, `es`.

## Riferimenti

Metodo e regola completa: [story del tema Two](../../../../Themes/Two/docs/stories/blade-i18n-no-hardcoded-text.story.md); protocollo a cinque elementi: [regola 008](../../../../../docs/wiki/rules/008-translation-5-level-protocol.md). Il dettaglio per file e' nel repo privato di audit.
