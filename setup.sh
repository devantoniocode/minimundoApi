#!/bin/bash

echo "🚀 Iniciando configuração do projeto..."
echo "======================================"

echo "📦 Instalando dependências..."
docker-compose exec api composer install

echo "🔑 Gerando chave..."
docker-compose exec api php artisan key:generate

echo "🗄️ Rodando migrations..."
docker-compose exec api php artisan migrate
  
echo "🧪 Rodando testes..."
docker-compose exec api ./vendor/bin/phpunit

echo "✅ Setup completo!"
