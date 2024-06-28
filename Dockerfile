# Usar a imagem oficial do PHP com Apache
FROM php:8.1-apache

# Instalar dependências necessárias
RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql

# Habilitar mod_rewrite para Laravel e outros frameworks
RUN a2enmod rewrite

# Copiar os arquivos do projeto para o diretório raiz do Apache
COPY . /var/www/html/

# Configurar Apache para servir o diretório de trabalho
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Expor a porta 80
EXPOSE 80
