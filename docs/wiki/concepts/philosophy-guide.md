# Guida Filosofica PTVX - Religione, Politica e Filosofia dello Sviluppo

## Introduzione: Il Perché Prima del Come

Nel progetto PTVX non scriviamo solo codice: **costruiamo un sistema di pensiero**. Questa guida esplica la **filosofia**, la **religione** (i dogmi non negoziabili), e la **politica** (le decisioni architetturali strategiche) che guidano ogni linea di codice.

> "Il miglior codice è quello che non devi scrivere."  
> — Filosofia DRY applicata alla vita

## Religione del Progetto (Dogmi Non Negoziabili)

### 1. DRY (Don't Repeat Yourself) - La Prima Legge

**Dogma**: Non esistono duplicazioni tollerabili. Mai.

**Perché**: Ogni duplicazione è:
- Un debito tecnico che cresce esponenzialmente
- Una promessa di inconsistenza futura
- Un insulto alla manutenibilità

**Pratica**:
```php
// ❌ PECCATO MORTALE: Duplicazione
class UserResource extends XotBaseResource {
    public function getName() { return $this->name; }
}
class TeamResource extends XotBaseResource {
    public function getName() { return $this->name; }
}

// ✅ SALVEZZA: Estrazione in trait/classe base
trait HasName {
    public function getName(): string { return $this->name; }
}
```

**Conseguenze Violazione**: 
- Code review respinto
- Refactoring obbligatorio
- Meditazione su perché il DRY esiste

### 2. KISS (Keep It Simple, Stupid) - La Seconda Legge

**Dogma**: La semplicità batte sempre la complessità. Sempre.

**Perché**: 
- Il codice semplice è leggibile
- Il codice leggibile è manutenibile
- Il codice manutenibile è prezioso

**Pratica**:
```php
// ❌ OVER-ENGINEERING
class UserManagerFactoryProviderAdapterSingleton {
    private static $instance;
    private $strategies = [];
    // 500 linee di astrazione inutile...
}

// ✅ SEMPLICITÀ
class UserService {
    public function createUser(UserData $data): User {
        return User::create($data->toArray());
    }
}
```

**Conseguenze Violazione**:
- Richiesta di giustificazione scritta della complessità
- Refactoring verso soluzione più semplice
- Domanda: "Puoi spiegarlo a un bambino di 5 anni?"

### 3. Business Logic First - La Terza Legge

**Dogma**: La business logic detta la tecnologia, non il contrario.

**Perché**:
- Il dominio è la verità
- La tecnologia è solo uno strumento
- I requisiti di business sopravvivono ai framework

**Pratica**:
```php
// ❌ TECNOLOGIA-DRIVEN
class UserController {
    public function store(Request $request) {
        // Logica SQL inline, accoppiamento framework
        DB::table('users')->insert([...]);
    }
}

// ✅ BUSINESS-DRIVEN
class CreateUserAction {
    /**
     * Crea un nuovo utente nel sistema PA.
     * 
     * Business Rule: Ogni utente deve avere un ruolo assegnato.
     * Compliance: GDPR Art. 5 - minimizzazione dati.
     */
    public function execute(UserData $data): User {
        // Logica di dominio pura
        return $this->userRepository->create($data);
    }
}
```

## Politica del Progetto (Decisioni Strategiche)

### Architettura Modulare: La Sovranità dei Moduli

**Politica**: Ogni modulo è uno stato sovrano.

**Rationale**:
- **Autonomia**: Ogni modulo può vivere da solo
- **Responsabilità**: Confini chiari di ownership
- **Scalabilità**: Crescita indipendente

**Costituzione Modulare**:
```php
// COSTITUZIONE DEL MODULO
// Articolo 1: Ogni modulo ha il suo namespace
namespace Modules\Performance\Models;

// Articolo 2: Ogni modulo estende la propria base
class Performance extends BaseModel // NON XotBaseModel

// Articolo 3: Ogni modulo ha la propria documentazione
// docs/README.md, docs/architecture.md, docs/business-logic.md
```

**Relazioni Diplomatiche**: 
- Comunicazione solo tramite interfacce pubbliche
- No accessi diretti a internals di altri moduli
- Dipendenze esplicite in composer.json

### Tipizzazione Rigorosa: Il Contratto Sociale

