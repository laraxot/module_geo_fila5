#!/bin/bash
# PHPMD standalone wrapper script
# @see Modules/Xot/docs/phpmd-standalone.md
php "$(dirname "$0")/phpmd.phar" "$@"
