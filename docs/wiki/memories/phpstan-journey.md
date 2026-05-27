---
title: Il Viaggio verso l'Illuminazione PHPStan (PHPStan Journey)
type: memory
status: in-progress
agent: Gemini CLI
model: gemini-2.0-flash-thinking-exp-01-21
updated: 2026-05-27
tags: [phpstan, quality, bmad, modules]
---

# 🏔️ Il Viaggio verso l'Illuminazione PHPStan

Questo documento traccia l'evoluzione della qualità del codice attraverso l'analisi statica rigorosa (Livello 10/Max) di tutti i moduli Laraxot.

## 📊 La Mappa del Viaggio (Inventario)

Per il dettaglio aggiornato di ogni modulo, consultare [phpstan-modules-inventory.md](phpstan-modules-inventory.md).

| Modulo | Stato | Livello | Note |
|--------|-------|---------|------|
| **Activity** | ⚠️ Regressione | 10 | 16 errori rilevati il 27-05-2026 |
| **Gdpr** | ⚠️ Regressione | 10 | 16 errori rilevati il 27-05-2026 |
| **Cms** | ✨ Illuminato | 10 | 0 errori |
| **Job** | ✨ Illuminato | 10 | 0 errori |
| **DbForge** | ✨ Illuminato | 10 | 0 errori |

## 🧘 La Filosofia (BMAD Integration)

Seguiamo il **BMAD-METHOD** per orchestrare la campagna di qualità. Ogni modulo rimosso dal "Samsara" degli errori è una "Implementation Story" completata.

### Le Tre Fasi dell'Illuminazione
1. **Samsara (Sofferenza)**: Codice con tipi `mixed`, assenza di PHPDoc, errori di runtime silenziosi.
2. **Dharma (Pratica)**: Applicazione dei pattern BMAD, narrowing dei tipi, fiducia nel sistema statico.
3. **Nirvana (Liberazione)**: Zero errori PHPStan a Livello 10, codice auto-documentato e manutenibile.

## 🎯 Pattern di Illuminazione (Best Practices)

### 1. Semantic Keys
Utilizzare chiavi stringa negli array dei componenti Filament per chiarezza e per aiutare l'inferenza di PHPStan.
```php
// ✅ Luce
['name' => TextInput::make('name')]
```

### 2. Type Narrowing Trust
Quando un filtro garantisce un tipo, comunicarlo a PHPStan tramite PHPDoc.
```php
/** @var array<string, mixed> $data */
$data = array_filter($input);
```

### 3. Collection Flow
Le collection Laravel propagano i tipi. Usare `filter` e `map` con attenzione ai tipi di ritorno.

## 🎓 I Sutra della Qualità

> **Sutra I: Il Sutra del Type System**
> "Nel principio era il Type, e il Type era con PHPStan. Attraverso di lui tutte le cose furono verificate."

> **Sutra II: Il Sutra della Semantic Key**
> "Non chiamare un campo con un numero, ma con il suo nome. Perché il nome è l'essenza."

## 🚀 Workflow BMAD per Agenti
1. **`bmad-help`**: Invoca per decidere il modulo successivo.
2. **`bmad-create-story`**: Crea una story per la purificazione del modulo.
3. **`bmad-dev-story`**: Applica i fix seguendo i pattern Laraxot.
4. **`bmad-tech-writer`**: Documenta i nuovi pattern scoperti.

---
*Firmato: Gemini CLI (Model: gemini-2.0-flash-thinking-exp-01-21)*
