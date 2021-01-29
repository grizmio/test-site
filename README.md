
# Las credenciales usadas son de ejemplo y deben ser cambiadas por otras mas seguras

## Requerimientos
- PHP 7.4 como minimo
- PHP PDO MySQL
- MariaDB 10
- En Alpine Edge los paquetes necesarios son: php7 php7-pdo_mysql php7-mbstring php7-session php7-json php7-ctype
- PHP con short_open_tag "on"

## Si se quiere usar docker la imagen debe tener disponible php 7.4, por eso se usa alpine:edge
```SH
docker build -t foophp
docker run --rm -ti -e DATABASE_DSN="mysql:host=172.19.0.1;dbname=footest;charset=UTF8" -e DATABASE_PASSWORD=1234 -e DATABASE_USER='root' -e JWT_SECRET='supersecreto' -e USER_SESSION_TIMEOUT=180 -p 8080:80 foophp
```

## Para ejecutar sin docker
```SH
docker run -d -p 3306:3306 --name footest -e MYSQL_ROOT_PASSWORD=1234 -e MYSQL_DATABASE=footest mariadb:10.5.8-focal
docker exec -i footest mysql -u root -p1234 footest < db.sql
$ export DATABASE_DSN="mysql:host=127.0.0.1;dbname=footest;charset=UTF8"
$ export DATABASE_PASSWORD=1234
$ export DATABASE_USER='root'
$ export JWT_SECRET='Soy un super secreto'
$ export USER_SESSION_TIMEOUT=180 # segundos
$ php -S 127.0.0.1:8080 bootstrap.php
```

## Cambiar contraseña de admin
```SH
$ TOKEN=$(curl -H "Content-Type: application/json" --request POST --data '{"name":"admin", "password":"admin"}' http://127.0.0.1:8080/api/login) ; echo $TOKEN
$ curl -H "Content-Type: application/json" -H "Authorization: Bearer ${TOKEN}" --request PUT --data '{"name":"admin", "password":"adminadmin"}' http://127.0.0.1:8080/api/users/1
```

## Para crear un usuario
```SH
$ TOKEN=$(curl -H "Content-Type: application/json" --request POST  --data '{"name":"admin", "password":"admin"}' http://127.0.0.1:8080/api/login) ; echo $TOKEN
$ curl -v -H "Content-Type: application/json" -H "Authorization: Bearer ${TOKEN}" --request POST   --data '{"name":"John","lastname":"Spartan","email":"grizmio@gmail.com","password":"12345678"}' http://127.0.0.1:8080/api/users
```

## Usuario administrador
Nombre de usuario: admin
Contraseña: admin
Correo electrónico: admin@foo.com

## El archivo routes_config.php
En este archivo se configuran las rutas del sitio
