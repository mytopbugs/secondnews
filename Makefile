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
  		--network ${laranet} \
  		--volume ${db_volume}:/bitnami/mariadb \
		-v ./install/sql_fields.sql:/docker-entrypoint-initdb.d/sql_fields.sql \
  		bitnami/mariadb:latest
down_network:
	@docker network rm ${laranet}
down_volume_db:
	@docker volume rm ${db_volume}
down_db:
	@docker container stop ${db}
	@docker container rm ${db}