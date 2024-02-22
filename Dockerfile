FROM 039794779361.dkr.ecr.eu-central-1.amazonaws.com/jobtech/baseimage:php8.1-composer2.2.22 AS base

###########################################################################
# xDebug:
###########################################################################
ARG INSTALL_XDEBUG=true

RUN if [ ${INSTALL_XDEBUG} = true ]; then \
  # Install the xdebug extension
  pecl install xdebug && \
  docker-php-ext-enable xdebug && \
  touch /tmp/xdebug-error.log && \
  chown ${WORKDIR_USER}:${WORKDIR_GROUP} /tmp/xdebug-error.log \
;fi

# Define your host in .env of local_environment.
ARG XDEBUG_HOST=mac
ENV XDEBUG_HOST ${XDEBUG_HOST}

# This should match the server name on the IDE (by convention use lowercase project name eg jo-listing)
ENV PHP_IDE_CONFIG "serverName=jo-opensearch-support"

# Copy xdebug configuration for remote debugging
COPY ${DOCKER_CONFIG_DIRPATH}/xdebug-${XDEBUG_HOST}.ini /usr/local/etc/php/conf.d/xdebug.ini