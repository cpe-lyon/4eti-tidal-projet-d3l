#!/bin/bash

if [ $# -lt 1 ]; then
    echo "Usage: $0 <command>"
    exit 1
fi

command="$1"

case "$command" in
# database commands
    "db:ip")
        docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "my-postgres-container"
        echo "you should use this ip in your config.json file"
        ;;
    "db:init")
        php "d3l/database/scripts/init.php"
        ;;
    "db:newMigration")
        php "d3l/database/scripts/newMigration.php"
        ;;
    "db:migrate")
        php "d3l/database/scripts/migrate.php"
        ;;

# command not found
    *)
        echo "Command not found: $command"
        ;;
esac
