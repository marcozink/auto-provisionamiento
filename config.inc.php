<?php
/* Archivo de configuración */

// Si utilizaremos las tablas de FreePBX para hacer la generación de configuración.
// Si se configura en FALSE, se utilizarán los datos contenidos en el archivo macs.csv
$freepbx 	= TRUE;

// Directorio donde se pondran los archivos destinos
$dir    	= '/tftpboot/';

// Activar si deseamos que se cree el archivo de directorio automáticamente
// directorio-yealink.xml o directorio-aastra.csv
$crear_directorio = TRUE;

// Nombre del archivo que contiene la relación MACs y teléfonos
// Puede ser sobreescrito por el segundo argumento de invocacion del macs.php
$mac_file 	= 'macs.csv';

// Caracter separador del CSV
$separador = ',';

// Dirección IP del servidor definitivo que ofrecerá el servicio de VoIP
// NO NECESARIAMENTE ES EL MISMO SERVIDOR DESDE EL QUE SE DESCARGA EL ARCHIVO DE CONFIGURACIÓN
$server_ip	= '192.168.1.90';

// Máscara de red. Solo se usa si configuramos IPs fijas en cada telefono
$netmask	= '255.255.255.0';

// Datos de conexión a la BD
$dbname = 'freepbx';
$dbhost = 'localhost';
$dbuser = 'freepbxuser';
$dbpass = 'freepbxpass';


// Activar debug
$debug	= TRUE;
