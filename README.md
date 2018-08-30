# rpgalapi

Start:

make up -e PORT_LOC={{PORT}}

onde {{PORT}} = porta local

exemplo

make up -e PORT_LOC=8001

Subirá na porta 8001 

o serviço ficará acessível em 

localhost:8001/public

Stop

make down -e PORT_LOC={{PORT}}

onde {{PORT}} = porta local

exemplo

make down -e PORT_LOC=8001
