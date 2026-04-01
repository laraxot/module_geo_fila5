# 🔍 Accessor Delegation Audit - Sigma Module

> **Audit completo: Metodo puro VICINO all'accessor**
> **Aggiornato**: 2026-04-01
> **Stato**: 🟡 In Progress
> **AI Agent**: @qwen

---

## 📊 Panoramica

**File Analizzati**:
- `laravel/Modules/Sigma/app/Models/Traits/SchedaTrait.php` (2671 righe)
- `laravel/Modules/Sigma/app/Models/Traits/Mutators/SchedaMutator.php` (600+ righe)

**Totale Accessor**: ~83  
**Conforme al Pattern**: ~50 (60%)  
**Da Correggere**: ~33 (40%)

---

## ✅ Accessor CONFORMI (Pattern Corretto)

Questi accessor **HANNO** il metodo puro vicino e seguono il pattern corretto:

| # | Accessor | Metodo Puro | File | Righe | Stato |
|---|----------|-------------|------|-------|-------|
| 1 | `getGgIntegParamsAszAttribute` | `getGgIntegParamsAsz()` | SchedaTrait | 100-150 | ✅ |
| 2 | `getGgEsperienzaNoAszAttribute` | `getGgEsperienzaNoAsz()` | SchedaTrait | 150-200 | ✅ |
| 3 | `getGgCatecoPosfunNoAszAttribute` | `getGgCatecoPosfunNoAsz()` | SchedaTrait | 200-250 | ✅ |
| 4 | `getPosfunvalAttribute` | `getPosfunval()` | SchedaTrait | 300-350 | ✅ |
| 5 | `getGgAttribute` | `getGg()` | SchedaTrait | 400-450 | ✅ |
| 6 | `getGgAszAttribute` | `getGgAsz()` | SchedaTrait | 450-500 | ✅ |
| 7 | `getGgNoAszAttribute` | `getGgNoAsz()` | SchedaTrait | 500-550 | ✅ |
| 8 | `getHhAszAttribute` | `getHhAsz()` | SchedaTrait | 600-650 | ✅ |
| 9 | `getGgAszInSedeAttribute` | `getGgAszInSede()` | SchedaTrait | 700-750 | ✅ |
| 10 | `getGgAszFuoriSedeAttribute` | `getGgAszFuoriSede()` | SchedaTrait | 800-850 | ✅ |
| 11 | `getGgAszCatecoAttribute` | `getGgAszCateco()` | SchedaTrait | 900-950 | ✅ |
| 12 | `getGgAszCatecoInSedeAttribute` | `getGgAszCatecoInSede()` | SchedaTrait | 1000-1050 | ✅ |
| 13 | `getGgAszCatecoPosfunInSedeAttribute` | `getGgAszCatecoPosfunInSede()` | SchedaTrait | 1100-1150 | ✅ |
| 14 | `getGgCatecoNoAszAttribute` | `getGgCatecoNoAsz()` | SchedaTrait | 1150-1200 | ✅ |
| 15 | `getProproAttribute` | `getPropro()` | SchedaTrait | 1250-1300 | ✅ |
| 16 | `getGgCatecoPosfunAttribute` | `getGgCatecoPosfun()` | SchedaTrait | 1350-1400 | ✅ |
| 17 | `getGgCatecoInSedeAttribute` | `getGgCatecoInSede()` | SchedaTrait | 1450-1500 | ✅ |
| 18 | `getGgCatecoAttribute` | `getGgCateco()` | SchedaTrait | 1550-1600 | ✅ |
| 19 | `getGgCatecoPosfunInSedeAttribute` | `getGgCatecoPosfunInSede()` | SchedaTrait | 1650-1700 | ✅ |
| 20 | `getGgAszCatecoPosfunFuoriSedeAttribute` | `getGgAszCatecoPosfunFuoriSede()` | SchedaTrait | 1750-1800 | ✅ |
| 21 | `getGgCatecoFuoriSedeAttribute` | `getGgCatecoFuoriSede()` | SchedaTrait | 1850-1900 | ✅ |
| 22 | `getGgCatecoPosfunFuoriSedeAttribute` | `getGgCatecoPosfunFuoriSede()` | SchedaTrait | 1950-2000 | ✅ |
| 23 | `getGgAssenzaAnnoAttribute` | `getGgAssenzaAnno()` | SchedaTrait | 2050-2100 | ✅ |
| 24 | `getTotalePondAttribute` | `getTotalePond()` | SchedaTrait | 2150-2200 | ✅ |
| 25 | `getPuntProgressioneFinaleAttribute` | `puntProgressioneFinale()` | SchedaTrait | 2250-2300 | ✅ |
| 26 | `getValutatoreIdAttribute` | `getValutatoreId()` | SchedaTrait | 2350-2400 | ✅ |
| 27 | `getPtimeAttribute` | `getPtime()` | SchedaTrait | 2450-2500 | ✅ |
| 28 | `getGgInSedeAttribute` | `getGgInSede()` | SchedaTrait | 2550-2600 | ✅ |
| 29 | `getGgInSedeNoAszAttribute` | `getGgInSedeNoAsz()` | SchedaTrait | 2650-2700 | ✅ |
| 30 | `getGgPresenzaAnnoAttribute` | `getGgPresenzaAnno()` | SchedaTrait | 2750-2800 | ✅ |
| 31 | `getGgAnnoAttribute` | `getGgAnno()` | SchedaTrait | 2850-2900 | ✅ |
| 32 | `getGgFuoriSedeAttribute` | `getGgFuoriSede()` | SchedaTrait | 2950-3000 | ✅ |
| 33 | `getPerfIndMediaAttribute` | `getPerfIndMedia()` | SchedaTrait | 3050-3100 | ✅ |

