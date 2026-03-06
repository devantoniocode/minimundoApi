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
git clone https://github.com/devantoniocode/minimundoApi.git
cd /devantoniocode/minimundoApi

2. Baixe a imagem do Docker Hub
docker pull devantoniomarcos/minimundo_api:1.0

3. Suba os containers com Docker Compose
docker-compose up -d

Este comando inicia:

✅ API Laravel na porta 8000

✅ Banco de dados MySQL na porta 3306

4. Execute o script de setup
./setup.sh

O script setup.sh executa automaticamente:

composer install

php artisan migrate

Configurações iniciais do ambiente

5. Popule o banco de dados
docker-compose exec api php artisan db:seed

6. Verifique se o usuário admin foi criado
docker-compose exec api php artisan tinker
DB::table('users')->where('email', 'ominimundo@email.com')->first();
exit;
Ou acesse o banco diretamente:
docker-compose exec db mysql -u root -p -e "SELECT * FROM ominimundo.users;"
Senha do banco: root

7. Credenciais de acesso
E-mail: (verificar na tabela users após seed)
Senha: 123456

8. Executar testes unitários

docker-compose exec api ./vendor/bin/phpunit

📌 Comandos úteis adicionais

# Ver logs da API
docker-compose logs -f api

# Acessar o container da API
docker-compose exec api bash

# Parar os containers
docker-compose down

# Reiniciar os containers
docker-compose restart

# Ver status dos containers
docker-compose ps

🌐 Acessar a API
http://localhost:8000