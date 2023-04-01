up:
	docker build -t rpgal .
    
	docker run -d -p $(PORT_LOC):80 --name=rpgal$(PORT_LOC) -v $(PWD)/api:/var/www/html/api -v $(PWD)/cli:/var/www/html/cli -v $(PWD)/clijs:/var/www/html/clijs rpgal
	docker exec rpgal$(PORT_LOC) composer install --prefer-dist --working-dir=/var/www/html/api/
	docker exec rpgal$(PORT_LOC) composer install --prefer-dist --working-dir=/var/www/html/cli/
	docker exec rpgal$(PORT_LOC) redis-server --daemonize yes
    
down:
	docker rm -f rpgal$(PORT_LOC)

