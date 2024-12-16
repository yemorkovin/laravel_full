# Используем PHP-образ с Apache
FROM php:8.2-apache

# Устанавливаем необходимые расширения и зависимости
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd mbstring zip pdo_mysql

# Устанавливаем Node.js и npm (LTS версия)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs

    # Устанавливаем ServerName
RUN echo "ServerName localhost" >> /etc/apache2/conf-available/servername.conf \
&& a2enconf servername

# Устанавливаем Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Копируем файлы проекта
COPY . /var/www/html

# Устанавливаем рабочий каталог
WORKDIR /var/www/html

# Устанавливаем права для storage и bootstrap/cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Устанавливаем права для запуска приложения
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Устанавливаем npm зависимости
RUN npm install

# Собираем фронтенд с Vite
RUN npm run build

# Открываем порт для Apache и Vite
EXPOSE 80 5173

# Запускаем Apache
CMD ["apache2-foreground"]
