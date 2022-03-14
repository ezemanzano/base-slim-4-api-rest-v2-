# Liouapi - API REST

Versión 1.0 

## Especificaciones

Este proyecto fue desarrollado con la finalidad de usarse servicio de api rest  a través del uso de contenedores de docker en las instancias local, qa y producción. (Basado en https://github.com/maurobonfietti/slim4-api-skeleton/)

El proyecto usa 3 contenedores independientes para el manejo del backend, la bbddd y phpmyadmin

Algunas de las tecnologías involucradas en el desarrollo son:

1. Contenedor Api

- Ubuntu  [latest](https://hub.docker.com/_/ubuntu)
- Apache 2
- PHP 8.0.5
- Slim 4
- Composer 2.0.14 o superior
- Docker 20.10.6 o superior
- Docker Compose 1.17.1 o superior

2. Contenedor Mysql

- Mysql - Mariadb [latest](https://hub.docker.com/_/mariadb)

4. Contenedor PhpMyadmin

- PhpMyAdmin [latest](https://hub.docker.com/_/phpmyadmin)

## Instancia local

#### Agregar nueva

1. Asegurese de tener instalado docker, dockerfile y composer.
2. Crea el archivo .env con `cp app/.env-example app/.env`
3. Crea el archivo docker-compose.yml con `cp docker-compose.example.yml docker-compose.yml`
4. Corra el docker-compose-file para crear las nuevas instancias con `sudo docker-compose up -d`.
5. Acceda a la instancia de la api con `sudo docker exec -it liouapi bash`.
6. Proporcionele a apache los permisos necesarios con para app con `chown -R www-data /var/www/app`.
7. Instale las dependecias de composer usando `composer install`
6. Finalmente corrar el comando de migraciones para crear las tablas en su bbdd local y agregar los datos de inicio de ser necesario con `php vendor/bin/phinx migrate && php vendor/bin/phinx seed:run`

## Migraciones

Este proyecto además cuenta con la integración del paquete [phinx](https://book.cakephp.org/phinx/0/en/index.html) para el manejo de migraciones de bbdd.

## Licencia 📄

Este es un proyecto privado - mira el archivo [LICENSE.md](LICENSE.md) para detalles

---

⌨️ por [Libre Opcion Team](https://github.com/LibreOpcion) 