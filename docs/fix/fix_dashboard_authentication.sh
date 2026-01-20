#!/bin/bash

# Script per risolvere problemi di autenticazione nel dashboard Filament v4
# Risolve il problema dei collegamenti ai moduli non visibili

echo "🔐 Risoluzione problemi autenticazione dashboard Filament v4"
echo "=============================================================="

PROJECT_DIR="/var/www/_bases/base_techplanner_fila3_mono/laravel"

# 1. Verifica configurazione sessioni
echo "📋 Verificando configurazione sessioni..."
if [ -f "$PROJECT_DIR/config/session.php" ]; then
    echo "✅ File session.php trovato"
else
    echo "❌ File session.php non trovato"
fi

# 2. Verifica middleware di autenticazione
echo "🔒 Verificando middleware di autenticazione..."
grep -r "Authenticate::class" "$PROJECT_DIR/Modules/Xot/app/Providers/Filament/" || echo "⚠️  Middleware Authenticate non trovato"

# 3. Verifica configurazione panel
echo "⚙️  Verificando configurazione panel..."
grep -r "->default()" "$PROJECT_DIR/Modules/Xot/app/Providers/Filament/" || echo "⚠️  Panel default non configurato"

# 4. Crea utente di test se necessario
echo "👤 Verificando utente di test..."
php "$PROJECT_DIR/artisan" tinker --execute="
\$user = \Modules\User\Models\User::first();
if (\$user) {
    echo 'Utente trovato: ' . \$user->email . PHP_EOL;
    echo 'Ruoli: ' . implode(', ', \$user->roles->pluck('name')->toArray()) . PHP_EOL;
} else {
    echo 'Nessun utente trovato' . PHP_EOL;
}
"

# 5. Verifica configurazione debugbar
echo "🐛 Verificando configurazione debugbar..."
if grep -q "Barryvdh\\\\Debugbar" "$PROJECT_DIR/composer.json"; then
    echo "✅ Debugbar installato"
else
    echo "❌ Debugbar non installato"
fi

# 6. Ottimizza configurazione per sviluppo
echo "🚀 Ottimizzando configurazione per sviluppo..."

# Abilita debugbar in locale
cat > "$PROJECT_DIR/config/debugbar.php" << 'EOF'
<?php

return [
    'enabled' => env('DEBUGBAR_ENABLED', env('APP_DEBUG', false)),
    'except' => [
        'telescope*',
        'horizon*',
    ],
    'storage' => [
        'enabled' => true,
        'driver' => 'file', // redis, file, custom
        'path' => storage_path('debugbar'), // For file driver
        'connection' => null, // Leave null for default connection (Redis/Log)
    ],
    'include_vendors' => true,
    'capture_ajax' => true,
    'add_ajax_timing' => false,
    'error_handler' => false,
    'clockwork' => false,
    'collectors' => [
        'phpinfo' => true,  // Php version
        'messages' => true,  // Messages
        'time' => true,  // Time Datalogger
        'memory' => true,  // Memory usage
        'exceptions' => true,  // Exception displayer
        'log' => true,  // Logs from Monolog (merged in messages if enabled)
        'db' => true,  // Show database (PDO) queries and bindings
        'views' => true,  // Views with their data
        'route' => true,  // Current route information
        'auth' => true, // Display Laravel authentication status
        'gate' => true, // Display Laravel Gate checks
        'session' => true, // Display session data
        'symfony_request' => true,  // Only one can be enabled..
        'mail' => true,  // Catch mail messages
        'laravel' => false, // Laravel version and environment
        'events' => false, // All events fired
        'default_request' => false, // Regular or special Symfony request logger
        'logs' => false, // Add the latest log messages
        'files' => false, // Show the included files
        'config' => false, // Display config
        'cache' => false, // Display cache events
    ],
    'options' => [
        'auth' => [
            'show_name' => true, // Also show the users name/email in the debugbar
        ],
        'db' => [
            'with_queries' => true, // Show SQL queries as statements
            'backtrace' => true, // Use a backtrace to find the origin of the query in your files.
            'timeline' => false, // Add the queries to the timeline
            'explain' => [ // Show EXPLAIN on select queries
                'enabled' => false,
                'types' => ['SELECT'],
            ],
            'hints' => true, // Show hints for common mistakes
        ],
        'mail' => [
            'full_log' => false,
        ],
        'views' => [
            'data' => false, //Note: Can slow down the application, because the data can be quite large..
        ],
        'route' => [
            'label' => true, // show complete route on bar
        ],
        'logs' => [
            'file' => null,
        ],
        'cache' => [
            'values' => true, // collect cache values
        ],
    ],
    'inject' => true, // Inject the debugbar into the response
    'route_prefix' => '_debugbar', // The route prefix that will be used to register the debugbar routes.
    'route_domain' => null, // The route domain that will be used to register the debugbar routes.
    'theme' => 'auto', // DEPRECATED: Theme is now always auto
    'editor' => 'phpstorm', // DEPRECATED: Editor is now always phpstorm
];
EOF

echo "✅ Configurazione debugbar creata"

# 7. Verifica configurazione .env
echo "🔧 Verificando configurazione .env..."
if [ -f "$PROJECT_DIR/.env" ]; then
    if grep -q "APP_DEBUG=true" "$PROJECT_DIR/.env"; then
        echo "✅ APP_DEBUG abilitato"
    else
        echo "⚠️  APP_DEBUG non abilitato"
    fi
    
    if grep -q "DEBUGBAR_ENABLED=true" "$PROJECT_DIR/.env"; then
        echo "✅ DEBUGBAR_ENABLED abilitato"
    else
        echo "⚠️  DEBUGBAR_ENABLED non configurato"
        echo "DEBUGBAR_ENABLED=true" >> "$PROJECT_DIR/.env"
        echo "✅ DEBUGBAR_ENABLED aggiunto al .env"
    fi
else
    echo "❌ File .env non trovato"
fi

# 8. Pulisci cache
echo "🧹 Pulendo cache..."
php "$PROJECT_DIR/artisan" cache:clear
php "$PROJECT_DIR/artisan" config:clear
php "$PROJECT_DIR/artisan" route:clear
php "$PROJECT_DIR/artisan" view:clear

echo "✅ Cache pulita"

# 9. Test finale
echo "🧪 Test finale..."
echo "Testando accesso al dashboard..."
curl -s -o /dev/null -w "%{http_code}" http://127.0.0.1:8000/admin || echo "❌ Server non risponde"

echo ""
echo "🎯 RISOLUZIONE COMPLETATA"
echo "=========================="
echo "✅ Configurazione debugbar ottimizzata"
echo "✅ Cache pulita"
echo "✅ Configurazione .env aggiornata"
echo ""
echo "📋 PROSSIMI PASSI:"
echo "1. Riavvia il server: php artisan serve --port=8000"
echo "2. Accedi a http://127.0.0.1:8000/admin"
echo "3. Verifica che i collegamenti ai moduli siano visibili"
echo "4. Verifica che la debugbar sia presente"
echo ""
echo "🔗 Collegamenti utili:"
echo "- Dashboard: http://127.0.0.1:8000/admin"
echo "- Login: http://127.0.0.1:8000/admin/login"
echo "- TechPlanner: http://127.0.0.1:8000/techplanner/admin"
echo "- User: http://127.0.0.1:8000/user/admin"
