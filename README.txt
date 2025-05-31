To get the app up and running, in the parent directory run the following 
cd <app_root_dir>
docker-compose up --build

This wil create an image and a docker container running the web app. 

Visit localhost:8080/index.php 

and log in with 
Username: admin
Password: admin

GitHub link 
https://github.com/kalyft/leave_managment_system_php



--- Get into docker containers ----
docker exec -it lms_app bash
docker exec -it lms_db bash


----- Stop an remove docker containers and images --- 
cd <app_root_dir>

docker-compose down


docker volume rm leave_management_php_db_data



----  Tests ---- (NOT COMPLETE)

This is not working. 
TODOs
create App namespace for classes


Tests are supposted to run locally in your machine after the repo checkout. 

With the following run all the existing tests 
vendor/bin/phpunit

To run a specific test use 

vendor/bin/phpunit tests/Unit/ExampleTest.php




