# Report Qualità Codice - Analisi Moduli

> **Generato**: 2025-12-17 12:00:00  
> **Strumenti**: PHPStan (Level 10), PHPMD, PHP Insights

## 📊 Panoramica

Questo report mostra il numero di errori/violazioni rilevati da ogni strumento di qualità codice per ogni modulo.

## 📈 Legenda

- **PHPStan**: Errori di type safety e analisi statica (livello 10)
- **PHPMD**: Violazioni di code smells (design, naming, complexity, etc.) - *In fase di analisi*
- **PHP Insights**: Problemi architetturali e di complessità - *Richiede configurazione per modulo*

## 📋 Risultati per Modulo

| Modulo | PHPStan | PHPMD | PHP Insights | Totale |
|--------|---------|-------|--------------|--------|
| Activity | 0 | - | - | 0 |
| Badge | 0 | - | - | 0 |
| CertFisc | 0 | - | - | 0 |
| ContoAnnuale | 0 | - | - | 0 |
| DbForge | 0 | - | - | 0 |
| Europa | 0 | - | - | 0 |
| Gdpr | 0 | - | - | 0 |
| Inail | 0 | - | - | 0 |
| Incentivi | 42 | - | - | 42 |
| IndennitaCondizioniLavoro | 0 | - | - | 0 |
| IndennitaResponsabilita | 0 | - | - | 0 |
| Job | 0 | - | - | 0 |
| Lang | 0 | - | - | 0 |
| Legge104 | 0 | - | - | 0 |
| Legge109 | 0 | - | - | 0 |
| Media | 0 | - | - | 0 |
| Mensa | 0 | - | - | 0 |
| MobilitaVolontaria | 0 | - | - | 0 |
| Notify | 0 | - | - | 0 |
| Pdnd | 0* | - | - | 0* |
| Performance | 0 | - | - | 0 |
| Prenotazioni | 0 | - | - | 0 |
| PresenzeAssenze | 0 | - | - | 0 |
| Progressioni | 0 | - | - | 0 |
| Ptv | 0 | - | - | 0 |
| Questionari | 0 | - | - | 0 |
| Rating | 0 | - | - | 0 |
| Setting | 0 | - | - | 0 |
| Sigma | 0 | - | - | 0 |
| Tenant | 0 | - | - | 0 |
| UI | 32 | - | - | 32 |
| User | 0 | - | - | 0 |
| Xot | 0 | - | - | 0 |

## 📊 Totali

| Strumento | Totale Errori/Violazioni |
|-----------|--------------------------|
| **PHPStan Level 10** | 74 |
| **PHPMD** | *In fase di analisi* |
| **PHP Insights** | *Richiede configurazione* |
| **TOTALE GENERALE** | 74 |

## 📝 Note

- **PHPStan**: Analisi eseguita con livello 10 (massima rigidità) - ✅ Completo
- **PHPMD**: Analisi in corso - richiede ruleset personalizzati per ogni modulo
- **PHP Insights**: Richiede file di configurazione `phpinsights.php` per ogni modulo per risultati completi

## 🎯 Moduli con Errori PHPStan

I seguenti moduli hanno errori PHPStan da risolvere:

1. **Incentivi**: 42 errori ⚠️
2. **UI**: 32 errori ⚠️
3. **Pdnd**: Nessun file PHP da analizzare (solo configurazione)

\* Pdnd non contiene file PHP analizzabili da PHPStan

## 🔗 Collegamenti

- [PHPStan Documentation](https://phpstan.org/)
- [PHPMD Documentation](https://phpmd.org/)
- [PHP Insights Documentation](https://phpinsights.com/)
- [Script di Analisi](../../bashscripts/ci-cd/analyze-all-modules.sh)

## 📌 Prossimi Passi

1. Risolvere gli errori PHPStan nei moduli **Incentivi**, **Pdnd** e **UI**
2. Configurare PHPMD ruleset per ogni modulo
3. Configurare PHP Insights per ogni modulo
4. Automatizzare l'analisi nel CI/CD

---

**Ultimo aggiornamento**: 2025-12-17 12:00:00
