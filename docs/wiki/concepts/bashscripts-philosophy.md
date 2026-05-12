# 🧘 Bashscripts Philosophy - Zen del Gitignore

## 🔴 REGOLA SACRALE

> **`bashscripts/` DEVE rimanere nel `.gitignore`**  
> **NON è un bug - è una feature filosofica**

---

## 🎯 La Filosofia in 3 Principi

### 1. **Separazione dei Concern** 🎭

```
📦 Repository Tracciato (Git)
└── Codice del progetto
    ├── Laravel app
    ├── Moduli
    ├── Configurazioni
    └── Documentazione

🛠️  Repository Locale (Ignored)
└── Strumenti dell'operatore
    ├── Script bash
    ├── Utility locali
    ├── Tool di deployment
    └── Automazioni personali
```

**Perché**: Il codice del progetto è **eterno**. Gli script sono **strumenti temporanei**.

### 2. **Portabilità vs Personalizzazione** ⚖️

| Tracciato in Git | Ignorato (bashscripts) |
|-----------------|------------------------|
| ✅ Condiviso con il team | ❌ Solo tuo |
| ✅ Versionato | ❌ Evolve liberamente |
| ✅ Review richiesto | ❌ Sperimentazione libera |
| ✅ Breaking changes = PR | ❌ Rompi quanto vuoi |
| ✅ Deploy automatico | ❌ Solo locale |

**Il Zen**: Ciò che è **universale** va versionato. Ciò che è **strumentale** rimane locale.

### 3. **Forward-Only per il Codice, Fluidità per gli Strumenti** 🌊

```
Codice progetto:          Strumenti bash:
    ↑                           ～
    │  Forward-Only             ～  Fluidi
    │  Immutabile               ～  Mutevoli
    │  Review                   ～  Sperimentali
    │  CI/CD                    ～  Manuali
```

---

## 📚 Analogie Zen

### Il Falegname e gli Attrezzi

> Il falegname **non inchioda gli attrezzi al banco di lavoro**.  
> Gli attrezzi si **cambiano**, si **affilano**, si **sostituiscono**.  
> Il **mobile** che costruisce è quello che **rimane**.

```
bashscripts/  = Attrezzi del falegname
laravel/      = Mobile costruito
.gitignore    = Il banco che non fissa gli attrezzi
```

### Il Cuoco e i Coltelli

> Un ristorante **non mette i coltelli nel menu**.  
> I coltelli sono **strumenti**, non **piatti**.  
> Il **menu** è ciò che il cliente **vede e riceve**.

```
bashscripts/  = Coltelli in cucina
.gitignore    = Separazione cucina/sala
Git repo      = Menu del ristorante
```

---

## 🔄 Casi d'Uso Corretti

### ✅ COSA FARE

```bash
# 1. Creare script locali per automazione personale
bashscripts/git/subtrees/sync_remote_repo.sh  # OK, è tuo

# 2. Sperimentare liberamente
bashscripts/experimental/new-sync-strategy.sh  # OK, rompi pure

# 3. Ottimizzare per il TUO workflow
bashscripts/backup/my-custom-backup.sh  # OK, è personale

# 4. Avere versioni multiple
bashscripts/git/subtrees/sync_remote_repo_v1.sh
bashscripts/git/subtrees/sync_remote_repo_v2.sh
bashscripts/git/subtrees/sync_remote_repo.sh  # OK, evoluzione locale
```

### ❌ COSA NON FARE

```bash
# 1. NON rimuovere bashscripts/ da .gitignore
git add bashscripts/  # ❌ SBAGLIATO!

# 2. NON commitare script "temporanei"
git commit -m "Add sync script"  # ❌ Se è in bashscripts/

# 3. NON confondere strumenti con codice
# bashscripts/ ≠ Codice di produzione
# bashscripts/ ≠ Feature del progetto
```

---

## 🧭 La Politica del Progetto

### Regole Costituzionali

```
Articolo 1: bashscripts/ è territorio sovrano locale
Articolo 2: Nessuna entità esterna (Git, CI, Team) può violare questa sovranità
Articolo 3: La modifica di bashscripts/ è diritto inalienabile dell'operatore
Articolo 4: Ogni tentativo di versionare bashscripts/ è incostituzionale
```

### Perché Questa Politica?

