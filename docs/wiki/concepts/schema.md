---
title: "Project Wiki Schema e Convenzioni"
type: "concept"
tags: [wiki, schema, conventions, naming, protocol]
created: 2026-04-15
updated: 2026-05-12
qmd: "wiki schema, conventions, naming, page types, ingest protocol"
---

# PTVX Project Wiki — Schema e Convenzioni

## Dominio
Documentazione di progetto trasversale per la piattaforma PTVX (Piattaforma Territorio e Valori). Copre architettura generale, decisioni cross-modulo, pattern condivisi, integrazioni esterne e standard di sviluppo.

## Tipi di Entità
- **Architecture**: Decisioni architetturali globali con ADR (Architecture Decision Record)
- **Pattern**: Pattern condivisi tra tutti i moduli
- **Integration**: Integrazioni con sistemi esterni (PDND, SIGMA, INAIL, ecc.)
- **Standard**: Standard di sviluppo, naming convention, quality gates
- **Module**: Overview di ogni modulo con responsabilità e dipendenze
- **Workflow**: Workflow di sviluppo e deploy

## Entità Principali
- **XotBase**: Classi base del framework interno (via modulo Xot)
- **MultiTenancy**: Architettura multi-tenant della piattaforma
- **FilamentAdmin**: Configurazione Filament per il pannello admin
- **ModuleStructure**: Struttura standard di ogni modulo
- **DeployPipeline**: Pipeline di deploy CI/CD

## Pattern Rilevanti
- **Nwidart Modules**: sistema modulare Laravel
- **Filament v3**: pannello admin
- **Spatie Packages**: permission, media, activity log
- **Multi-tenancy**: isolamento dati per ente/tenant
- **LLM Wiki**: pattern Karpathy per knowledge management (questo wiki!)

## Protocollo di Ingest
1. Leggere il documento sorgente raw
2. Identificare se è cross-modulo (va qui) o specifico di un modulo (va nel wiki del modulo)
3. Estrarre entità architetturali e pattern
4. Scrivere/aggiornare pagine in `entities/` o `concepts/`
5. Cross-linkare con i wiki dei moduli rilevanti
6. Aggiungere riassunto in `sources/`
7. Aggiornare `index.md` e appendere a `log.md`

## Convenzione Nomi File
- `concepts/{kebab-case}.md`
- `entities/{EntityName}.md`
- `comparisons/{a}-vs-{b}.md`
- `sources/{source-filename}.md`

## Regola Cross-linking
Ogni pagina DEVE linkare almeno un'altra pagina wiki.
Le pagine orfane sono un errore di lint.
I link a wiki di moduli specifici usano path relativi: `../../laravel/Modules/{Module}/docs/wiki/`

## Standard di Qualità
- Le ADR (Architecture Decision Records) non cambiano — le nuove decisioni creano nuove ADR
- Ogni integrazione esterna deve avere la sua pagina con endpoint, auth e limitazioni documentate
- Nessuna claim obsoleta oltre 30 giorni senza ri-verifica
