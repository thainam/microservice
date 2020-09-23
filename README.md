# Microservice

## Database Data ##
    - The dump data can be found in ./mysql-dump/database.sql.
    - The database diagram can be found in ./docs/db-diagram.mwb.
    - It will be imported after up the containers in docker.
    - To see database data you can log in to mariadb doing the following:
        - Run command -> docker exec -it db  bash -c "mysql -u root -p"
        - Type the password (found in .env file)
        - Run command -> use microservice;

## Available Routes ##
    - The port 8000 is being used: http://localhost:8000/
    - (GET) /user
    - (POST) /transaction

## Testing Queue ##
    - To make queue works (after insert some transaction), do the following (using Docker):
        - Run command -> docker exec -it microservice-app bash -c "sudo -u root /bin/bash"
        - Run command -> php artisan queue:work
        - Checkout in ./storage/logs the last modified file will contain the message(s).

## Unit Tests ##
    - To run unit tests, do the following (using Docker):
        - Run command -> docker exec -it microservice-app bash -c "sudo -u root /bin/bash"
        - Run command -> "./vendor/bin/phpunit"
