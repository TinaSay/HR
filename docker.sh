#!/usr/bin/env sh

. ./.env

do_exec() {
    docker exec -i --user="$APACHE_RUN_USER:$APACHE_RUN_GROUP" "$CONTAINER_NAME" "$@"
}

do_cron() {
    docker exec -i "$CONTAINER_NAME" crontab -u "$APACHE_RUN_USER" "$@"
}

do_mysql_backup() {

    umask 177

    CONTAINER="$CONTAINER_NAME-mysql"

    DIRECTORY="docker/server/backup"
    if ! [ -d "$DIRECTORY" ]
    then
        mkdir --mode=0700 --parents "$DIRECTORY"
    fi

    if [ -z "$1" ]
    then
        DATE=$(date +"%Y-%m-%d %H:%M")
        COMMAND="$DIRECTORY/$MYSQL_DATABASE-$DATE.sql.gz"
    else
        COMMAND="$1"
    fi

    docker exec "$CONTAINER" /usr/bin/mysqldump --single-transaction --no-create-db --verbose --user="$MYSQL_USER" --password="$MYSQL_PASSWORD" "$MYSQL_DATABASE" | gzip > "$COMMAND"

    find "$DIRECTORY" -type f -mtime +3 -exec rm {} \;

    echo "Done!"
}

do_mysql_restore() {

    CONTAINER="$CONTAINER_NAME-mysql"

    DIRECTORY="docker/server/backup"
    if ! [ -d "$DIRECTORY" ]
    then
        mkdir --mode=0700 --parents "$DIRECTORY"
    fi

    if [ -z "$1" ]
    then
        FILE=$(ls "$DIRECTORY" -t | head -1)
        COMMAND="$DIRECTORY/$FILE"
    else
        COMMAND="$1"
    fi

    gunzip < "$COMMAND" | docker exec -i "$CONTAINER" /usr/bin/mysql --verbose --user="$MYSQL_USER" --password="$MYSQL_PASSWORD" "$MYSQL_DATABASE"

    echo "Done!"
}

case "$1" in

    exec)
        shift
        do_exec $@
        ;;

    cron)
        shift
        do_cron $@
        ;;

    mysql-backup)
        shift
        do_mysql_backup $@
        ;;

    mysql-restore)
        shift
        do_mysql_restore $@
        ;;

    *)
    echo "Usage: docker.sh [exec|cron|mysql-backup|mysql-restore]"
    ;;

esac
