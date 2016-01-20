### Configuracion de tiempo
time server disabled: 0
time server1: <?php echo $server_ip ?>
time zone name: MX-Monterrey

### Directorio
directory 1: directorio-aastra.csv
directory upate: 1

### Lenguaje (2 Espanol)
language: 2

xml application post list: <?php echo $server_ip ?>

### Datos SIP
sip proxy ip: <?php echo $server_ip ?>
sip proxy port: 5060
sip registrar ip: <?php echo $server_ip ?>
sip registrar port: 5060
sip digit timeout: 4
sip screen name: <?php echo $display_name ?>
sip screen name 2: <?php echo $extension ?>
sip display name: <?php echo $extension ?>
sip auth name: <?php echo $extension ?>
sip user name: <?php echo $extension ?>
sip password: <?php echo $secret ?>
sip vmail: *97
sip mode: 0

softkey1 type: speeddial
softkey1 label: \"Voice Mail\"
softkey1 value: *97

#softkey2 type: speeddial
#softkey2 label: \"DND On\"
#softkey2 value: *78

#softkey3 type: speeddial
#softkey3 label: \"DND Off\"
#softkey3 value: *79