1. **Autonomia**: Ogni operatore può ottimizzare il proprio workflow
2. **Sperimentazione**: Puoi provare strategie senza PR/Review
3. **Pulizia**: Il repo principale contiene solo codice di produzione
4. **Flessibilità**: Script evolvono senza vincoli di versionamento
5. **Responsabilità**: Tu gestisci i tuoi strumenti, il team gestisce il codice

---

## 📋 Categorie di Script

### 🟢 Locali (Ignored - bashscripts/)

```
bashscripts/
├── git/
│   └── subtrees/
│       ├── sync_remote_repo.sh      # Tuo strumento personale
│       ├── sync_remote_repo_v2.sh   # Tua sperimentazione
│       └── reset_subtrees.sh        # Tua utility
├── backup/
│   └── my-backup.sh                 # Il tuo backup
├── optimization/
│   └── ollama-optimize.sh           # La tua ottimizzazione
└── experimental/
    └── new-idea.sh                  # Tua sperimentazione
```

**Status**: ✅ Ignorati da Git - **LIBERTÀ TOTALE**

### 🔴 Di Progetto (Tracciati - se necessari)

```
# Se uno script DIVENTA codice di produzione:
laravel/
├── artisan                        # Codice versionato
├── app/Actions/
│   └── SyncSubtreesAction.php     # Business logic versionata
└── .github/workflows/
    └── sync-subtrees.yml          # CI/CD versionato
```

**Status**: ✅ Tracciati da Git - **REVIEW + TEST**

---

## 🔄 Quando Promuovere uno Script a Codice

### Criteri di Promozione

```bash
# DA: bashscripts/my-script.sh (locale)
# A:  Codice di produzione (versionato)

QUANDO:
1. ✅ Serve in CI/CD pipeline
2. ✅ È eseguito da GitHub Actions
3. ✅ È parte del deploy di produzione
4. ✅ Altri team member devono usarlo
5. ✅ È critico per il business

ALLORA:
1. Riscrivi come Action PHP/Classe
2. O sposta in .github/workflows/
3. O metti in laravel/artisan/
4. Crea PR con review
5. Test + Documentazione
```

### Esempio di Promozione

```bash
# PRIMA (locale)
bashscripts/deploy-production.sh  # ❌ Solo tuo

# DOPO (produzione)
.github/workflows/deploy.yml      # ✅ Di tutti
app/Actions/DeployToProduction.php # ✅ Business logic
```

---

## 🧘 Pratiche Zen Quotidiane

### Meditazione del Mattino

```
Prima di creare uno script, chiediti:
1. Questo è uno STRUMENTO o è CODICE?
2. Serve a ME o al TEAM?
3. È per SPERIMENTAZIONE o PRODUZIONE?

Se STRUMENTO → bashscripts/ (ignored)
Se CODICE → laravel/ (tracked)
```

### Rituale della Sera

```bash
# Pulizia degli strumenti inutilizzati
find bashscripts/ -name "*-old.sh" -delete
find bashscripts/ -name "*.bak" -delete

# Gli strumenti si consumano, il codice rimane
```

---

## 📜 Manifesto Bashscripts

```
NOI, operatori di questo progetto

PROCLAMIAMO che:

1. bashscripts/ è e rimane nel .gitignore
2. Ogni operatore ha sovranità sui propri script
3. La sperimentazione locale è un diritto inalienabile
4. Il codice di produzione è sacro e versionato
5. Gli strumenti sono fluidi, il codice è eterno

GIURIAMO di:

1. Non confondere strumenti con codice
2. Non versionare script locali
3. Promuovere a codice solo ciò che è produzione
4. Rispettare la separazione dei concern
5. Mantenere il repo pulito e portabile

COSÌ GIURATO E COSÌ MANTENUTO
```

---

## 🔗 Riferimenti

- [SYNC_NO_CONFLICTS.md](../../bashscripts/git/subtrees/docs/SYNC_NO_CONFLICTS.md) - Filosofia sync script
- [CHANGELOG_CONFRONTO.md](../../bashscripts/git/subtrees/docs/CHANGELOG_CONFRONTO.md) - Evoluzione script
- `.gitignore` - La costituzione del progetto
- `docs/ai-agent-coordination.md` - Coordinamento team AI

---

## 📿 Il Mantra

```
Ripeti 3 volte prima di commitare:

"bashscripts è ignorato, bashscripts è ignorato, bashscripts è ignorato"
"Gli strumenti sono miei, il codice è nostro"
"Git traccia il valore, ignora gli attrezzi"
```

🧘 **Respira. Lascia andare. bashscripts è nel .gitignore. Tutto è come deve essere.**
