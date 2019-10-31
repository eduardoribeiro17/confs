FROM php:7.3.3-fpm-stretch
LABEL teste.version="1.0"
LABEL teste.description="PHP 7.3.3 FPM"
LABEL teste.maintainer="eduardoribeiro17@gmail.com"
LABEL teste.vendor="Rogério M. de Queiroz"
RUN curl -fSL https://downloads.wkhtmltopdf.org/0.12/0.12.5/wkhtmltox_0.12.5-1.stretch_amd64.deb -o wkhtmltopdf.deb 
RUN apt update && apt upgrade -y && \
  apt install xfonts-75dpi \
  xfonts-base \
  wkhtmltopdf \
  libpng-dev \
  libgmp-dev \
  libzip-dev \
  zip \
  libfreetype6-dev \
  libjpeg62-turbo-dev \
  libpq-dev \
  libfaketime -y && \
  dpkg -i wkhtmltopdf.deb && \
  apt clean && \
  apt autoremove -y
RUN docker-php-ext-configure zip --with-libzip && \
  docker-php-ext-configure opcache --enable-opcache && \
  docker-php-ext-configure gd \
  --enable-gd-native-ttf \
  --with-freetype-dir=/usr/include/freetype2 \
  --with-png-dir=/usr/include \
  --with-jpeg-dir=/usr/include && \
  docker-php-ext-install -j$(nproc) pdo pdo_pgsql pgsql bcmath pdo_mysql mysqli opcache zip mbstring gettext calendar sockets gmp gd
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* && \
  rm /var/log/lastlog /var/log/faillog
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === 'a5c698ffe4b8e849a443b120cd5ba38043260d5c4023dbf93e1558871f1f07f58274fc6f4c93bcfd858c6bd0775cd8d1') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN echo "/usr/lib/x86_64-linux-gnu/faketime/libfaketime.so.1" > /etc/ld.so.preload
RUN mkdir /var/www/.composer && \
  chmod 777 -R /var/www/.composer
#Usuário/Grupo www-data
RUN usermod -u 1000 www-data
WORKDIR /usr/share/nginx/html
ENV SERVER_ADMIN eduardoribeiro17@gmail.com