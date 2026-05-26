---
title: "Module & Theme Release & Showcase Standard"
type: standard
module: "ptvx-project"
status: draft
tags: [release, semantic-versioning, changelog, github-action, readme, marketing, module, theme, vetrina]
created: "2026-05-26"
updated: "2026-05-26"
qmd: "module theme semantic versioning auto release changelog marketing README standard"
related:
  - "../rules/00-TRIGGER_MAP.md"
  - "../../.github/workflows/semantic-release.yml"
  - "../../.github/workflows/module-release.yml"
  - "agent-confidence-maximization.md"
---

# Module & Theme Release & Showcase Standard (2026-05)

## Obiettivo
Ogni modulo (`laravel/Modules/*`) e ogni tema (`laravel/Themes/*`) deve essere trattabile come un **prodotto autonomo** rilasciabile, versionato e presentabile professionalmente.

## Requisiti Obbligatori

### 1. GitHub Action per Semantic Versioning + Auto Release + Auto Changelog
Ogni modulo e tema **deve** avere (o referenziare) un workflow che implementi:

- Semantic versioning automatico basato su Conventional Commits
- Creazione automatica di GitHub Release
- Generazione/aggiornamento automatico di `CHANGELOG.md` (locale al modulo/tema)
- (Opzionale ma consigliato) Aggiornamento di `ROADMAP.md` e `VERSION`

**Pattern consigliati** (già esistenti nel monorepo):
- Riutilizzare o estendere `.github/workflows/semantic-release.yml` e `module-release.yml`
- O avere un workflow locale in `<module>/.github/workflows/release.yml` che usa composite action o reusable workflow dalla root

### 2. README.md di Vetrina (Root del Modulo/Tema)
Nella radice di ogni modulo e tema deve esistere un `README.md` con le seguenti caratteristiche:

- **Titolo click-bait + professionale** (es. "Xot — Il Cuore Pulsante di Laraxot")
- Descrizione breve, potente e orientata al valore
- Sezione "Perché questo modulo/tema è diverso"
- Badge di versione, licenza, build status (se applicabile)
- Link relativi verso la documentazione locale:
  - `./docs/wiki/` o `./docs/`
  - `./docs/concepts/`, `./docs/how-to/`, `./docs/rules/`, ecc.
- Sezione "Installazione Rapida"
- Sezione "Esempi d'Uso"
- Call-to-action forti ("Scopri la filosofia", "Contribuisci", "Vedi i rilasci")
- Stile marketing di alto livello (non tecnico-secco)

Il README deve funzionare da **landing page** quando qualcuno atterra sul repository del modulo/tema.

## Struttura Consigliata per Moduli/Temi

```
<ModuleName>/
├── README.md                 ← Vetrina marketing (obbligatorio)
├── CHANGELOG.md              ← Auto-generato
├── ROADMAP.md                ← Opzionale ma fortemente consigliato
├── VERSION                   ← Opzionale
├── composer.json
├── .github/workflows/
│   └── release.yml           ← (o riutilizzo da root)
└── docs/
    ├── wiki/
    │   ├── concepts/
    │   ├── how-to/
    │   ├── rules/
    │   └── INDEX.md
    └── ...
```

## Implementazione Graduale (2026)

1. **Fase 1** (in corso): Definizione dello standard + template (questa pagina)
2. **Fase 2**: Creazione template riutilizzabili (workflow + README.md d'esempio)
3. **Fase 3**: Applicazione ai moduli core (Xot, Activity, User, Lang, Media, Notify...)
4. **Fase 4**: Applicazione a tutti i moduli e temi
5. **Fase 5**: Verifica che ogni modulo/tema abbia backlink relativi funzionanti verso i propri docs

## Confidenza e Second Brain

Questo standard nasce dopo scoperta (tramite smart tools) che il monorepo possiede già workflow potenti a livello root (`semantic-release.yml`, `module-release.yml`) ma **manca una policy esplicita e distribuita** che obblighi ogni componente a essere un prodotto autonomo con vetrina.

La documentazione di questo standard nel wiki (root + propagazione in ogni modulo/tema) è parte attiva del processo di **aumento del livello di confidenza** dell'agente e di miglioramento del second brain.

## Trigger Map
| Trigger | Carica |
|---------|--------|
| Creazione/aggiornamento modulo o tema | Questa pagina + templates |
| Semantic versioning / release per componente | `.github/workflows/semantic-release.yml`, `module-release.yml` + questa pagina |

**Questo standard è obbligatorio per tutti i nuovi moduli/temi e per l'evoluzione di quelli esistenti.**
