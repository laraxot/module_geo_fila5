---
title: "passaggio da mysql community server a mariadb (wsl locale)"
type: how-to
tags: [mariadb, mysql, laravel, systemd, wsl]
created: 2026-05-21
updated: 2026-05-21
related:
  - ../memories/mysql-mariadb-datadir-mismatch.md
  - ../../../bashscripts/mysql/switch-to-mariadb.sh
---

# Passaggio MySQL → MariaDB

## Perché

Il datadir in `/var/lib/mysql` è **MariaDB 11.8** (`debian-11.8.flag`). Il servizio `mysql.service` (MySQL 8.4) non è il motore corretto per quei file.

## Switch sistema (WSL)

```bash
cd /var/www/_bases/base_ptvx_fila5
sudo bash bashscripts/tools/lamp/install-mariadb.sh
```

(I pacchetti `.deb` sono in `.local/mariadb-install/` — install via `bashscripts/mysql/install-mariadb-system.sh`.)

Effetti:

- `mysql.service` stop + disable
- install `mariadb-server` + `mariadb-client`
- `mariadb.service` enable + start
- utente `marco` / password `marco` con `ALL PRIVILEGES`

Verifica: `sudo systemctl status mariadb`, `mariadb -u marco -pmarco -e "SELECT VERSION();"`

## Laravel

In `laravel/.env` per sviluppo **locale** (non toccare host remoto di rete se diverso):

```env
DB_CONNECTION=mariadb
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ptv_lara
DB_USERNAME=marco
DB_PASSWORD=marco
# opzionale socket: DB_SOCKET=/run/mysqld/mysqld.sock
```

Laravel 13 espone il driver `mariadb` in `config/database.php`. Il driver legacy `mysql` in PDO funziona anche su MariaDB, ma per chiarezza usare `mariadb`.

## Comandi utili

| Azione | Comando |
|--------|---------|
| Stato | `sudo systemctl status mariadb` |
| CLI | `mariadb -u marco -pmarco` |
| Log | `sudo tail -f /var/log/mysql/error.log` |

## Vedi anche

- [mysql-mariadb-datadir-mismatch.md](../memories/mysql-mariadb-datadir-mismatch.md)
- [bashscripts/tools/lamp/](../../../bashscripts/tools/lamp/) — install e check LAMP
- [mariadb-laravel.md](../../../bashscripts/docs/mariadb-laravel.md)
