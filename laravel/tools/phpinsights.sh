#!/bin/bash
# PHPInsights standalone wrapper script
# Installed in isolated directory to avoid dependency conflicts with main project
# @see Modules/Xot/docs/phpinsights-standalone.md
php "$(dirname "$0")/phpinsights/vendor/bin/phpinsights" "$@"
