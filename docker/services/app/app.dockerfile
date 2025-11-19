FROM php:8.4-fpm

ARG DOCKER_USER
ARG DOCKER_UID

ENV DOCKER_USER=${DOCKER_USER}
ENV DOCKER_UID=${DOCKER_UID}

# --- Dependências do sistema ---
RUN apt-get update && apt-get install -y \
    git \
    curl \
    wget \
    build-essential \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nano \
    procps \
    supervisor \
    libzip-dev \
    libicu-dev \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# --- Extensões PHP ---
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets zip intl

# --- Composer ---
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# --- NVM + Node.js + NPM ---
ENV NVM_DIR=/usr/local/nvm
ENV NODE_VERSION=22.3.0

# Instala NVM e Node.js
RUN mkdir -p $NVM_DIR \
 && curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.7/install.sh | bash \
 && . "$NVM_DIR/nvm.sh" \
 && nvm install $NODE_VERSION \
 && nvm alias default $NODE_VERSION \
 && nvm use default

# Adiciona Node e npm ao PATH para todos os shells
ENV PATH=$NVM_DIR/versions/node/v$NODE_VERSION/bin:$PATH

# --- Usuário e permissões ---
RUN useradd -G www-data,root -u $DOCKER_UID -d /home/$DOCKER_USER $DOCKER_USER
RUN mkdir -p /home/$DOCKER_USER/.composer && \
    chown -R $DOCKER_USER:$DOCKER_USER /home/$DOCKER_USER

# --- Extensão Redis ---
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# --- Ajusta PHP-FPM para rodar com DOCKER_USER ---
RUN sed -i "s/user = www-data/user = ${DOCKER_USER}/g" /usr/local/etc/php-fpm.d/www.conf \
 && sed -i "s/group = www-data/group = ${DOCKER_USER}/g" /usr/local/etc/php-fpm.d/www.conf \
 && sed -i "s/user = www-data/user = ${DOCKER_USER}/g" /usr/local/etc/php-fpm.d/www.conf.default \
 && sed -i "s/group = www-data/group = ${DOCKER_USER}/g" /usr/local/etc/php-fpm.d/www.conf.default

# --- Configurações Laravel ---
COPY conf/custom.ini /usr/local/etc/php/conf.d/custom.ini
#COPY conf/supervisor-workers.conf /etc/supervisor/supervisor-workers.conf
COPY conf/entrypoint.sh /entrypoint.sh

# --- Ajusta permissões ---
#RUN chown -R $DOCKER_USER:$DOCKER_USER /etc/supervisor
#RUN mkdir -p /var/run && chown -R $DOCKER_USER:$DOCKER_USER /var/run  comando que nao precisa

#RUN echo "* * * * * ${DOCKER_USER} php /var/www/artisan schedule:run >> /var/www/storage/logs/schedule.log 2>&1" >> /etc/crontab

RUN chmod +x /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

USER $DOCKER_USER
