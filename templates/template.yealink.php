#!version:1.0.0.1



auto_provision.server.url = tftp://<?php echo $server_ip?>





# Configuracion de cuenta 1. Puede usarse el mismo formato para agregar N cuentas, segun el telefono soporte

account.1.enable = 1

account.1.label = <?php echo $extension?>

account.1.display_name = <?php echo $display_name?>

account.1.user_name = <?php echo $extension?>

account.1.auth_name = <?php echo $extension?>

account.1.password = <?php echo $secret?>

account.1.sip_server.1.address = <?php echo $server_ip?>

account.1.sip_server.1.expires = 60



# Datos de hora

local_time.time_zone = -6

local_time.time_zone_name = 'Mexico(Mexico City, Acapulco)'

local_time.ntp_server1 = <?php echo $server_ip?>

local_time.ntp_server2 = pool.ntp.org

local_time.date_format = 2

local_time.summer_time = 2



# Reglas del plan de marcacion. Sera necesario crear el dialnow.xml

dialplan_dialnow.url = tftp://<?php echo $server_ip?>/yealink-dialnow.xml



# Configurar los botones DSS para que ambos sean botones de linea

linekey.1.type = 15

linekey.1.line = 1

linekey.2.type = 15

linekey.2.line = 1



lang.wui = English

lang.gui = Spanish



### Directorio remoto

remote_phonebook.data.1.url=tftp://<?php echo $server_ip?>/directorio-yealink.xml

remote_phonebook.data.1.name=Directorio

### Activar provisionamiento cada 24 horas

auto_provision.repeat.enable=1

