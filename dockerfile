FROM php:8.2-apache

ARG UID
ARG GID

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

#docker build --network=host --no-cache -t youcode-sprint .

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . /var/www/html/

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - && apt-get install -y nodejs   

COPY package*.json ./

RUN npm install

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

RUN groupadd -g ${GID} laravel && \
    useradd -u ${UID} -g laravel -m -s /bin/bash laravel

RUN usermod -aG www-data laravel


RUN npm install vue@latest @vitejs/plugin-vue


COPY . /var/www/html/

RUN chown -R laravel:www-data /var/www/html \
    && find /var/www/html -type d -exec chmod 775 {} \; \
    && find /var/www/html -type f -exec chmod 664 {} \; \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
