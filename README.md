# Sistema de Academia

Sistema web para gerenciamento de uma academia, desenvolvido como projeto acadêmico.

## Funcionalidades

- Dashboard
- Cadastro, edição e exclusão de clientes
- Cadastro e edição de planos
- Controle de pagamentos
- Filtro de pagamentos por status
- Registro de entrada e saída de clientes
- Histórico de acessos
- Mensagens de sucesso e erro
- Registro de erros em log

## Tecnologias

- PHP 8.3
- Apache
- MySQL 8.0
- Docker
- Docker Compose
- Composer
- PDO
- HTML5
- CSS3
- MVC

## Requisitos

- Git
- Docker
- Docker Compose
- Composer

PHP e MySQL não precisam ser instalados diretamente na máquina, pois são executados através do Docker.

## Estrutura

```text
sistema-academia/
├── app/
│   ├── Controllers/
│   ├── Helpers/
│   ├── Models/
│   └── Views/
├── config/
│   ├── Database.php
│   └── Migrations.php
├── logs/
│   └── .gitkeep
├── public/
│   ├── css/
│   ├── .htaccess
│   └── index.php
├── routes/
│   └── web.php
├── .env
├── .gitignore
├── composer.json
├── composer.lock
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## Instalação

### 1. Clonar o projeto

```bash
git clone URL_DO_REPOSITORIO
cd sistema-academia
```

### 2. Instalar o Composer

Execute na raiz do projeto:

```bash
composer install
```

Para instalar as depedências

### 3. Configurar o `.env`

Crie o arquivo `.env` na raiz do projeto:

```env
MYSQL_HOST=mysql
MYSQL_USER=user
MYSQL_PASSWORD=123456
MYSQL_DATABASE=academia
```

### 4. Construir os containers

```bash
docker compose build
```

### 5. Iniciar o sistema

```bash
docker compose up -d
```

### 6. Verificar os containers

```bash
docker compose ps
```

Os containers utilizados são:

```text
academia_app
academia_mysql
```

### 7. Acessar o sistema

Abra:

```text
http://localhost:8080
```

## Banco de dados

O sistema utiliza MySQL 8.0.

O banco utilizado é:

```text
academia
```

As tabelas são criadas automaticamente pelas migrations quando a aplicação é iniciada.

Arquivo responsável:

```text
config/Migrations.php
```

Principais tabelas:

```text
planos
clientes
pagamentos
acessos
```

## Autor

Francisco Martins Gonçalves Gomes
