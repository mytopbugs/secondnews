laranet := laravel-news-jj-network	
db := mariadb
db_volume := mariadb_data

all_start:
	@$(MAKE) start_network
	@$(MAKE) start_volume_db
	@$(MAKE) start_db

all_down:
	@$(MAKE) down_db
	@$(MAKE) down_volume_db
	@$(MAKE) down_network
	clear

start_network:
	@docker network create ${laranet}
start_volume_db:
	@docker volume create --name ${db_volume}
start_db:
	@docker run -d --name ${db} \
  		--env ALLOW_EMPTY_PASSWORD=yes \
  		--env MARIADB_USER=bn_myapp \
  		--env MARIADB_DATABASE=bitnami_myapp \
		--env MARIADB_ROOT_PASSWORD=my-secret-pw \
  		--network ${laranet} \
  		--volume ${db_volume}:/bitnami/mariadb \
		bitnami/mariadb:latest
start_laravel:
	@docker run -d --name laravel \
  		-p 8000:8000 \
  		--env DB_HOST=${db} \
  		--env DB_PORT=3306 \
  		--env DB_USERNAME=bn_myapp \
  		--env DB_DATABASE=bitnami_myapp \
  		--network ${laranet} \
		--link ${db}:db \
  		--volume ${PWD}/my-project:/app \
  		bitnami/laravel:latest
	@docker exec laravel php artisan migrate
down_laravel:
	@docker container stop laravel
	@docker container rm laravel
down_network:
	@docker network rm ${laranet}
down_volume_db:
	@docker volume rm ${db_volume}
down_db:
	@docker container stop ${db}
	@docker container rm ${db}
kill_all:
	@$(MAKE) down_laravel
	@$(MAKE) all_down
begin_all:
	@$(MAKE) all_start
	@$(MAKE) start_laravel
open_console:
	@docker exec -it laravel bash
open_tinker:
	@docker exec -it laravel php artisan tinker