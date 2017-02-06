## AprendiendoSymfony3
========================

Proyecto para hacer pruebas y actualizar conocimientos a Symfony 3 viniendo
desde Symfony 2 o desde cero

# Configuración e instalación

- Modificar dev para acceder desde tu red

	vim web/app_dev.php

- Instalar vendor 	

	composer.phar install

- Configurar base de datos sino lo ha hecho composer

	vim app/config/parameters.yml

- Cargar la estructura de ACL en la base de datos

	php bin/console init:acl

- Cargar los datos iniciales (fixtures)

	php bin/console doctrine:fixtures:load

# Temario inicial

1. Instalacion

2. Rutas y peticiones       url/

	Ruta Simple
	Enlace twig
	Ruta filtrada a solo GET
	Parametrizacion
	Request object

3. TWIG                     url/pantalla

	Anidacion
	Variables
	Flujo (if, for,)
	Manejo de formato

4. Form                     url/formulario

	Crear un form
	Validarlo
	Establecer errores en la definicion
	Disparar errores en el controller

5. Base de datos            url/basedatos

	Entidad
	Relacion con otra entidad
	CRUD
	Entities
	Configuracion y despliegue en la base de datos
	Validaciones
	Validaciones personalizadas

6. Seguridad                url/seguridad

	https://diego.com.es/configuracion-de-la-seguridad-en-symfony

	Crear Entity de seguridad
	Definir en el firewall zonas seguras
	Definir zonas de acceso libre

7. ACL                      url/acl

	http://gitnacho.github.io/symfony-docs-es/cookbook/security/acl.html

	Definir objetos y propietarios de objetos con ACL
	Desaciar/Asociar y comprobar ACL de usuarios
	Haciendolo creando un contexto de seguridad que no sea el del usuario
	cargado en ese momento en session


8. Servicios                url/servicio

	Crear un servicio e injectar dependecias (doctrine, twig, etc...)

9. Session - pendiente

	Gestionar variables de sesion

10. El objeto FINDER - pendiente

Temario extendido

...

A Symfony project created on January 21, 2017, 6:33 pm.
