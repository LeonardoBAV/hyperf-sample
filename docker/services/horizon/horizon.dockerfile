FROM php:8.4-cli

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

# --- Usuário e permissões ---
RUN useradd -G www-data,root -u $DOCKER_UID -d /home/$DOCKER_USER $DOCKER_USER
RUN mkdir -p /home/$DOCKER_USER/.composer && \
    chown -R $DOCKER_USER:$DOCKER_USER /home/$DOCKER_USER

# --- Extensão Redis ---
RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

# --- Configurações Laravel ---
COPY conf/custom.ini /usr/local/etc/php/conf.d/custom.ini
#COPY conf/supervisor-workers.conf /etc/supervisor/supervisor-workers.conf
COPY conf/supervisor-workers.conf /etc/supervisor/supervisord.conf


# --- Ajusta permissões ---
RUN chown -R $DOCKER_USER:$DOCKER_USER /etc/supervisor
RUN mkdir -p /var/log/supervisor \
    && chown -R $DOCKER_USER:$DOCKER_USER /var/log/supervisor

USER $DOCKER_USER

CMD ["supervisord", "-c", "/etc/supervisor/supervisord.conf"]