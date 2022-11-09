# web y api herbolario
BD compuesta por tablas que reflejan plantas, sus usos, los herbolarios donde se pueden encontrar y el precio; ademas de otra info de utilidad.
Api con acceso JWT, con los endpoints nesesarios para interactuar con la informacion en la BD.
Web inicial donde realizar las operaciones basicas sobre la BD

# Instalación:
1- Clonar el proyecto con Git clone

2- Ejecutar composer install

3- Volcar la salva de la bd, que se encuentra en la carpeta doc/

4- Cambiar la configuración de acceso a la db DATABASE_URL=mysql://root:alexandra2016@127.0.0.1:3306/plantas_usos?serverVersion=8

5- Ejecutar symfony server:start

# Probar el proyecto:
1- Importar la colección de Postman que se encuentra en la carpeta doc/ en la misma se encuentran ejemplos de cada una de las peticiones.

2- Endpoint JWT https://127.0.0.1:8000/api/login_check
{"username": "administrator@herbolario.com","password": "admin"}

3- En el caso de la web ingresar a http://127.0.0.1:8000/, e interactuar añadiendo, editando y eliminando informacion sobre el modelo.