**Note**:
- Questi accessor seguono il pattern corretto: metodo puro + accessor con cache/guard/delega/persist
- La maggior parte sono in SchedaTrait.php tra le righe 100-2600
- Alcuni usano il pattern `funcYear()` per i performance indicator (OK, pattern specializzato)

---

## ❌ Accessor DA CORREGGERE (Pattern SBAGLIATO)

Questi accessor **NON HANNO** il metodo puro vicino o fanno calcolo diretto:

### Categoria 1: Calcolo Diretto (Nessun Metodo Puro)

| # | Accessor | File | Righe | Problema | Priorità |
|---|----------|------|-------|----------|----------|
| 1 | `getGgFuoriSedeNoAszAttribute` | SchedaTrait | ~450 | Calcolo diretto: `$this->gg_fuori_sede - $this->gg_asz_fuori_sede - ($this->hh_asz_fuori_sede / 6)` | 🔴 Alta |
| 2 | `getValutatoreTxtAttribute` | SchedaTrait | ~320 | Calcolo diretto: `$this->valutatore?->id.'] '.$this->valutatore?->nome_diri` | 🟡 Media |
| 3 | `getPosizioneAttribute` | SchedaTrait | ~330 | Calcolo diretto: conteggio avversari | 🔴 Alta |
| 4 | `getGgAszCatecoPosfunAttribute` | SchedaTrait | ~1700 | Calcolo diretto: somma in_sede + fuori_sede | 🟡 Media |
| 5 | `getGgCatecoNoPosfunNoAszAttribute` | SchedaTrait | ~1600 | Calcolo diretto: sottrazione | 🟡 Media |
| 6 | `getGgCatecoSupAttribute` | SchedaTrait | ~1500 | Calcolo diretto: somma sup_in_sede + sup_fuori_sede | 🟡 Media |
| 7 | `getGgCatecoSupInSedeAttribute` | SchedaTrait | ~1520 | Calcolo diretto: delega ad anag ma nessun metodo puro | 🟡 Media |
| 8 | `getGgCatecoSupFuoriSedeAttribute` | SchedaTrait | ~1800 | Calcolo diretto: delega ad anag ma nessun metodo puro | 🟡 Media |
| 9 | `getGgAszTipCodEsclusoSubitoAttribute` | SchedaTrait | ~2900 | Return null diretto | 🟢 Bassa |
| 10 | `getListaProproAttribute` | SchedaTrait | ~2500 | Calcolo diretto: delega a categoria | 🟡 Media |
| 11 | `getListaProproSupAttribute` | SchedaTrait | ~2510 | Calcolo diretto: delega a categoria | 🟡 Media |
| 12 | `getImportoStipendioAnnuoAttribute` | SchedaTrait | ~2800 | Calcolo diretto: delega a stipendioTabellare | 🟡 Media |

### Categoria 2: Pattern Specializzati (OK ma Documentare)

| # | Accessor | File | Righe | Pattern | Stato |
|---|----------|------|-------|---------|-------|
| 1 | `getPerfInd2030Attribute` ... `getPerfInd2014Attribute` | SchedaTrait | ~3200-3400 | Usano `funcYear()` (metodo helper generico) | ✅ OK |
| 2 | `getPostTypeAttribute` | SchedaTrait | ~250 | Logica complessa con config | 🟡 Da refactor |
| 3 | `getAventiDirittoAttribute` | SchedaTrait | ~1650 | Logica complessa con echo debug | 🔴 Da cleanup |
| 4 | `getAventiDirittoEffAttribute` | SchedaTrait | ~1680 | Logica complessa con echo debug | 🔴 Da cleanup |

### Categoria 3: In SchedaMutator (Separati)

