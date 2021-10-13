build:
	cd ./laradock; \
	sudo docker-compose build workspace php-fpm apache2 mysql;
run:
	cd ./laradock; \
	sudo docker-compose up -d mysql php-fpm workspace apache2;
stop:
	cd ./laradock; \
	sudo docker-compose stop;
bash:
	cd ./laradock; \
	sudo docker-compose exec --user=laradock workspace bash;
mysql_shell:
	cd ./laradock; \
	sudo docker-compose exec mysql bash;
