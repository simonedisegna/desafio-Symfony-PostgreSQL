# :computer: Documentação do Projeto DESAFIO Symfony comPostgreSQL  :computer:
## 1. Introdução
Bem-vindo ao sistema CRUD de Empresas com CRUD de Sócios! Este projeto foi desenvolvido como parte de um desafio para criar um sistema de gerenciamento de empresas e seus respectivos sócios. O sistema oferece funcionalidades completas para criar, ler, atualizar e excluir informações de empresas e sócios, além de fornecer uma API para interação programática, com segurança de acesso.

## 2. Funcionalidades Principais
**CRUD de Empresas:**: Este projeto oferece operações CRUD (Create, Read, Update, Delete) para as entidades de Empresa. As funcionalidades incluem:
- Listagem de todas as empresas
- Criação de uma nova empresa
- Visualização de detalhes de uma empresa
- Atualização de informações de uma empresa
- Exclusão de uma empresa

**CRUD de Sócios:**: Além das operações CRUD para empresas, este projeto também oferece operações CRUD para as entidades de Sócio. As funcionalidades incluem:
- Listagem de todos os sócios de uma empresa
- Adição de um novo sócio a uma empresa
- Visualização de detalhes de um sócio
- Atualização de informações de um sócio
- Exclusão de um sócio

**Autenticação de Usuários:**: O projeto também inclui funcionalidades de autenticação de usuários. Os recursos de login são:
- Registro de novos usuários
- Login de usuários existentes
- Logout de usuários

**Endpoints da API:**: A API oferece endpoints para acessar e manipular os dados das empresas e dos sócios de forma programática.

## 3. Exemplos de Uso API 
```bash
GET /api/empresas
```
```bash
	/ 20240406223222
// http://127.0.0.1:38795/api/empresas

[
  {
    "id": 1,
    "nome": "Empresa 1",
    "cnpj": "1251421511",
    "email": "empresa@teste.com",
    "contato": "23456784",
    "endereco": "Endereço completo",
    "socios": [
      {
        "id": 6,
        "nome": "Jurandi Rosa Damasco",
        "cpf": 15245222,
        "contato": "5245522",
        "email": "jurandi@teste.com"
      }
    ]
  },
  {
    "id": 4,
    "nome": "Caldo do Mar LTDA",
    "cnpj": "96346061000184",
    "email": "caldo@teste.com",
    "contato": "(48)8973456778",
    "endereco": "Rua Pio XII, 344 Centro/Tubarão/SC CEP:88704-565",
    "socios": [
      {
        "id": 5,
        "nome": "Rafael Cardoso",
        "cpf": 456733333,
        "contato": "524112552",
        "email": "rafael2@teste.com"
      },
      {
        "id": 4,
        "nome": "Valérica Cardoso",
        "cpf": 11122222,
        "contato": "5678333",
        "email": "teste444@teste.com"
      }
    ]
  }
]
```
## 4. Instalação
1. Clone o repositório do projeto para o seu computador:
```bash
git clone https://gitlab.com/disegna/desafio-vox.git
```
2. Instale as dependências do Composer:
```bash
composer install
```
3. Configure o Banco de Dados:
- Abra o arquivo .env na raiz do projeto.
- Configure as variáveis de ambiente relacionadas ao banco de dados, como DATABASE_URL, de acordo com as configurações do seu ambiente.

4. Crie o Banco de Dados:
```bash
php bin/console doctrine:database:create
```
5. Execute as Migrações:
```bash
php bin/console doctrine:migrations:migrate
```

6. Inicie o Servidor Symfony:
```bash
symfony server:start
```

7. Acesso à API:
Os endpoints da API estão disponíveis no link topo do sistema após esta logado ou acessar
 http://localhost:<porta>/api/empresas.
 
## 5. Estrutura do Banco de dados
### Tabelas Principais

1. **Empresa**
   - Descrição: Esta tabela armazena informações sobre as empresas registradas no sistema.
   - Colunas:
     - `id`		 : Identificador único da empresa (chave primária).
     - `nome`	 : Nome da empresa.
     - `cnpj`	 : Número de CNPJ da empresa.
	 - `email`	 : E-mail da empresa.
	 - `contato` : Contato da empresa.
     - `endereco`: Endereço da empresa.

2. **Socio**
   - Descrição: Esta tabela armazena informações sobre os sócios relacionados às empresas.
   - Colunas:
     - `id`		   : Identificador único do sócio (chave primária).
	 - `empresa_id`: ID da empresa à qual o sócio está relacionado (chave estrangeira para a tabela Empresa).
     - `nome`	   : Nome do sócio.
     - `cpf`	   : Número de CPF do sócio.
     - `email`	   : E-mail de CPF do sócio.

3. **Usuário**
   - Descrição: Esta tabela armazena informações sobre os usuários do sistema.
   - Colunas:
     - `id`: Identificador único do usuário (chave primária).
     - `username`: Nome de usuário.
     - `password`: Senha do usuário (deve ser armazenada com segurança, de preferência como um hash).
	 - `roles`   : Prioridade do usuário(por enquanto, somente usuario normal, podendo haver melhoria no futuro)
     - `nome`    : Nome do usuário.
     - `nome`    : Nome do usuário.
	 
### Relacionamentos

- **Um-para-Muitos**: A tabela Empresa pode ter vários sócios associados a ela, representado pelo relacionamento entre Empresa (um) e Socio (muitos).

### Notas

- A estrutura do banco de dados foi projetada de acordo com os requisitos do projeto "Desafio Vox" e está sujeita a alterações conforme necessário.
- Quaisquer alterações na estrutura do banco de dados devem ser refletidas neste documento e discutidas com a equipe de desenvolvimento.

## 6. Tecnologias Utilizadas
O projeto foi desenvolvido utilizando as seguintes tecnologias:
- PHP: Linguagem de programação amplamente utilizada no desenvolvimento web.
- Symfony: Framework PHP robusto e flexível utilizado para criar aplicativos web e APIs.
- HTML: Linguagem de marcação para a estruturação e apresentação de conteúdo na web.
- CSS: Linguagem de estilo para estilizar elementos HTML.
- PostgreSQL: Sistema de gerenciamento de banco de dados relacional de código aberto.
- JavaScript: Linguagem de programação utilizada para criar interatividade em páginas web.
- Bootstrap: Framework front-end para desenvolvimento de interfaces web responsivas e estilizadas.

**Essas tecnologias foram escolhidas para proporcionar uma base sólida e eficiente para o desenvolvimento do projeto, garantindo segurança, desempenho e uma ótima experiência do usuário.**

## 7. Estrutura do Projeto
- Uma visão geral da estrutura de diretórios e arquivos do projeto.
- Explicação sucinta de cada diretório e sua finalidade.
- Descrição dos principais arquivos e suas funções.

## 8. Telas do sistema
- login
![Disegna](https://gitlab.com/disegna/desafio-vox/-/raw/master/public/img/login.jpg?ref_type=heads)

- Empresa
![Disegna](https://gitlab.com/disegna/desafio-vox/-/raw/master/public/img/empresa.jpg?ref_type=heads)

- Sócios
![Disegna](https://gitlab.com/disegna/desafio-vox/-/raw/master/public/img/socio.jpg?ref_type=heads)