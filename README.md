# Proyecto Final | CitasCSS_MantPruebas 

### Instrucciones

- Correr docker-compose up --build
- Correr composer install para descargar las dependencias al vendor
- Correr los 2 archivos de las creaciones de las bases de datos.

### Archivo #1.
Contiene la base de datos para correr la pagina (donde correra las pruebas del selenium)
Ubicacion
```sh
/database_init/db_init.php
```
Correr
```sh
php db_init.php
```

#### Archivo #2.
Contiene la base de datos para correr las pruebas unitarias
Ubicacion
```sh
/www/tests/init.php
```
Correr
```sh
php init.php
```

### Notas

Ambos scripts dropean y reconstruyen todas las tablas. 
Algunos tests del selenium solamente se pueden correr 1 vez. Si por alguna razon quisiera correr las pruebas 2 veces o sucede algun error, debera correr el archivo `db_init.php` dentro de `/database_init/` para resetear la base de datos.

Las pruebas unitarias utilizan transactions y rollbacks para no guardar sus cambios permanentemente en la base de datos asi que no habria necesidad de correr el segundo archivo mas de una vez.

Si desea confirmar que las bases de datos se crearon exitosamente, puede entrar al phpmyadmin en `localhost:8080` con el usuario `root` y la contraseña `sa`.