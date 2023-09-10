mysql --user="root" --password="$MYSQL_ROOT_PASSWORD" <<EOF
CREATE DATABASE $DB_TEST_DATABASE;

CREATE USER $DB_USERNAME@'172.%' IDENTIFIED BY '$DB_PASSWORD';
CREATE USER $PMA_USERNAME@'172.%' IDENTIFIED BY '$PMA_PASSWORD';

GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO $PMA_USERNAME@'172.%';
GRANT ALL PRIVILEGES ON $DB_TEST_DATABASE.* TO $PMA_USERNAME@'172.%';

GRANT ALL PRIVILEGES ON $MYSQL_DATABASE.* TO $DB_USERNAME@'172.%';
GRANT ALL PRIVILEGES ON $DB_TEST_DATABASE.* TO $DB_USERNAME@'172.%';
EOF