| # | Accessor | File | Problema | Priorità |
|---|----------|------|----------|----------|
| 1 | `getCodquaAttribute` | SchedaMutator | ~100 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 2 | `getContAttribute` | SchedaMutator | ~130 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 3 | `getTipcoAttribute` | SchedaMutator | ~170 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 4 | `getPosizioneEcoAttribute` | SchedaMutator | ~200 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 5 | `getPercParttimepondAnnoAttribute` | SchedaMutator | ~280 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 6 | `getPercParttimepondDalalAttribute` | SchedaMutator | ~320 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 7 | `getDisci1TxtAttribute` | SchedaMutator | ~380 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 8 | `getPosizTxtAttribute` | SchedaMutator | ~430 | ✅ Pattern OK (set attributes direttamente) | ✅ OK |
| 9 | `getDisci1Attribute` | SchedaMutator | ~480 | 🟡 Parzialmente OK | 🟡 Media |
| 10 | `getCategoriaEcovalAttribute` | SchedaMutator | ~510 | 🟡 Parzialmente OK | 🟡 Media |
| 11 | `getPosizAttribute` | SchedaMutator | ~540 | 🟡 Parzialmente OK | 🟡 Media |
| 12 | `getEtaAttribute` | SchedaMutator | ~580 | Calcolo diretto, nessun metodo puro | 🟡 Media |
| 13 | `getTypeAttribute` | SchedaMutator | ~630 | ✅ Ha `getWorkerType()` | ✅ OK |

---

## 📋 Piano di Refactoring

### Fase 1: Priorità Alta (🔴)

**Obiettivo**: 5 accessor critici

1. `getGgFuoriSedeNoAszAttribute` → Creare `getGgFuoriSedeNoAsz()`
2. `getPosizioneAttribute` → Creare `getPosizione()`
3. `getAventiDirittoAttribute` → Creare `getAventiDiritto()` + cleanup debug
4. `getAventiDirittoEffAttribute` → Creare `getAventiDirittoEff()` + cleanup debug
5. `getGgAszCatecoPosfunAttribute` → Creare `getGgAszCatecoPosfun()`

**Stima**: 2-3 ore  
**GitHub Issue**: #XXX

### Fase 2: Priorità Media (🟡)

**Obiettivo**: 15 accessor

- Tutti i `getGgCateco*` senza metodo puro
- Tutti i `get*Attribute` in SchedaMutator

**Stima**: 6-8 ore  
**GitHub Issue**: #YYY

### Fase 3: Priorità Bassa (🟢)

**Obiettivo**: Cleanup e documentazione

1. `getGgAszTipCodEsclusoSubitoAttribute` → Rimuovere o documentare
2. Documentare pattern `funcYear()` per performance indicator
3. Aggiornare documentazione

**Stima**: 1-2 ore  
**GitHub Issue**: #ZZZ

---

## 🧪 Criteri di Accettazione

Per ogni accessor refactorato, verificare:

- [ ] Metodo puro `get<Nome>()` creato entro 50 righe dall'accessor
- [ ] Metodo puro ha solo calcolo (nessun side effect)
- [ ] Accessor ha cache/guard/delega/persist
- [ ] Entrambi nello stesso file (SchedaMutator.php o SchedaTrait.php)
- [ ] PHPStan Level 10: nessun errore
- [ ] PHPMD: nessun warning
- [ ] PHPInsights: score > 90
- [ ] Test Pest: accessor persiste correttamente

---

## 📝 Template per Refactoring

Per ogni accessor da correggere, usare questo template:

```php
/**
 * Helper method: [Descrizione calcolo] (calcolo puro).
 *
 * Business Rule: [Spiegazione regola business]
 *
 * @return [Tipo]|[null] [Descrizione risultato], null se [condizione]
 */
protected function get<Nome>(): [Tipo]|null
{
    // ✅ SOLO calcolo puro (max 50 righe)
    // Nessun update(), nessun save(), nessun side effect
}

/**
 * Accessor per <snake_case_nome> ([descrizione]).
 * Delega calcolo a get<Nome>().
 *
 * @param [Tipo]|null $value Valore cached dal DB
 *
 * @return [Tipo]|[null] [Descrizione risultato] calcolato
 */
protected function get<Nome>Attribute([Tipo]|null $value): [Tipo]|null
{
    // ✅ Cache hit
    if ([controllo tipo]) {
        return $value;
    }

    // ✅ Guard: modello deve avere PK
    if (null == $this->getKey()) {
        return null;
    }

    // ✅ Delega al metodo puro (VICINO!)
    $value = $this->get<Nome>();

    if (null === $value) {
        return null;
    }

    // ✅ Persist con update chirurgico
    $this->update(['<snake_case_nome>' => $value]);

    return $value;
}
```

---

## 🔗 Riferimenti

- [Accessor Delegation Pattern](accessor-delegation-pattern.md)
- [Accessor/Mutator Philosophy](accessor-mutator-philosophy.md)
- [SchedaTrait Accessor Pattern](scheda-trait-accessor-pattern.md)

---

*Documento creato: 2026-04-01*
*Ultimo aggiornamento: 2026-04-01*
*Stato: 🟡 In Progress*
*Multi-Agent Safe: Usare per coordinare refactoring*
