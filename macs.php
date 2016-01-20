#!/usr/bin/php -q
<?php
/***************************************************************
  Generador de archivos de configuración para teléfonos Aastra
	Este archivo no debe modificarse. Todo debe estar contenido en el 
	config.inc.php dentro de este mismo directorio
****************************************************************
	Formato de uso:
		./macs.php [plantilla] [archivo csv]
	Donde:
		[plantilla]		aastra, yealink o cisco (default: yealink)
		[archivo csv]	archivo que contiene la relación de macs y extensiones (default: macs.csv)

	Ejemplo:
		./macs.php yealink macs.csv
		./macs.php aastra 


	Formato de archivo macs.csv
	*******************************
	La primera fila del archivo debe ser un header. No importa el orden
	Header			Campo
	mac 			MAC Address
	extension		Extension
	display_name	Nombre de la persona [opcional, se toma de la BD]
	secret			Contraseña de la extensión [opcional, se toma de la BD]
	ipaddress		Dirección IP [opcional]
	netmask			Máscara de red [opcional]
	gateway			Gateway [opcional]	
*/

require_once('config.inc.php');

$valid_headers = array('mac','extension','ipaddress','netmask','gateway','display_name','secret');

// Tomamos la plantilla a partir de lo que el usuario proporcionó
if (in_array(@$argv[1],array('yealink','aastra','cisco'))) {
	echo "Utilizando plantilla para ".$argv[1] . "\n";
	$template_name = $argv[1];
}
else {
	echo "No se especificó una plantilla correcta. Utilizando Yealink\n";
	$template_name = 'yealink';
}

// Sobreescribimos el archivo de macs
if ((isset($argv[2])) && (file_exists($argv[2])))
	$mac_file = $argv[2];

// Si no existe el archivo de plantilla, terminar
if (!file_exists($template_dir . "template.$template_name.php"))
	die("No existe el archivo template.$template_name.php. Terminando.");
if (!file_exists($mac_file))
	die("No existe archivo de direcciones MAC. Abortando.");


// Intento de conexión a la BD
if ($freepbx) {
	$link = mysql_connect($dbhost,$dbuser,$dbpass);
	if (!$link)
		die('No pudo conectarse a la base de datos');
	if (!mysql_select_db($dbname))
		die('No se tiene acceso a la base de datos '.$dbname . "\n");


	$query = "SELECT id AS extension,description AS display_name,DATA AS 'secret' FROM devices LEFT JOIN sip USING (id) WHERE sip.keyword = 'secret'";
	$resultado = mysql_query($query,$link);
	$array = array();
	while ($row = mysql_fetch_assoc($resultado)) {
		$array[$row['extension']]['display_name'] 	= str_replace(array('á','é','í','ó','ú','ñ'),array('a','e','i','o','u','n'),$row['display_name']);
		$array[$row['extension']]['secret'] 		= $row['secret'];
	}
	ksort($array);
	mysql_close($link);

	if (count($array) <= 0)
		die("No se encontraron registros en la base de datos. Terminando.\n");
	else
		echo "Encontramos ".count($array)." registros SIP en la tabla\n";
}

	


// Procesamos archivo de MACs
$handle = fopen($mac_file,'r');
$n = 0;
$headers = array();
while (($linea = fgetcsv($handle,1000,$separador)) !== FALSE) {
	// Primera línea: encabezados
	if ($n++ == 0) {
		$headers = $linea;
		foreach ($headers as $h => $v) {
			if (!in_array($v,$valid_headers))
				unset($headers[$h]);
		}
		// Si por algun motivo no contiene los campos de mac y exten, terminamos
		if ((!in_array('extension',$headers)) || (!in_array('mac',$headers))) {
			die("El archivo de macs debe contener al menos los encabezados de mac y extension. Terminando\n");
		}
		continue;
	}
	// Linea no contiene los valores minimos
	if (count($linea) < 2)
		continue;
	
	$mac	   = strtoupper(str_replace(array(':','-',' '),'',$linea[array_search('mac',$headers)]));
	$extension = $linea[array_search('extension',$headers)];

	
	// Tomamos los valores de la BD
	if ($freepbx) {
		$secret 		= $array[$extension]['secret'];
		$display_name 	= $array[$extension]['display_name'];
	}
	// Tomamos los valores del archivo
	else {
		$secret 		= $linea[array_search('secret',$headers)];
		$display_name 	= $linea[array_search('display_name',$headers)];
	}
	// Tratamos de obtener los parametros de red del archivo
	if ($linea[array_search('ipaddress',$headers)]) {
		$ipaddress 	= $linea[array_search('ipaddress',$headers)];
		$netmask	= $linea[array_search('netmask',$headers)];
		$gateway	= $linea[array_search('gateway',$headers)];
	}
	
	if ($debug) {
		echo "------\n         MAC: $mac\n   Extension: $extension\nDisplay name: $display_name\n      Secret: $secret\n";
		if ($linea[array_search('ipaddress',$headers)]) 
			echo "  IP Address: $ipaddress\n     Netmask: $netmask\n     Gateway: $gateway\n\n";
	}
	
	// Cargamos la plantilla
	ob_start();
	include $template_dir . "template.$template_name.php";
	$content = ob_get_clean();

	
	// Especificamos los nombres de archivo según la marca lo requiere
	if ($template_name == 'aastra')
		$filename = $dir . strtoupper($mac). '.cfg';
	elseif ($template_name == 'cisco')
		$filename = $dir . 'spa'.strtolower(substr($mac,0,2).':'.substr($mac,2,2).':'.substr($mac,4,2).':'.substr($mac,6,2).':'.substr($mac,8,2).':'.substr($mac,10,2)). '.xml';
	else	// Default: Yealink
		$filename = $dir . strtolower($mac). '.cfg';

	$newfile = fopen($filename,'w');
	fputs($newfile,$content);
	fclose($newfile);
	echo "Generado $filename - ". $extension . ' ' . $display_name . "\n";
	$n++;
}
fclose($handle);




// Si no hay que crear directorio, salimos
if (!$crear_directorio OR !$freepbx)
	exit;

// Creacion del directorio
$string = '';


// Directorio AASTRA
if ($template_name == 'aastra') {
	$directorio_filename = 'directorio-aastra.csv';
	foreach ($array as $extension => $x) {
		$string .= sprintf("\"%1\$s\",%2\$s",$x['display_name'],$extension). "\n";
	}
}
// Directorio YEALINK
else {
	$directorio_filename = 'directorio-yealink.xml';
	$string_base = "\t<DirectoryEntry>\n\t\t<Name>%1\$s</Name>\n\t\t<Telephone>%2\$s</Telephone>\n\t</DirectoryEntry>\n";
	foreach ($array as $extension => $x) {
		$string .= sprintf($string_base,$x['display_name'],$extension);
	}
	$string = "<DirectorioIPPhoneDirectory>\n".$string."</DirectorioIPPhoneDirectory>";
}
echo "Creando $dir$directorio_filename";
$handle = fopen($dir.$directorio_filename,'w');
fputs($handle,$string."\n");
fclose($handle);
