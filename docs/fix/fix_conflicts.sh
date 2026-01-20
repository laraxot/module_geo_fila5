#!/bin/bash

# Script per risolvere conflitti di merge in file PHP
# Risolve automaticamente i conflitti mantenendo la versione più recente (e4940e9b)

do
  echo "Fixing conflicts in $file"
  
  # Rimuove le righe di marcatura del conflitto e mantiene la versione "dopo il merge"
         -e 's/namespace Modules\\Broker\\Filament\\Resources/namespace Modules\\Broker\\Filament\\Clusters\\AltriCluster\\Resources/' \
         -e 's/use Modules\\Broker\\Filament\\Resources\\/use Modules\\Broker\\Filament\\Clusters\\AltriCluster\\Resources\\/' \
         "$file"
done

echo "Tutti i conflitti sono stati risolti!" 
