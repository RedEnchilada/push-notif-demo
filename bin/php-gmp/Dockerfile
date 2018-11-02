FROM php:7.2

RUN apt-get update && \
    apt-get install -y --no-install-recommends --no-install-suggests libgmp-dev && \
    ln -s /usr/include/x86_64-linux-gnu/gmp.h /usr/local/include/ && \
    docker-php-ext-configure gmp && \
    docker-php-ext-install gmp && \
    #
    # Cleanup
    apt-get remove -y && \
    apt-get autoremove -y && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*
