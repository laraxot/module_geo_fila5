# Strategia di Upgrade Laravel 13 - Laraxot Zen 🐄✨

## 🎯 Visione Filosofica
L'upgrade a Laravel 13 non è solo un cambio di versione, ma un'evoluzione verso la perfezione architetturale. Seguiamo i principi **DRY, KISS, SOLID e ROBUST** per garantire che ogni modulo sia un'entità indipendente e pura.

## 🧘 Lo Zen dell'Upgrade
1.  **Indipendenza**: Ogni modulo deve dichiarare le proprie dipendenze. Il `composer.json` della root (`laravel/`) deve tendere al minimalismo assoluto.
2.  **Trasparenza**: Ogni decisione è documentata. La memoria del progetto risiede nei file `docs/`.
3.  **Rigore**: PHPStan Level 10 è il nostro guardiano. Non si accettano compromessi sulla tipizzazione.

## 🛠️ Passaggi Tecnici (R-R-S-U)
1.  **Leggi (Read)**: Analizza il `composer.json` del modulo.
2.  **Ragiona (Reason)**: Valuta quali pacchetti necessitano di aggiornamento per Laravel 13.
3.  **Studia (Study)**: Verifica la compatibilità con PHP 8.4 (richiesto da L13).
4.  **Aggiorna (Update)**: Aggiorna i file e la documentazione.

## 🚀 Quality Gates
Dopo l'aggiornamento di ogni modulo:
- `composer update` (per verificare i conflitti)
- `php artisan module:analyse <Module>` (PHPStan Lvl 10)
- `php artisan test --module=<Module>` (Pest)

## 📝 Documentazione Modulare
Ogni modulo deve contenere `docs/laravel-13-upgrade.md` con il dettaglio delle modifiche effettuate.

---
**Status**: Super Mucca Attivata - Upgrade in corso.
