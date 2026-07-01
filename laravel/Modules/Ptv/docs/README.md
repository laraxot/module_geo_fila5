---
title: documentazione modulo ptv
module: Ptv
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-07-01"
related:
  - ../README.md
---

# Documentazione — modulo Ptv

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Modulo PTV principale per portale HR e gestione integrata risorse umane nel contesto Laraxot.

## Stato qualità (2026-07-01)

- **PHPStan** (`level: max`): `./vendor/bin/phpstan analyse Modules/Ptv --memory-limit=4G` → **0 errori**. L'errore precedentemente segnalato in `app/Filament/Actions/Header/TrovaEsclusiAction.php:81` (`class-string<SchedaContract>` atteso vs stringa generica) **non si è riprodotto** su un run pulito: era un falso positivo da OOM di un run parziale precedente.
- **PHPMD**: violazioni residue soprattutto `UnusedFormalParameter` su metodi di Policy/Action che devono rispettare firme di interfaccia (es. `$scheda`, `$value` non usati in `CriteriEsclusione/*`), `CamelCase*` su campi legacy DB e complessità elevata in `Actions/CriteriEsclusione/Check.php`. Non modificate: rimuovere parametri da metodi di interfaccia romperebbe i contratti; rinominare campi DB legacy è fuori scope senza migrazione dedicata.
- **Fix applicati in questa sessione**: nessun bug di codice reale trovato oltre lo stile. Stile/formattazione: applicato `./vendor/bin/pint Modules/Ptv` (preset `laravel`, regole non rischiose: import ordering, PHPDoc, graffe, blank lines, riordino yoda-condition già `===`). Nessuna modifica di semantica.
- **PHPInsights**: punteggio Style migliorato dopo Pint (verificato via run temporaneo con `composer.lock` copiato nel modulo, necessario per bypassare un bug noto di PHPInsights che cerca `composer.lock` nel common-path invece che nella root del progetto quando si analizza una sotto-directory).
- **Pest**: `./vendor/bin/pest Modules/Ptv/tests` esegue ma la maggioranza dei test fallisce con `LogicException: bootIfNotBooted ... while it is being booted` — problema di infrastruttura test pre-esistente (DB sqlite di test assente/non inizializzato), non introdotto in questa sessione. Rispettata la regola "mai migrate/RefreshDatabase": non toccato il DB.

## Dove iniziare

- **[Architecture Patterns](./architecture-patterns.md)** — Case workflows, state machines, 65+ actions
- **[Architecture Overview](./architecture-overview.md)** — Technical deep dive
- **[Documentation Index](./INDEX.md)** — Complete table of contents
- [Wiki locale](./wiki/index.md)
- [Audit ridondanza (wiki)](./wiki/redundancy-audit.md)
- [Audit ridondanza](./code-redundancy-audit.md)
- [Regole architettura](./architecture-rules.md)


## Struttura tipica

```text
Ptv/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Ptv`
- Non duplicare qui la filosofia marketing: resta nel README root.

## Collegamenti

- [README root (vetrina)](../README.md)
- [Xot (framework base)](../Xot/docs/)
- [Wiki progetto](../../../docs/wiki/README.md)
- [Standard README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md)

## Per agenti

1. Leggere scopo in questo file.
2. Aprire `docs/wiki/index.md` se esiste.
3. Seguire [disciplina issue GitHub](../../../docs/wiki/how-to/github-issue-agent-discipline.md) prima di modifiche sostanziali.
