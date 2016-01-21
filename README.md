# auto-provisionamiento
Sistema de autoprovisionamiento para teléfonos IP

Colección de scripts y plantillas utilizadas para crear sistemas de autoprovisionamiento para teléfonos IP de diferentes marcas.

Por el momento, solo están soportados teléfonos Yealink, Aastra, y Cisco SPA.

Archivos:
+ macs.csv: Archivo separado por comas con los datos de los telédono y extensiones que se utilizará para la creación de los archivos de configuración, la descripción del formato se explica más adelante.
+ config.inc.php: Archivo con variables de configuración.
+ macs.php: Executable que tomará la información de config.inc.php y macs.csv para crear los archivos que tomarán los teléfonos al hacer el provisionamiento.
+ templates/*: Las plantillas para la creación de los archivos según la marca de los teléfonos.

Requisitos:
  - php-cli  

Formato de uso:
	\# php macs.php [plantilla] [archivo csv]

Donde:
	[plantilla]		aastra, yealink o cisco (default: yealink)
	[archivo csv]	archivo que contiene la relación de macs y extensiones (default: macs.csv)

Ejemplo:
	php macs.php yealink macs.csv
	php macs.php aastra 


Formato de archivo macs.csv
*******************************
La primera fila del archivo debe ser un encabezado. No importa el orden

	Encabezado		Campo
	-------------------------------------------------------------------------
	mac 		    	MAC Address
	extension	  	Extension
	display_name	Nombre de la persona [opcional, se toma de la BD]
	secret		  	Contraseña de la extensión [opcional, se toma de la BD]
	ipaddress		  Dirección IP [opcional]
	netmask		  	Máscara de red [opcional]
	gateway	  		Gateway [opcional]	
  
