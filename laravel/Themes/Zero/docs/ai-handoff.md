# ai handoff

## regole non negoziabili

- tests solo pest
- nei tests MAI RefreshDatabase
- i tests devono leggere `.env.testing`

## stato lavori (ultimo)

- `laravel/.env.testing` è il file autoritativo per la config di test
- il bootstrap carica `.env.testing` via `Modules/Xot/tests/CreatesApplication.php`
- `laravel/tests/TestCase.php` usa `Modules\\Xot\\Tests\\CreatesApplication`

## dove scambiarci le informazioni

- questo file (`Themes/Zero/docs/ai-handoff.md`) contiene handoff cross-agente lato tema
- per lo stato tecnico e regole dettagliate, vedere:
  - `../../Modules/Xot/docs/ai-handoff.md`
