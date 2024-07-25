# Use the official PHP 8.1 CLI image as a base
FROM php:8.1-cli

# Set the working directory
WORKDIR /app

# Install necessary PHP extensions and tools
RUN apt-get update && apt-get install -y \
    git \
    unzip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Add Composer's global bin directory to the PATH
ENV PATH="/root/.composer/vendor/bin:${PATH}"

# Copy the current directory contents into the container
COPY . /app

# Set the entrypoint
ENTRYPOINT ["php", "index.php"]

# Run the PHP CLI by default
CMD ["php", "-a"]


#TODO: the entry point when running docker compose up is the menu. Make it actionable