**Politica**: Il tipo è legge. PHPStan livello 10 è la costituzione.

**Rationale**:
- **Sicurezza**: Errori catturati compile-time, non runtime
- **Documentazione**: Il codice si auto-documenta
- **Refactoring**: Cambio sicuro e automatizzato

**Trattati Internazionali**:
```php
/**
 * Trattato PHPStan-Safe per getCollectionCount
 * 
 * @param Collection<int, User> $users - Collezione tipizzata
 * @return int - MAI mixed, MAI null non gestito
 */
public function getCollectionCount(Collection $users): int {
    return $users->count(); // Tipo garantito dal contratto
}
```

### Traduzioni Automatiche: Nessuna Stringa Hardcoded

**Politica**: Le stringhe hardcoded sono considerate bug di sicurezza.

**Rationale**:
- **i18n**: Multilingua senza refactoring
- **Manutenibilità**: Modifica traduzioni senza toccare codice
- **Coerenza**: Single source of truth per tutti i testi

**Legge Anti-Hardcoding**:
```php
// ❌ ILLEGALE: Hardcoding
TextInput::make('name')->label('Nome');

// ✅ LEGALE: Traduzione automatica
TextInput::make('name'); // Tradotto da lang/it/users.php

// lang/it/users.php
return [
    'fields' => [
        'name' => [
            'label' => 'Nome',
            'placeholder' => 'Inserisci nome',
            'help' => 'Nome completo utente',
        ],
    ],
];
```

## Filosofia del Codice

### Il Tao del Codice PTVX

#### Capitolo 1: Il Vuoto che Tutto Contiene

> Il miglior codice è il codice non scritto.  
> Prima di aggiungere, togli.  
> Prima di complicare, semplifica.  
> Prima di costruire, domanda: "Serve davvero?"

**Pratica Zen**:
```php
// 🧘 MEDITAZIONE: Questa classe serve davvero?
// Se una classe ha un solo metodo, forse è una funzione.
// Se una funzione fa tutto, forse sono tre funzioni.
// Se un modulo fa tutto, forse sono tre moduli.
```

#### Capitolo 2: Il Flusso della Logica

> La logica deve fluire come l'acqua:  
> Chiara, diretta, senza ostacoli.  
> Se non riesci a seguirla a occhi chiusi,  
> è troppo complessa.

**Pratica del Flusso**:
```php
// 🌊 FLUSSO NATURALE
public function processPayment(PaymentData $data): PaymentResult {
    return $this->validatePayment($data)
        ->then(fn() => $this->chargeCard($data))
        ->then(fn() => $this->sendReceipt($data))
        ->catch(fn($e) => $this->handleError($e));
}

// ⛰️ OSTACOLI (troppa nesting)
public function processPayment($data) {
    if ($this->validate($data)) {
        if ($this->charge($data)) {
            if ($this->sendReceipt($data)) {
                return true;
            }
        }
    }
    return false;
}
```

#### Capitolo 3: Il Naming è Meditazione

> I nomi sono mantra.  
> Un nome sbagliato è una bugia.  
> Una bugia confonde la mente.  
> Una mente confusa crea bug.

**Mantra del Naming**:
```php
// ✨ ILLUMINAZIONE: Nomi che parlano
class CreateUserAction {} // Chiaro
class GetActiveUsersQuery {} // Preciso
class UserCreatedEvent {} // Esplicito

// 🌑 OSCURITÀ: Nomi che confondono
class UserManager {} // Manager di cosa?
class Handler {} // Handler di chi?
class Process {} // Process cosa?
```

### Economia Circolare del Codice

**Principio**: Il codice è una risorsa. Va riutilizzato, non sprecato.

**Ciclo di Vita del Codice**:
1. **Creazione**: Scrivi con intenzione, non di fretta
2. **Utilizzo**: Usa con rispetto, non abusare
3. **Manutenzione**: Cura come un giardino
4. **Refactoring**: Migliora costantemente
5. **Rimozione**: Elimina quando obsoleto

**Anti-pattern Spreco**:
```php
// 🗑️ SPRECO: Codice morto lasciato marcire
// function oldFunction() { ... } // TODO: remove after migration

// ♻️ ECONOMIA: Se è morto, eliminalo subito
// [Codice vecchio CANCELLATO]
// Se serve storicamente, è nel git log
```

## Etica dello Sviluppatore PTVX

