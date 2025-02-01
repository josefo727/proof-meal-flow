FROM webdevops/php-nginx:8.3-alpine

ENV WEB_DOCUMENT_ROOT=/app/public

ENV PHP_DISMOD=bz2,calendar,exiif,ffi,gettext,ldap,mysqli,imap,pdo_pgsql,pgsql,soap,sockets,sysvmsg,sysvsm,sysvshm,shmop,xsl,apcu,vips,yaml,mongodb,amqp

WORKDIR /app

# Installing Node.js and npm
RUN apk add --update nodejs npm

# Installing supervisord and php extensions
RUN apk add --no-cache supervisor \
    && apk add --no-cache php-xml php-mbstring php-intl php-soap php-bcmath php-gd php-xsl

# Copy the supervisord configuration file
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Ensure all of our files are owned by the same user and group.
RUN chown -R application:application .

# Expose port 80
EXPOSE 80
