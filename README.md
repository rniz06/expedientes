# Sistema de Gestión de Expedientes Electronicos

Sistema de gestion de Expedientes Electronicos desarrollado con laravel utilizando ademas el paquete filament

## Tecnologías
- Laravel 11
- Filament 3 

## Requisitos previos

- PHP 8.2 o superior
- Composer
- Una base de datos compatible (MySQL, PostgreSQL, SQLite, etc.) por defecto usamos mysql

## Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/rniz06/expedientes.git
    ```

2. En el directorio Instala las dependencias de Composer:
    ```bash
    composer install
    ```

3. Copia el archivo de configuración .env.example a .env y configura tus variables de entorno:
    ```bash
    cp .env.example .env
    ```

4. Genera una nueva clave de aplicación:
    ```bash
    php artisan key:generate
    ```

5. Realiza las migraciones y ejecuta los seeders:
    ```bash
    php artisan migrate --seed
    ```

6. Ejecutar el comando de shield para generar los roles y permisos para cada modulo:
    ```bash
    php artisan shield:install
    ```

¡Listo! Ahora puedes acceder al sistema en tu navegador web.

# Uso

Una vez instalado, puedes iniciar sesión en el sistema utilizando las siguientes credenciales:

Correo: ronaldalexisniznunez@gmail.com
Contraseña: Rann2006

# Soporte

Ante dudas o consultas contactar al correo ronaldalexisniznunez@gmail.com