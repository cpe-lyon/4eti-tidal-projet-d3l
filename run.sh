#!/bin/bash

if [ $# -lt 1 ]; then
    echo "Usage: $0 <command>"
    exit 1
fi

command="$1"
args="${@:2}"

case "$command" in
# database commands
    "db:ip")
        docker inspect -f '{{range.NetworkSettings.Networks}}{{.IPAddress}}{{end}}' "my-postgres-container"
        ;;
    "db:init")
        docker exec my-php-container php "d3l/database/scripts/init.php"
        ;;
    "db:migrate")
        if [ "$args" == "--create" ]; then
            php "d3l/database/scripts/create.php"
            exit 0
        fi
        if [ "$args" == "--execute" ]; then
            php "d3l/database/scripts/execute.php"
            exit 0
        fi
        php "d3l/database/scripts/create.php"
        docker exec my-php-container php "d3l/database/scripts/execute.php"
        ;;

# command not found
    *)
        echo "Command not found: $command"
        ;;
esac