### Responsabilità verso il Codice

**Giuramento dello Sviluppatore**:

> "Io giuro di:
> - Scrivere codice che altri possano leggere
> - Documentare le decisioni, non solo il come
> - Lasciare il codice migliore di come l'ho trovato
> - Ammettere quando non so, invece di indovinare
> - Chiedere aiuto prima di creare debito tecnico"

### Responsabilità verso il Team

**Contratto Sociale**:
- **Code Review costruttive**: Critica il codice, mai la persona
- **Condivisione conoscenza**: Documenta per chi viene dopo
- **Errori come opportunità**: I bug sono insegnamenti
- **Crescita collettiva**: Il team cresce insieme

### Responsabilità verso gli Utenti

**Patto con gli Utenti PA**:
- **Sicurezza prima di tutto**: I dati PA sono sacri
- **Accessibilità**: Il software serve tutti i cittadini
- **Performance**: Il tempo è un servizio pubblico
- **Trasparenza**: Il codice pubblico deve essere comprensibile

## Pratiche Quotidiane

### La Mattina dello Sviluppatore Zen

1. **Meditazione Pre-Code (5 min)**:
   - Cosa devo fare oggi?
   - Perché lo devo fare?
   - Qual è il modo più semplice?
   - Posso riutilizzare invece di creare?

2. **Revisione Documentazione (10 min)**:
   - Leggere docs modulo interessato
   - Verificare decisioni architetturali passate
   - Aggiornare docs se obsolete

3. **PHPStan Meditation (continuo)**:
   ```bash
   # Prima di ogni commit
   ./vendor/bin/phpstan analyze --level=10
   
   # Se passa: commit
   # Se non passa: rifletti sul perché
   ```

### La Sera dello Sviluppatore Consapevole

1. **Revisione Cambiamenti**:
   - Ho aggiunto complessità o rimosso?
   - Ho documentato il perché?
   - Il mio team capirà tra 6 mesi?

2. **Aggiornamento Documentazione**:
   - Docs modulo aggiornata?
   - Collegamenti bidirezionali verificati?
   - Business logic chiara?

3. **Commit Messaggi Consapevoli**:
   ```bash
   # ✅ CONSAPEVOLE
   git commit -m "feat(performance): add evaluation workflow
   
   WHY: Enable standardized employee evaluations
   HOW: Implement EvaluationWorkflow with state machine
   IMPACT: Affects Performance module, updates User relations"
   
   # ❌ INCONSAPEVOLE
   git commit -m "fix stuff"
   ```

## Mantra per Situazioni Difficili

### Quando il Codice Sembra Impossibile
> "Non c'è codice impossibile,  
> solo comprensione incompleta.  
> Torna indietro, respira, comprendi il perché."

### Quando Hai Fretta
> "La fretta è nemica della qualità.  
> Un'ora di pianificazione  
> risparmia una settimana di debug."

### Quando Vuoi Copiare Codice
> "Prima di copiare, domanda:  
> Perché esiste due volte?  
> Forse è una funzione che vuole nascere."

### Quando il Test Fallisce
> "Il test non mente,  
> il test insegna.  
> Ascolta cosa ti sta dicendo."

## Conclusione: Il Codice Come Opera d'Arte

Il codice PTVX non è solo funzionale: **è bello**.

Bellezza significa:
- **Chiarezza**: Si capisce a prima vista
- **Armonia**: Ogni parte si incastra perfettamente
- **Semplicità**: Niente di superfluo
- **Significato**: Ogni riga ha uno scopo

**Domanda Finale Prima di Ogni Commit**:

> "Se questo codice fosse un edificio,  
> ci vivresti dentro?  
> Se la risposta è no,  
> continua a migliorarlo."

---

## Collegamenti Filosofici

- **[Consolidamento Documentazione](./consolidamento-documentazione.md)** - Piano strategico
- **[Best Practices](./best-practices/)** - Pratiche concrete
- **[Code Quality](./best-practices/code-quality.md)** - Qualità tecnica

---

**Scritto da**: AI Assistant in stato di Flow  
**Ispirato da**: The Tao of Programming, Clean Code, filosofia Zen  
**Ultimo aggiornamento**: 2025-01-29

> "Il vero maestro non è chi scrive codice perfetto,  
> ma chi aiuta altri a scrivere codice migliore."

