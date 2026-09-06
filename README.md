# Sistema de Academia

Sistema web para gerenciamento de uma academia, desenvolvido como projeto acadêmico.

O sistema permite cadastrar clientes e planos, controlar pagamentos e registrar as entradas e saídas dos clientes.

## Funcionalidades

- Dashboard do sistema
- Cadastro de clientes
- Edição de clientes
- Exclusão de clientes
- Cadastro de planos
- Edição de planos
- Consulta de planos
- Consulta de pagamentos por cliente
- Filtro de pagamentos por status
- Registro de pagamento de parcelas
- Registro de entrada de clientes
- Registro de saída de clientes
- Histórico de acessos dos clientes
- Sistema de mensagens de sucesso e erro
- Registro de erros da aplicação em arquivo de log

## Tecnologias utilizadas

- PHP 8.3
- Apache
- MySQL 8.0
- Docker
- Docker Compose
- HTML5
- CSS3
- Composer
- PDO
- Arquitetura MVC

## Requisitos

Para executar o projeto, é necessário ter instalado:

- Git
- Docker
- Docker Compose

No Windows, pode ser utilizado o Docker Desktop.

O PHP e o MySQL não precisam ser instalados diretamente na máquina, pois o projeto utiliza containers Docker.

## Estrutura do projeto

```text
sistema-academia/
│
├── app/
│   ├── Controllers/
│   ├── Helpers/
│   ├── Models/
│   └── Views/
│
├── config/
│   ├── Database.php
│   └── Migrations.php
│
├── logs/
│   └── .gitkeep
│
├── public/
│   ├── css/
│   ├── .htaccess
│   └── index.php
│
├── routes/
│   └── web.php
│
├── .env
├── .gitignore
├── composer.json
├── composer.lock
├── Dockerfile
├── docker-compose.yml
└── README.md
```

## Instalação e execução

### 1. Clonar o repositório

Abra o terminal e execute:

```bash
git clone URL_DO_REPOSITORIO
```

Depois entre na pasta do projeto:

```bash
cd sistema-academia
```

> Substitua `URL_DO_REPOSITORIO` pelo endereço do repositório no GitHub.

### 2. Configurar o banco de dados

O projeto utiliza um arquivo `.env` para configurar o acesso ao MySQL.

Crie o arquivo `.env` na raiz do projeto com:

```env
MYSQL_HOST=mysql
MYSQL_USER=user
MYSQL_PASSWORD=123456
MYSQL_DATABASE=academia
```

Essas informações são utilizadas pelo Docker Compose para criar e configurar o banco de dados.

### 3. Verificar o Docker

Execute:

```bash
docker --version
```

E:

```bash
docker compose version
```

Se os dois comandos retornarem as versões instaladas, o ambiente está pronto.

### 4. Construir o container da aplicação

Na raiz do projeto, execute:

```bash
docker compose build
```

### 5. Iniciar o sistema

Execute:

```bash
docker compose up -d
```

O parâmetro `-d` faz os containers serem executados em segundo plano.

### 6. Verificar os containers

Execute:

```bash
docker compose ps
```

Os containers da aplicação e do banco de dados devem aparecer em execução.

Os nomes utilizados pelo projeto são:

```text
academia_app
academia_mysql
```

### 7. Acessar o sistema

Abra o navegador e acesse:

```text
http://localhost:8080
```

## Banco de dados

O banco de dados utilizado pelo sistema é o MySQL 8.0.

O banco é criado automaticamente pelo Docker Compose com o nome:

```text
academia
```

As tabelas são criadas automaticamente através do sistema de migrations quando a aplicação é iniciada.

O arquivo responsável pelas migrations é:

```text
config/Migrations.php
```

As principais tabelas são:

```text
planos
clientes
pagamentos
acessos
```
