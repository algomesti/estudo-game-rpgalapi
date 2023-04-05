# RPGAL

## Start e Stop do Serviço

### Start

* Execute:    

	```
	make up -e PORT_LOC={{PORT}}
	```
* onde:    
	
	```
	{{PORT}} = porta local
	```
* exemplo:  
	
	```
	make up -e PORT_LOC=8001
	```

#### Neste caso o serviço subirá na porta ``` 8001 ```

```
localhost:8001/cli/
```

### Stop

* Execute: 

	```
	make down -e PORT_LOC={{PORT}}
	```
* onde:
  
	```
	{{PORT}} = porta local
	```
* exemplo:

	```
	make down -e PORT_LOC=8001
	```

## Visão Geral da Arquitetura



### Tecnologias envolvidas
- PHP
- APACHE
- Redis
- Slim (Framework PHP)

### Instalação (Makefile)
- Faz o build a Imagem Docker
- Instala a app da api 
- Instala a app do cliente
- Inicializa o Redis

### API
#### EndPoints:

##### /api/ ou /api/play/

- Objetivo:
	
> Criar uma sessão no redis com 2 personagens aleatórios de acordo com um arquivo JSON e fornecer um token de identificação.
> > A Criação do personagem soma atributos do personagem de da raca (dois arquivos json)

- Método:
	- GET 
- URI
	- /api/
	- /api/play/
- Parametros:
	- Nenhum
- Exemplos:

	```
	http://localhost:8001/api/
	```
	```
	http://localhost:8001/api/play/
	```
- Exemplo de Resposta:

```

{
	"ttl": 2000,
	"token": "82bb0e19406a4e05fd70b59a11283123",
	"shift": {
		"player1": "56c9cf9307414c3fe94464eee63b8aa8",
		"player2": "d251604746ae432dd829004d423f9ec2",
		"token": "82bb0e19406a4e05fd70b59a11283123",
		"status": "1",
		"shift": "0"
	},
	"player1": {
		"token": "56c9cf9307414c3fe94464eee63b8aa8",
		"weapon_defense": "1",
		"damage_dice": "6",
		"name": "Thorrichsere",
		"code": "4",
		"weapon_name": "Espada Longa",
		"weapon_damage": "2",
		"image": "https:\/\/i.pinimg.com\/originals\/7d\/8e\/7b\/7d8e7b9716732851a9fe3269c627cf3a.jpg",
		"force": "1",
		"agility": "2",
		"weapon_image": "http:\/\/medievalsystem.weebly.com\/uploads\/6\/3\/6\/3\/6363280\/302247112.png",
		"race_name": "human",
		"life": "12"
	},
	"player2": {
		"token": "d251604746ae432dd829004d423f9ec2",
		"weapon_defense": "0",
		"damage_dice": "8",
		"name": "Graelurk",
		"code": "2",
		"weapon_name": "Clava Madeira",
		"weapon_damage": "1",
		"image": "https:\/\/1d4chan.org\/images\/thumb\/d\/d8\/Orc.jpg\/400px-Orc.jpg",
		"force": "2",
		"agility": "0",
		"weapon_image": "https:\/\/baby-ams.weebly.com\/uploads\/2\/4\/4\/6\/24465180\/8983596.jpg?195",
		"race_name": "orc",
		"life": "20"
	}
}
```

##### /api/start/
- Objetivo:
> Iniciar o Jogo verificando quem terá a iniciativa para começar a atacar

- Método:
	- GET 
- URI
	- /api/start/
