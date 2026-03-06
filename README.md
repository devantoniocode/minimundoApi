### 📦 **Minimundo API**

### 📋 **Sobre o Projeto**

Esta API RESTful foi desenvolvida para servir como backend do projeto Minimundo, fornecendo endpoints seguros e eficientes para a gestão de Projetos.


**Principais características:**

*   🛡️ **Autenticação segura:** Utiliza **JWT (JSON Web Tokens)** para gerenciar sessões de usuário de forma stateless e segura.
*   🐳 **Ambiente containerizado:** Totalmente configurado com **Docker** e **Docker Compose**, garantindo consistência entre os ambientes de desenvolvimento, teste e produção.
*   🗄️ **Banco de dados relacional:** Utiliza **MySQL** como sistema de gerenciamento de banco de dados principal.
*   ⚙️ **Framework robusto:** Desenvolvido sobre o **Laravel**, aproveitando seus recursos como Eloquent ORM, migrations, seeders, testes e sistema de rotas.
*   📦 **Disponível no Docker Hub:** Imagem pronta para uso, facilitando o deploy e a distribuição.
*   ✅ **Testado:** Inclui testes unitários para garantir a confiabilidade das funcionalidades principais.



🚀 Guia Rápido de Execução

Pré-requisitos
Docker e Docker Compose instalados

1. Clone o repositório
 - git clone https://github.com/devantoniocode/minimundoApi.git

2. Baixe a imagem do Docker Hub
 - docker pull devantoniomarcos/minimundo_api:1.0

3. Suba os containers com Docker Compose
 - no diretório cd /devantoniocode/minimundoApi rode o comando
 - docker-compose up -d
 
 # Após este comando, caso apresente este erro "...failed to bind host port for 0.0.0.0:3306:172.18.0.2:3306/tcp: address already in use"
  Liste o serviço que está usando a porta 3306 e pare o processo. Feito isto, repita o comando:
  - docker-compose up -d

Este comando inicia:

✅ API Laravel na porta 8000

✅ Banco de dados MySQL na porta 3306

4. Execute o script de setup **no diretório cd /devantoniocode/minimundoApi**
 - ./setup.sh

O script setup.sh executa automaticamente:
 - composer install
 - php artisan migrate
 - ./vendor/bin/phpunit

Configurações iniciais do ambiente

5. Popule o banco de dados
- docker-compose exec api php artisan db:seed

6. Credenciais de acesso **após o seed**
 - E-mail: ominimundo@email.com
 - Senha: 123456

📌 Comandos úteis adicionais

# Ver logs da API
 - docker-compose logs -f api

# Acessar o container da API
 - docker-compose exec api bash

# Parar os containers
 - docker-compose down

# Reiniciar os containers
 - docker-compose restart

# Ver status dos containers
 - docker-compose ps

🌐 Acessar a API
 - http://localhost:8000
