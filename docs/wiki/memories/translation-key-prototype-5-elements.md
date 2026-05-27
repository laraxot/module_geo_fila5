---
title: "Translation key prototype — esattamente 5 elementi"
type: "memory"
tags: [translation, i18n, laravel, prototype, rule]
module: "root"
created: 2026-05-26
updated: 2026-05-26
---

# Translation key prototype — esattamente 5 elementi

> **Regola assoluta.** Ogni chiamata `__('<key>')` deve seguire il prototipo:
>
> **`<namespace>::<contesto>.<collezione>.<item>.<type>`**
>
> Totale: **5 elementi** (namespace + 4 segmenti dopo `::`). Sinonimi accettati:
> - `<contesto>` = `<attore>` (chi/dove)
> - `<item>` = `<chiave>` (cosa)
> - `<type>` = `<tipo>` (ruolo del testo: `label`, `text`, `placeholder`, `helper_text`, `description`, `tooltip`, `heading`, ...)

## Conteggio

Conta `<namespace>` + i segmenti separati da `.` dopo `::`. Il `::` non è un elemento, è il separatore namespace.

| Chiave | Elementi | Verdetto |
|---|---|---|
| `user::auth.register.submit` | 4 (user + auth + register + submit) | ❌ manca `<type>` |
| `user::auth.register.submit.text` | 5 | ✅ |
| `user::auth.register.page.kicker.label` | 6 | ❌ un livello in più (probabile collisione `register` + `page`) |
| `user::widgets.edit_user.actions.save.label` | 6 | ❌ stesso pattern, doppia collezione |
| `user::teams.actions.attach.modal.heading` | 6 | ❌ idem |

## Pattern di violazione comune (da NON usare)

```
namespace :: ctx . coll1 . coll2 . item . type    ← 6 elementi
namespace :: ctx . coll . item                    ← 4 elementi (manca type)
namespace :: ctx . item                           ← 3 elementi (manca collezione e type)
```

Quando senti la tentazione di aggiungere un livello "intermedio" (es. `.page.`, `.modal.`, `.sections.`) → **fermati**: stai sfondando il prototipo. Riorganizza i nomi dentro 4 segmenti.

## Esempi corretti

```php
__('user::auth.register.submit.text')          // contesto=auth, collezione=register, item=submit, type=text
__('user::auth.register.title.text')           // contesto=auth, collezione=register, item=title, type=text
__('user::auth.login.email.placeholder')       // type=placeholder per il campo email
__('user::profile.fields.email.label')         // contesto=profile, collezione=fields
__('xot::actions.delete.confirm.heading')      // type=heading per modal
```

## Esempi di refactor (6 → 5)

| Sbagliato (6) | Riorganizzato (5) |
|---|---|
| `user::widgets.edit_user.actions.save.label` | `user::edit_user.actions.save.label` (collezione = `edit_user`, contesto già implicito nel namespace `user`) |
| `user::teams.actions.attach.modal.heading` | `user::teams.attach_modal.heading.label` (collezione = `teams`, item = `attach_modal`, type = `heading`) — ma serve type finale `label`/`text` → meglio `user::teams.attach.modal_heading.text` |
| `user::auth.register.page.kicker.label` | `user::auth.register.kicker.label` (drop `page` ridondante con la collezione) |

> Il refactor di una chiave esistente richiede aggiornare **sia** il file `lang/<lng>/<contesto>.php` **sia** tutte le `__()` call-site. Vedi `qmd search "translation refactor"`.

## Casi-limite tollerati

- **Chiave Laravel core** (`auth.failed`, `validation.required`): vive nel namespace globale, 2 elementi. NON è soggetta al prototipo Laraxot perché non è una chiave di modulo.
- **Spatie Translatable** (campi modello): non passa per `__()`, usa il proprio storage JSON. Fuori scope.

## Quality gate

Ogni MR/PR che tocca blade/PHP con `__()` deve passare:

```bash
# Conta i segmenti delle chiavi modulo (esclude core Laravel)
grep -rohnE "__\('[a-z]+::[a-z._-]+'\)" laravel/Modules/ laravel/Themes/ \
  | awk -F"'" '{n=gsub(/[.:]/,"&",$2); print n,$2}' \
  | awk '$1!=5'
```

Se qualcosa esce → violazione del prototipo.

## Riferimenti

- Canonical rule: `docs/wiki/rules/translation-standards.md` §"Prototipo Chiavi Traduzione"
- Documentazione modulo Lang: `laravel/Modules/Lang/docs/`
- Esempio di violazione storica: register-widget.blade.php (corretto il 2026-05-26)

## Vedi anche

- [[filament-no-explicit-labels]] — perché `LangServiceProvider` risolve label di default
- [[response-style-sintetico-conciso-italiano]] — tono per traduzioni italiane