- Parametros:
	- token (retornado pelo endpoint / ou /play/
- Exemplo:

	```
	http://localhost:8010/api/start/82bb0e19406a4e05fd70b59a11283123
	```
- Exemplo de Resposta:
	
	```
	{
	"ttl": 2000,
	"token": "82bb0e19406a4e05fd70b59a11283123",
	"shift": {
		"player1": "56c9cf9307414c3fe94464eee63b8aa8",
		"player2": "d251604746ae432dd829004d423f9ec2",
		"token": "82bb0e19406a4e05fd70b59a11283123",
		"status": "1",
		"shift": "0",
		"iniciative": "d251604746ae432dd829004d423f9ec2"
	},
	"player1": {
		"token": "56c9cf9307414c3fe94464eee63b8aa8",
		"weapon_defense": "1",
		"damage_dice": "6",
		"name": "Thorrichsere",
		"code": "4",
		"weapon_name": "Espada Longa",
		"weapon_damage": "2",
		"image": "https:\/\/i.pinimg.com\/originals\/7d\/8e\/7b\/7d8e7b9716732851a9fe3269c627cf3a.jpg",
		"force": "1",
		"agility": "2",
		"weapon_image": "http:\/\/medievalsystem.weebly.com\/uploads\/6\/3\/6\/3\/6363280\/302247112.png",
		"race_name": "human",
		"life": "12"
	},
	"player2": {
		"token": "d251604746ae432dd829004d423f9ec2",
		"weapon_defense": "0",
		"damage_dice": "8",
		"name": "Graelurk",
		"code": "2",
		"weapon_name": "Clava Madeira",
		"weapon_damage": "1",
		"image": "https:\/\/1d4chan.org\/images\/thumb\/d\/d8\/Orc.jpg\/400px-Orc.jpg",
		"force": "2",
		"agility": "0",
		"iniciative": "1",
		"weapon_image": "https:\/\/baby-ams.weebly.com\/uploads\/2\/4\/4\/6\/24465180\/8983596.jpg?195",
		"race_name": "orc",
		"life": "20"
	}
}
	```

##### /api/token/

- Objetivo: 
> Pegar a sessão no redis a partir de um token.

- Método:
	- GET 

- URI
	- /api/token/
	
- Parametros:
	- token (retornado pelo endpoint / ou /play/	
- Exemplo:

	```
	http://localhost:8010/api/token/82bb0e19406a4e05fd70b59a11283123
	```
- Exemplo de Resposta:
	
```
{
	"ttl": 1875,
	"token": "82bb0e19406a4e05fd70b59a11283123",
	"shift": {
		"player1": "56c9cf9307414c3fe94464eee63b8aa8",
		"player2": "d251604746ae432dd829004d423f9ec2",
		"token": "82bb0e19406a4e05fd70b59a11283123",
		"status": "1",
		"shift": "0",
		"iniciative": "d251604746ae432dd829004d423f9ec2"
	},
	"player1": {
		"token": "56c9cf9307414c3fe94464eee63b8aa8",
		"weapon_defense": "1",
		"damage_dice": "6",
		"name": "Thorrichsere",
		"code": "4",
		"weapon_name": "Espada Longa",
		"weapon_damage": "2",
		"image": "https:\/\/i.pinimg.com\/originals\/7d\/8e\/7b\/7d8e7b9716732851a9fe3269c627cf3a.jpg",
		"force": "1",
		"agility": "2",
		"weapon_image": "http:\/\/medievalsystem.weebly.com\/uploads\/6\/3\/6\/3\/6363280\/302247112.png",
		"race_name": "human",
		"life": "12"
	},
	"player2": {
		"token": "d251604746ae432dd829004d423f9ec2",
		"weapon_defense": "0",
		"damage_dice": "8",
		"name": "Graelurk",
		"code": "2",
		"weapon_name": "Clava Madeira",
		"weapon_damage": "1",
		"image": "https:\/\/1d4chan.org\/images\/thumb\/d\/d8\/Orc.jpg\/400px-Orc.jpg",
		"force": "2",
		"agility": "0",
		"iniciative": "1",
		"weapon_image": "https:\/\/baby-ams.weebly.com\/uploads\/2\/4\/4\/6\/24465180\/8983596.jpg?195",
		"race_name": "orc",
		"life": "18"
	}
}

```
##### /api/fight/
- Objetivo:
> Lutar e atualizar o redis com resultado do combate.

- Método:
	- GET 

- URI
	- /api/fight/
	
- Parametros:
	- token (retornado pelo endpoint / ou /play/	
- Exemplo:

	```
	http://localhost:8010/api/fight/82bb0e19406a4e05fd70b59a11283123
	```
- Exemplo de Resposta:

```
{
	"player1": {
		"attackSuccess": true,
		"attackdamage": {
			"attack": {
				"dice": "6",
				"force": "1",
				"roll": 4,
				"damage": 5
			},
			"defense": {
				"life": "20",
				"life_update": 15
			}
		}
	},
	"player2": {
		"attackSuccess": true,
		"attackdamage": {
			"attack": {
				"dice": "8",
				"force": "2",
				"roll": 1,
				"damage": 3
			},
			"defense": {
				"life": "12",
				"life_update": 9
			}
		}
	}
}
```


## Expansões:
### Raça
> É possivel expandir as raças adicionando novas raças no json ``` api/json/race ``` 
> > Exemplo de Arquivo Json:

```
[
    {
        "code": "1",
        "name": "orc",
        "force": 2,
        "agility": 0,
        "life": 20,
        "damage_dice":8,
        "image":"https://pre00.deviantart.net/aab5/th/pre/f/2015/226/8/5/orc_boss_enemy_by_babaganoosh99-d95oy3r.png"
    },
    {
        "code": "2",
        "name": "human",
        "force": 1,
        "agility": 2,
        "life": 12,
        "damage_dice":6,
        "image": "https://orig00.deviantart.net/0a19/f/2017/329/5/6/concept_art_carlnes_by_aenaluck-dbuvrv9.jpg"
    }
]

```

### Personagem
> É possivel expandir as personagens adicionando novos personaagens no json ``` api/json/char ``` 
> > Exemplo de Arquivo Json:

```
[
    {
        "code": "1",
        "name": "Lagrendnaz",
        "race_code": 1,
        "weapon": 0,
        "force": 0,
        "agility": 0,
        "life": 0,
        "image": "https://hexcompendium.com/images/thumb/7/74/OrcBrute.png/501px-OrcBrute.png"
    },
    {
        "code": "2",
        "name": "Graelurk",
        "race_code": 1,
        "weapon": 0,
        "force": 0,
        "agility": 0,
        "life": 0,
        "image": "https://1d4chan.org/images/thumb/d/d8/Orc.jpg/400px-Orc.jpg"
    },
    {
        "code": "3",
        "name": "Abrukmuz",
        "race_code": 1,
        "weapon": 0,
        "force": 0,
        "agility": 0,
        "life": 0,
        "image": "https://db4sgowjqfwig.cloudfront.net/campaigns/110358/assets/457154/tumblr_nk86fbMOb71trscm8o1_1280.jpg?1431128630"
    },
    {
        "code": "4",
        "name": "Thorrichsere",
        "race_code": 2,
        "weapon": 1,
        "force": 0,
        "agility": 0,
        "life": 0,
        "image": "https://i.pinimg.com/originals/7d/8e/7b/7d8e7b9716732851a9fe3269c627cf3a.jpg"
    },
    {
        "code": "5",
        "name": "Sammadod",
        "race_code": 2,
        "weapon": 1,
        "force": 0,
        "agility": 0,
        "life": 0,
        "image": "https://i.pinimg.com/564x/36/8f/93/368f93edbe20d8f6d6e08cb8b818470b.jpg"
    },
    {
        "code": "6",
        "name": "Canredcen",
        "race_code": 2,
        "weapon": 1,
        "force": 0,
        "agility": 0,
        "life": 0,
        "image": "https://i.pinimg.com/originals/10/53/58/105358fb7e9404164d97a6ca3f3b85a3.jpg"
    }
]

```

### Arma
> É possivel expandir as armas adicionando novas armas no json ``` api/json/weapon ```  .  É  necessário também informar qual personagem utilizará a arma no json do personagem. 
> > Exemplo de Arquivo Json:

```
[
    {
        "name": "Clava Madeira",
        "damage": 1,
        "defense": 0,
        "image":"https://baby-ams.weebly.com/uploads/2/4/4/6/24465180/8983596.jpg?195"
    },
    {
        "name": "Espada Longa",
        "damage": 2,
        "defense": 1,
        "image": "http://medievalsystem.weebly.com/uploads/6/3/6/3/6363280/302247112.png"
    }
    
]
```
 