# Crawler Urban Move

Este projeto consiste em um script em PHP que realiza a extração de dados de leilões do site [https://amleiloeiro.com.br/](https://amleiloeiro.com.br/). Utilizando técnicas de web crawler com cURL e DOMDocument, o script percorre as páginas em busca de informações relevantes sobre lotes, como datas e valores de primeiro e segundo leilão. Os dados são organizados e adicionados a um arquivo CSV para manter um registro estruturado. Além disso, o script registra mensagens de log para acompanhar o processo de extração. Recomenda-se o uso do ambiente Docker para facilitar a execução do script, proporcionando isolamento e portabilidade.

## 🚀 Começando

Essas instruções permitirão que você obtenha uma cópia do projeto em operação na sua máquina local para fins de desenvolvimento e teste.

### 📋 Pré-requisitos

  - 🐳 Docker 
  - 🐳 Docker compose 

### 🔧 Instalação

Primeiramente certifique-se de que possui o docker e o docker compose instalado em sua máquina. Caso não possua acesse o [Guia rápido do WSL2 + Docker](https://github.com/codeedu/wsl2-docker-quickstart) para instalar o docker.

Já para instalar o docker compose acesse [Docker Compose](https://github.com/docker/compose).

Com o docker e o docker compose instalados você deve clonar o repositório. Para isso basta seguir o artigo [Clonando um repositório com Git e GitHub](https://www.alura.com.br/artigos/clonando-repositorio-git-github?utm_term=&utm_campaign=%5BSearch%5D+%5BPerformance%5D+-+Dynamic+Search+Ads+-+Artigos+e+Conte%C3%BAdos&utm_source=adwords&utm_medium=ppc&hsa_acc=7964138385&hsa_cam=11384329873&hsa_grp=111087461203&hsa_ad=687448474447&hsa_src=g&hsa_tgt=aud-396128415587:dsa-843358956400&hsa_kw=&hsa_mt=&hsa_net=adwords&hsa_ver=3&gad_source=1&gclid=Cj0KCQiAhomtBhDgARIsABcaYyk4lBV3raNZ5lwZxwg_6WDWrgMN9njNnww9MI1rKVQUWDZ4sRNlgCcaAifMEALw_wcB).

Com tudo instalado, abra o terminal vá até a pasta do projeto e digite o comando 

```
$ docker-compose run composer require symfony/css-selector
```

Agora você já está pronto para utilizar o código. Para rodar o crawler utilize o seguinte comando:

```
docker-compose run php php bin/crawler.php
```

## 🛠️ Construído com

* `PHP 8.0`
* `cURL (Client URL)`
* `DOMDocument (PHP)`
* `Docker`
* `Git`

## ✒️ Autores

* **Desenvolvedor** - *Código, documentação* - [Vinícius Rodrigues](https://github.com/ViniciusRodrigues10)
