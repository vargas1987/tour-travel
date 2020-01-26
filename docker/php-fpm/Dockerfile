FROM phpdockerio/php7-fpm:latest
WORKDIR "/altezza-travel"

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive

# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install php7.0-pdo php7.0-mysql php7.0-mysqlnd php7.0-gd php7.0-intl php7.0-odbc php7.0-soap php7.0-xmlrpc php7.0-bcmath php7.0-mbstring
