---
title: documentazione modulo questionari
module: Questionari
type: index
status: approved
tags: [documentation, readme, modulo, second-brain]
updated: "2026-05-27"
related:
  - ../README.md
---

# Documentazione — modulo Questionari

> **Mappa knowledge base locale.** Il [README in root](../README.md) è la vetrina (valore, release, onboarding); questo file indica **dove** trovare regole, wiki e audit per chi sviluppa o per gli agenti AI.

## Scopo

Questionnaires and surveys module for the Laraxot ecosystem: LimeSurvey integration, data collection, employee feedback, and evaluations.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [Audit ridondanza](./code-redundancy-audit.md)
- [Regole architettura](./architecture-rules.md)
- [Disciplina agenti](./agent-edit-discipline.md)


## Struttura tipica

```text
Questionari/
├── README.md          ← vetrina (root package)
├── docs/
│   ├── README.md      ← questo indice
│   └── wiki/          ← second brain (se presente)
├── app/ o resources/
└── composer.json
```

## Namespace / confini

- Namespace: `Modules\Questionari`
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
