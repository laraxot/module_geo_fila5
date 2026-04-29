# Indice Analisi PHPStan – Progetto Laraxot

## Descrizione generale
Questo documento funge da indice centrale e roadmap per l’analisi PHPStan di tutti i moduli del progetto. Ogni modulo mantiene la propria documentazione dettagliata nella cartella `docs/phpstan` del modulo stesso. Qui trovi:
# Analisi PHPStan del Progetto

## Stato Generale
Questo documento serve come indice centrale per l'analisi PHPStan di tutti i moduli del progetto.

## Moduli

### User
- [Documentazione Completa](/docs/modules/user/phpstan.md)
- Stato: 🔄 In Corso
- Livello PHPStan: 1
- Problemi principali:
  - BaseUser.php: proprietà e metodi mancanti
  - Tipizzazione delle relazioni
  - Documentazione PHPDoc incompleta

## Linee Guida
- [Livello 10](/docs/phpstan/PHPSTAN_LEVEL10_LINEE_GUIDA.md)
- [Tipi Generici](/docs/phpstan/PHPSTAN_GENERIC_TYPES.md)
- [Analisi Progressiva](/docs/PHPSTAN-ANALYSIS-PROGRESS.md)

## Best Practices
1. Utilizzare tipizzazione stretta con `declare(strict_types=1)`
2. Documentare tutte le proprietà e metodi con PHPDoc
3. Utilizzare tipi generici per Collection e relazioni
4. Implementare controlli di tipo robusti con `instanceof`
5. Mantenere la documentazione aggiornata

## Collegamenti Utili
- [Contratti](/docs/Contracts.md)
- [Modelli](/docs/Models.md)
- [Analisi del Codice](/docs/analysis.md)

## Prossimi Passi
1. Completare l'analisi del modulo User
2. Estendere l'analisi agli altri moduli
3. Incrementare gradualmente il livello PHPStan
4. Mantenere aggiornata la documentazione

## Indice Analisi PHPStan – Progetto Laraxot

## Descrizione generale
Questo documento funge da indice centrale e roadmap per l'analisi PHPStan di tutti i moduli del progetto. Ogni modulo mantiene la propria documentazione dettagliata nella cartella `docs/phpstan` del modulo stesso. Qui trovi:
- Stato avanzamento analisi
- Collegamenti bidirezionali ai report dei singoli moduli
- Roadmap, epiche, story, filosofia e policy di sviluppo

---

## Indice moduli

### Problema bloccante globale

- **Errore:** Vite manifest not found at: /var/www/html/_bases/base_fixcity_fila5_mono/public_html/assets/chart/manifest.json
- **Effetto:** PHPStan non può analizzare nessun modulo finché non viene generato il manifest degli asset frontend.
- **Soluzione consigliata:**
  - Prima eseguire `npm install` (o `yarn install`) nella root frontend per installare tutte le dipendenze.
  - Poi eseguire `npm run build` (o `yarn build`) per generare il manifest.
  - Se manca il comando vite, significa che le dipendenze non sono installate.
  - Vedi anche la [doc PHPStan modulo Xot](../Modules/Xot/docs/phpstan/level_1.md)


- **Xot**: [Analisi PHPStan livello 1](../Modules/Xot/docs/phpstan/level_1.md)
  - [File corretto: ApplyMetatagToPanelAction.php](../Modules/Xot/app/Actions/Panel/ApplyMetatagToPanelAction.php)
  - [Classe MetatagData](../Modules/Xot/app/Datas/MetatagData.php)

---

## Roadmap & Filosofia
- Migliorare la compatibilità PHPStan livello 9/10 per tutti i moduli
- Aggiornare la documentazione prima di ogni correzione
- Mantenere la coerenza tra docs root e docs dei moduli
- Policy: ogni errore deve essere documentato e collegato sia dal modulo che dall’indice centrale

Per dettagli, consulta anche la documentazione PHPStan del singolo modulo.
- Policy: ogni errore deve essere documentato e collegato sia dal modulo che dall'indice centrale

## Analisi Statica con PHPStan – Livello 7

## 1. Risoluzione errori di configurazione

Se PHPStan si interrompe con un errore relativo a `Larastan\Larastan\Rules\NoEnvCallsOutsideOfConfigRule`, segui questi passaggi:

- Assicurati che la regola sia esclusa tramite `ignoreErrors`:

```neon
ignoreErrors:
    - identifier: larastan.noEnvCallsOutsideOfConfig
```

- Se presente nella sezione `services`, commenta la riga corrispondente:

```neon
# services:
#   - Larastan\Larastan\Rules\NoEnvCallsOutsideOfConfigRule
```

- Aggiorna Larastan e PHPStan all'ultima versione compatibile.
- Rilancia l'analisi dopo ogni modifica.

## 2. Come eseguire l'analisi PHPStan

Lancia il comando:

```bash
phpstan analyse Modules --level=7 --no-progress --memory-limit=1G
```

Assicurati che la configurazione (`phpstan.neon`) punti correttamente alla cartella `Modules`.

## 3. Correzione degli errori PHPStan

- Leggi attentamente ogni messaggio di errore.
- Applica le correzioni suggerite: tipizzazione stretta, PHPDoc, refactoring, rimozione di codice morto.
- Segui le convenzioni Laraxot e le regole del progetto.
- Esegui nuovamente PHPStan per verificare la risoluzione.

## 4. Scopo del progetto (analisi dei moduli)

La struttura della cartella `Modules` evidenzia un'architettura modulare e scalabile. I principali moduli identificati sono:

- **Gestione utenti e permessi:** User, Tenant
- **Gestione contenuti:** Blog, Cms, Media, Seo
- **Funzionalità avanzate:** AI, Chart, Rating, Notify
- **Localizzazione e GDPR:** Lang, Gdpr
- **UI e temi:** UI, Theme

**Obiettivo generale:**

Realizzare una piattaforma web modulare, estendibile e scalabile, che integra gestione contenuti, utenti, workflow, AI e strumenti di amministrazione, seguendo best practice di tipizzazione, sicurezza e manutenibilità.

---

Per dettagli, consulta la documentazione PHPStan del singolo modulo.

Per ogni dubbio o errore non documentato, consulta la documentazione ufficiale di PHPStan e Larastan, oppure segnala la questione al team di sviluppo.
