FROM php:8.2-fpm-alpine

# Add non-root user
ARG USERNAME=lempdock
ARG USER_UID=1000
ARG USER_GID=${USER_UID}
RUN addgroup -g ${USER_GID} -S ${USERNAME} \
	&& adduser -D -u ${USER_UID} -S ${USERNAME} -s /bin/sh ${USERNAME} \
	&& adduser ${USERNAME} www-data \
    && chown -R ${USERNAME}:www-data /var/www/* \
    && sed -i "s/user = www-data/user = ${USERNAME}/g" /usr/local/etc/php-fpm.d/www.conf \
    && sed -i "s/group = www-data/group = ${USERNAME}/g" /usr/local/etc/php-fpm.d/www.conf

# Install packages and dependencies for PHP extensions
RUN apk add --update \
    $PHPIZE_DEPS \
    libpng-dev freetype-dev libjpeg-turbo-dev libxml2-dev libzip-dev libpq-dev \
    zip \
    openssl \
    vim \
    php-cli \
    php-mbstring \
    unzip \
    php-gd \
    php-zip \
    php-xml \
    php-common \
    php-curl \
    php-bcmath \
    php82-pecl-imagick --repository=https://dl-cdn.alpinelinux.org/alpine/edge/community \
    && apk --update add imagemagick imagemagick-dev

# Install and config PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        gd \
        bcmath\
        exif \
        opcache \
        mysqli \
        pdo \
        pdo_mysql \
        pdo_pgsql \
        zip \
    && pecl install imagick \
    && docker-php-ext-enable opcache imagick zip \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && chown -R ${USERNAME}:${USERNAME} /usr/local/bin/composer
    # It's important can to run composer as non-root user

COPY .docker/php-mydolar/php.ini /usr/local/etc/php/

# Setting vim configuration for root user
COPY ./.docker/.vimrc /root/

# Switch to non-root user
USER ${USERNAME}

WORKDIR /var/www/html

# Setting vim configuration for non-root user
COPY ./.docker/.vimrc /home/${USERNAME}/


#CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
CMD ["php-fpm"]






# FROM php:7.4-apache

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     libpng-dev \
#     libjpeg-dev \
#     libfreetype6-dev \
#     zip \
#     unzip \
#     && docker-php-ext-configure gd --with-freetype --with-jpeg \
#     && docker-php-ext-install gd

# # Enable Apache mod_rewrite
# RUN a2enmod rewrite

# # Set working directory
# WORKDIR /var/www/html

# # Copy project files
# COPY . /var/www/html

# # Install Composer
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Install PHP dependencies
# RUN composer install

# # Expose port 80
# EXPOSE 80

