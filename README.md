# Sistema de Produtos (PHP + MySQL)

Projeto simples de gerenciamento de produtos com autenticação de usuário, desenvolvido em PHP puro com MySQL.

## Tecnologias

- PHP puro (sem framework)
- MySQL
- HTML
- CSS
- Bootstrap 5 (CDN)
- PDO
- Sessão PHP

## Estrutura

```text
/sistema-php-crud
│
├── index.php
├── login.php
├── logout.php
├── dashboard.php
│
├── config/
│   └── database.php
│
├── database/
│   └── schema.sql
│
├── includes/
│   ├── auth.php
│   ├── header.php
│   └── footer.php
│
├── produtos/
│   ├── index.php
│   ├── create.php
│   ├── store.php
│   ├── edit.php
│   ├── update.php
│   └── delete.php
│
└── assets/
    └── css/
        └── style.css
```

## Como configurar o banco

1. Crie um banco MySQL local (ou use o que já tiver).
2. Importe o arquivo `database/schema.sql` no MySQL.
3. O script cria o banco `sistema_produtos`, as tabelas `usuarios` e `produtos`, e um usuário padrão.

## Configuração da conexão

Edite o arquivo `config/database.php` e ajuste:

- `host`
- `port`
- `dbName`
- `username`
- `password`

## Como acessar o sistema

1. Coloque o projeto no diretório do servidor local (ex.: `htdocs` no XAMPP).
2. Inicie Apache e MySQL.
3. Acesse no navegador o caminho do projeto, por exemplo:

```text
http://localhost/sistema-php-crud/
```

## Login padrão

- E-mail: `admin@admin.com`
- Senha: `123456`
