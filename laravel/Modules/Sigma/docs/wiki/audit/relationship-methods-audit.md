---
title: "Audit metodi relationship duplicate — Esteso"
type: audit
module: system-wide
tags: [refactoring, duplicate-methods, relationship, dry, kiss]
created: 2026-06-15
updated: 2026-06-15
---

# Audit metodi relationship duplicate

## Pattern identificato

Metodi che implementano:
```php
$this->hasMany(Model::class, 'matr', 'matr')
    ->where('ente', $this->ente)
    ->whereRaw('xxxann=""');
```

## Catalogo metodi (40 trovati)

| Modulo | File | Metodo | Linea | Pattern |
|--------|------|--------|-------|---------|
| Incentivi | Employee.php | qua00f | 144 | ente+matr+ann="" |
| Incentivi | Employee.php | qua03f | 166 | ente+matr |
| Incentivi | Employee.php | rep00f | 188 | ente+matr+ann="" |
| IndennitaResponsabilita | LettF.php | rep00fByAnno | 340 | ofYear |
| IndennitaResponsabilita | LettF.php | qua00fRetribuzioneDateRange | 371 | ofRangeDate (CORRETTO) |
| Progressioni | Assenza.php | anag | 67 | HasOne |
| Sigma | Asz00k1.php | qua00fsimple | 219 | ente+ann="" |
| Sigma | Asz00k1.php | qua00f | 231 | ente+ann="" |
| Sigma | Qua00f.php | qua03f | 240 | ente+matr+ann="" |
| Sigma | Qua00f.php | rep00f | 269 | ente+matr+ann="" |
| Sigma | Qua00f.php | qua00fsimple | 308 | ente+ann="" |
| Sigma | Qua00f.php | qua00f | 406 | ente+ann="" |
| Sigma | Qua00k1.php | qua00f | 159 | ente+ann="" |
| Sigma | Qua00k1.php | rep00f | 170 | ente+ann="" |
| Sigma | Qua03f.php | qua00f | 212 | ente+matr+ann="" |
| Sigma | Rep00f.php | rep00f | 255 | ente+matr+ann="" |
| Sigma | Wstr02f.php | wstr00f | 251 | ente+matr |

## Reflection

### DRY vietato
Ogni model ripete lo stesso pattern di relazione. Questo duplica:
- Logica `where('ente', $this->ente)`
- Logica `whereRaw('xxxann=""')`
- Logica `ofRangeDate()`/`ofYear()`

### Soluzione (implementata)

`BaseModel::hasManyByEnteMatr($related)` + `applyRelatedActiveAnnFilter()`:

- Legge `annFieldName()` dal **modello target** (`SigmaDateRangeFields`)
- Nessun parametro `'quaann'` / `'repann'` dall'esterno

```php
// ✅ Corretto — Qua00f possiede annFieldName()
return $this->hasManyByEnteMatr(Qua00f::class);

// Con intervallo date
return $this->hasManyByEnteMatr(Qua00f::class)->ofRangeDate($dalYmd, $alYmd);
```

```php
// ❌ Vietato — duplica metadata del modello
$this->relatedByAnno(Qua00f::class, 'quaann');
$this->relatedByRange(Qua00f::class, 'quaann', 'qua2kd', 'qua2ka');
```

Vedi [model-owned-ann-field-relationships](../../../../../../docs/wiki/rules/model-owned-ann-field-relationships.md).

## Status
- LettF.php: ✅ refactoring parziale
- Altre 15 model: ⏳ handoff in `docs/chat/handoff-matr-ente-field-abstraction.md`