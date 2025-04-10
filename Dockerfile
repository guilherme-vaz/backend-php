# Imagem base com Apache + PHP
FROM php:8.2-apache

# Copia os arquivos para o diretório padrão do Apache
COPY . /var/www/html/

# Dá permissão de leitura ao Apache (se necessário)
RUN chown -R www-data:www-data /var/www/html

# Expor porta 80 (opcional, Render cuida disso)
EXPOSE 80
