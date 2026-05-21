---
title: "MySQL service su datadir MariaDB (exit 1)"
type: memory
tags: [mysql, mariadb, systemd, wsl]
created: 2026-05-21
updated: 2026-05-21
related:
  - ../../../bashscripts/mysql/repair-and-start-mysql.sh
---

# Datadir MariaDB vs servizio mysql

## Sintomo

`sudo systemctl start mysql` → `status=1/FAILURE`, socket `/var/run/mysqld/mysqld.sock` assente.

## Causa (2026-05-21)

Dopo:

```bash
sudo mv /var/lib/mysql /var/lib/mysql.NEW.…
sudo mv /var/lib/mysql-11.8.3-MariaDB /var/lib/mysql
```

il datadir contiene `debian-11.8.flag` (MariaDB 11.8). **mysql.service** (MySQL 8.4) non può montare quel datadir.

## Fix (canonico)

```bash
sudo bash bashscripts/mysql/switch-to-mariadb.sh
```

Disabilita `mysql.service`, installa/avvia **mariadb**, crea `marco`/`marco`. Laravel: `DB_CONNECTION=mariadb`.

How-to: [`switch-mysql-to-mariadb.md`](../how-to/switch-mysql-to-mariadb.md).

## Utente marco

```sql
GRANT ALL PRIVILEGES ON *.* TO 'marco'@'localhost' WITH GRANT OPTION;
GRANT ALL PRIVILEGES ON *.* TO 'marco'@'%' WITH GRANT OPTION;
```
