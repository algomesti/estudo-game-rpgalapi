up:
	docker build -t rpgal .
	docker run -d -p $(PORT_LOC):80 --name=rpgal$(PORT_LOC) -v $(PWD)/api:/var/www/html rpgal
	docker exec rpgal$(PORT_LOC) composer install --prefer-dist --working-dir=/var/www/html/
	docker exec rpgal$(PORT_LOC) redis-server --daemonize yes
down:
	docker rm -f rpgal$(PORT_LOC)

