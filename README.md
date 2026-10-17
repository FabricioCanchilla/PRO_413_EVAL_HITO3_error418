<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

In addition, [Laracasts](https://laracasts.com) contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

You can also watch bite-sized lessons with real-world projects on [Laravel Learn](https://laravel.com/learn), where you will be guided through building a Laravel application from scratch while learning PHP fundamentals.

## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).




# PRO_413_EVAL_HITO3_error418

## 1. Identificación del proyecto

**Nombre:** Sistema de Registro y Control de Solicitudes de Soporte Técnico

**Objetivo:** Desarrollar una aplicación web con PHP y Laravel para registrar solicitudes de soporte técnico, consultarlas y actualizar su estado de atención, usando MySQL en contenedores Docker y enviando los registros a una base de datos MySQL de la red local.

**Descripción:** La aplicación permite registrar solicitudes (solicitante, departamento, descripción, prioridad), listarlas, cambiar su estado (Pendiente, En proceso, Resuelta) y sincronizarlas con una base de datos de destino mediante `upsert`. Se ejecuta con Docker Compose y su imagen está publicada en Docker Hub.

## 2. Integrantes y roles

| Nombre completo | Rol asignado | Usuario de GitHub |
|---|---|---|
| Aranda Silva Alan Cristhofer | Backend Laravel | alanhack777 |
| Quispe Mamani Rosmery | Bases de datos e integración  | rosmeryqm2020-afk |
| Copa Pérez Neyda Milena | Funcionalidad e integracion | Milenacopa120-0409 |
| Canchilla Mamani Fabricio Isaac | Docker, despliegue y documentación | FabricioCanchilla |

**Responsabilidades**

- **Backend Laravel:** modelo, migraciones, rutas, controladores y lógica de registro de solicitudes.
- **Funcionalidad web:** formulario de registro, listado de solicitudes y actualización de estados.
- **Bases de datos e integración:** conexiones MySQL, configuración de la base de datos de destino y envío de registros.
- **Docker, despliegue y documentación:** Dockerfile, Docker Compose, construcción y publicación de la imagen, y documentación técnica.

## 3. Tecnologías utilizadas

- PHP 8.4 y Laravel 13
- MySQL 8.4
- Docker y Docker Compose
- Docker Hub
- Git y GitHub
- Composer

## 4. Funcionalidades implementadas

- **Registro** de solicitudes con validación de datos obligatorios. El estado inicial es siempre `Pendiente`.
- **Listado** de solicitudes con código, solicitante, departamento, descripción, prioridad, estado y fecha de registro.
- **Actualización de estado** entre `Pendiente`, `En proceso` y `Resuelta`.
- **Envío de solicitudes** a la base de datos MySQL de destino de la red local, con `upsert` para evitar duplicados. [COMPLETAR: ruta o comando con que se ejecuta]

Rutas principales:

| Método | Ruta | Acción |
|---|---|---|
| GET | `/` | Listado de solicitudes |
| POST | `/solicitudes` | Registrar una solicitud |
| PUT | `/solicitudes/{id}/estado` | Actualizar el estado |

## 5. Arquitectura

La solución usa dos contenedores definidos en `docker-compose.yml`, conectados por una red propia (`hito3-network`):

| Servicio | Imagen | Función |
|---|---|---|
| `app` | `laravel-service:hito3` (construida con el `Dockerfile` del proyecto) | Aplicación Laravel en el puerto 8000 |
| `db` | `mysql:8.4` | Base de datos MySQL local |

- Los datos de MySQL se guardan en el volumen `dbdata`, por lo que persisten aunque se borre el contenedor.
- La aplicación se conecta a MySQL local usando el nombre del servicio (`DB_HOST=db`), no `localhost`.
- La base de datos de destino está fuera de Docker, en la red local, y se accede por la IP o el host que entregó el docente.

Flujo de información:

```
Usuario -> Laravel (contenedor app) -> MySQL local (contenedor db, volumen dbdata)
                      |
                      +--> upsert --> MySQL de destino (red local)
```

## 6. Requisitos previos

- Docker y Docker Compose instalados
- Git
- Cuenta de GitHub y de Docker Hub
- Acceso a la red local donde está la base de datos de destino
- Credenciales individuales asignadas por el docente

## 7. Variables de entorno

Todas las variables se definen en el archivo `.env`, que **no se versiona**. El archivo `.env.example` contiene la lista completa con los valores vacíos.

| Variable | Descripción |
|---|---|
| `APP_KEY` | Clave de la aplicación Laravel |
| `DB_CONNECTION` | Debe ser `mysql` |
| `DB_HOST` | Host de MySQL local; en Docker es `db` |
| `DB_PORT` | Puerto de MySQL local (3306) |
| `DB_DATABASE` | Nombre de la base de datos local |
| `DB_USERNAME` | Usuario de la base de datos local |
| `DB_PASSWORD` | Contraseña del usuario local |
| `DB_ROOT_PASSWORD` | Contraseña root del MySQL del contenedor |
| `DEST_DB_HOST` | IP o host de la base de datos de destino |
| `DEST_DB_PORT` | Puerto de la base de datos de destino |
| `DEST_DB_DATABASE` | Nombre de la base de datos de destino |
| `DEST_DB_USERNAME` | Usuario asignado por el docente |
| `DEST_DB_PASSWORD` | Contraseña asignada por el docente |

Cada integrante usa únicamente sus propias credenciales de destino. No se comparten entre integrantes ni se escriben en el repositorio.

## 8. Preparación de MySQL

El servicio MySQL se crea e inicia con Docker Compose. Sus credenciales llegan por variables de entorno (`MYSQL_DATABASE`, `MYSQL_USER`, `MYSQL_PASSWORD`, `MYSQL_ROOT_PASSWORD`), tomadas del `.env`. La persistencia se logra con el volumen `dbdata`, montado en `/var/lib/mysql`.

Para verificar las tablas:

```bash
docker compose exec db mysql -u <DB_USERNAME> -p <DB_DATABASE> -e "show tables;"
```

## 9. Preparación de Laravel

1. Clonar el repositorio y copiar el archivo de entorno:
```bash
   git clone https://github.com/<usuario>/PRO_413_EVAL_HITO3_error418.git
   cd PRO_413_EVAL_HITO3_error418
   copy .env.example .env
```
2. Completar el `.env` con los valores locales (ver sección 7).
3. Generar la clave de la aplicación y pegarla en `APP_KEY`:
```bash
   docker compose run --rm app php artisan key:generate --show
```
4. Las dependencias se instalan al construir la imagen (`composer install`).
5. Las migraciones se ejecutan al iniciar el contenedor (`php artisan migrate --force`). También se pueden ejecutar a mano:
```bash
   docker compose exec app php artisan migrate
```

La tabla `solicitudes_soporte` se crea con migración de Laravel y tiene los campos `id`, `solicitante`, `departamento`, `descripcion`, `prioridad`, `estado` (por defecto `Pendiente`), `created_at` y `updated_at`.

## 10. Despliegue con Docker

```bash
# Construir e iniciar los servicios
docker compose up -d --build

# Verificar el estado
docker compose ps

# Ver los registros de la aplicación
docker compose logs app

# Detener los servicios (conserva los datos del volumen)
docker compose down
```

La aplicación queda disponible en `http://localhost:8000`.

Advertencia: `docker compose down -v` elimina también el volumen y borra los datos.

## 11. Conexión y envío de datos

Parámetros necesarios (entregados por el docente): dirección IP o host, usuario, contraseña, puerto y nombre de la base de datos de destino. Se configuran en las variables `DEST_DB_*` del `.env`.

Procedimiento de transferencia: [COMPLETAR]

1. Conexión con la base de datos de destino.
2. Selección de las solicitudes locales a enviar.
3. Inserción o actualización en el destino mediante `upsert`, usando una clave única para no duplicar registros al repetir el envío.
4. Manejo de errores de conexión o escritura.
5. Mensaje con el resultado de la operación.

Método de comprobación: [COMPLETAR: consulta en la base de datos de destino que muestre los registros enviados]

## 12. Publicación en Docker Hub

- Enlace público: `https://hub.docker.com/r/aizaak1423/laravel-service`
- Nombre completo de la imagen: `aizaak1423/laravel-service:hito3`

Construcción, etiquetado y publicación:

```bash
docker login -u aizaak1423
docker build -t laravel-service:hito3 .
docker tag laravel-service:hito3 aizaak1423/laravel-service:hito3
docker push aizaak1423/laravel-service:hito3
```

Descarga:

```bash
docker pull aizaak1423/laravel-service:hito3
```

La imagen no contiene el archivo `.env` (está en `.dockerignore`). Quien la descargue debe proporcionar sus propias variables de entorno.

## 13. Colaboración

Cada integrante trabajó con su propia cuenta de GitHub y realizó commits relacionados con su rol, usando mensajes descriptivos (`feat:`, `build:`, `docs:`).

| Integrante | Aportes | Commits de referencia |
|---|---|---|
| Aranda Silva Alan Cristhofer | Proyecto Laravel, migración, modelo, controlador y rutas [COMPLETAR] | [COMPLETAR] |
| Quispe Mamani Rosmery | Vistas: formulario, listado y cambio de estado [COMPLETAR] | [COMPLETAR] |
| Copa Pérez Neyda Milena | Conexión a la base de destino y envío con upsert [COMPLETAR] | [COMPLETAR] |
| Canchilla Mamani Fabricio Isaac | Dockerfile, docker-compose, .dockerignore, .env.example, publicación en Docker Hub, README | [COMPLETAR] |

## 14. Pruebas

1. Levantar los servicios: `docker compose up -d --build` y comprobar con `docker compose ps` que `app` y `db` están en ejecución.
2. Abrir `http://localhost:8000`.
3. Registrar una solicitud y verificar que aparece en el listado con estado `Pendiente`.
4. Cambiar el estado a `En proceso` y luego a `Resuelta`; verificar que el listado lo refleja.
5. Persistencia: ejecutar `docker compose down` (sin `-v`), luego `docker compose up -d` y comprobar que las solicitudes siguen en el listado.
6. Ejecutar el envío a la base de datos de destino y comprobar el resultado. Ejecutarlo una segunda vez para verificar que no se duplican registros.
7. Descargar la imagen con `docker pull aizaak1423/laravel-service:hito3`.

## 15. Solución de problemas

| Problema | Causa y solución |
|---|---|
| `env file ... .env not found` | Falta el archivo `.env`. Copiar `.env.example` a `.env` y completarlo. |
| `"/composer.lock": not found` al construir | El `Dockerfile` debe estar en la raíz del proyecto Laravel, junto a `composer.json` y `composer.lock`. |
| `requires php >=8.4.1` al construir | La imagen base debe ser PHP 8.4 (`FROM php:8.4-cli`). |
| `Call to undefined function get()` | En `routes/web.php` falta `Route::` antes de `get`. |
| `service "app" is not running` | Los contenedores no están iniciados. Ejecutar `docker compose up -d --build` y revisar `docker compose logs app`. |
| Laravel no usa MySQL | Verificar `DB_CONNECTION=mysql` y `DB_HOST=db` en el `.env`. Laravel usa SQLite por defecto si no se cambia. |
| `tag does not exist` al hacer `docker push` | Etiquetar primero con `docker tag laravel-service:hito3 <usuario>/laravel-service:hito3`, usando el nombre real de la cuenta de Docker Hub. |
| No conecta a la base de destino | Verificar IP, puerto, usuario y contraseña en `DEST_DB_*` y que el equipo esté en la red local autorizada. |

Diagnóstico básico: `docker compose ps`, `docker compose logs app` y `docker compose logs db`.