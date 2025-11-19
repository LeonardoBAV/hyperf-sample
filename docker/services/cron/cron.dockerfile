FROM php:8.4-cli

ARG DOCKER_USER
ARG DOCKER_UID

ENV DOCKER_USER=${DOCKER_USER}
ENV DOCKER_UID=${DOCKER_UID}

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
    cron \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd sockets zip intl

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

WORKDIR /var/www

COPY . .


RUN useradd -u ${DOCKER_UID} -d /home/${DOCKER_USER} ${DOCKER_USER} \
    && mkdir -p /home/${DOCKER_USER} \
    && chown -R ${DOCKER_USER}:${DOCKER_USER} /home/${DOCKER_USER}

RUN echo "* * * * * ${DOCKER_USER} php /var/www/artisan schedule:run >> /var/www/storage/logs/schedule.log 2>&1" >> /etc/crontab

# Executar cron em foreground
CMD ["cron", "-f"]
