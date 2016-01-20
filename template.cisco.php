<flat-profile>

	<Profile_Rule group="Provisioning/Configuration_Profile">tftp://<?php echo $server_ip ?>/spa$MAC.xml</Profile_Rule>
	<Syslog_Server group="System/Optional_Network_Configuration"><?php echo $server_ip ?></Syslog_Server>

	<!-- Red -->
<?php if (isset($ipaddress) && isset($netmask)) : ?>
	<Connection_Type group="System/Internet_Connection_Type_">Static IP</Connection_Type>
	<Static_IP group="System/_Static_IP_Settings"><?php echo $ipaddress ?></Static_IP>
	<NetMask group="System/_Static_IP_Settings"><?php echo $netmask ?></NetMask>
<?php else: ?>
	<Connection_Type group="System/Internet_Connection_Type_">DHCP</Connection_Type>
<?php endif; ?>
<?php if (isset($gateway)) : ?>
	<Gateway group="System/_Static_IP_Settings"><?php echo $gateway ?></Gateway>
<?php endif; ?>

	<!-- Fecha y hora -->
	<Primary_NTP_Server group="System/Optional_Network_Configuration"><?php echo $server_ip ?></Primary_NTP_Server>
	<Time_Zone group="Regional/Miscellaneous">GMT-06:00</Time_Zone>

	<!-- Configuracion de cuenta -->
	<Proxy_1_ group="Ext_1/Proxy_and_Registration"><?php echo $server_ip ?></Proxy_1_>
	<Display_Name_1_ group="Ext_1/Subscriber_Information"><?php echo $display_name ?></Display_Name_1_>
	<User_ID_1_ group="Ext_1/Subscriber_Information"><?php echo $extension ?></User_ID_1_>
	<Password_1_ group="Ext_1/Subscriber_Information"><?php echo $secret ?></Password_1_>
	<Dial_Plan_1_ group="Ext_1/Dial_Plan">(0|*xx|**xxxx|9090|9071|9040|901xxxxxxxxxx|9[1-9]xxxxxxx|904455xxxxxxxx|9045xxxxxxxxxx|900xxxxxxxxxxxx.|7[4567]xx)</Dial_Plan_1_>

	<!-- Directorio -->
	<XML_Directory_Service_Name group="Phone/XML_Service">Directorio</XML_Directory_Service_Name>
	<XML_Directory_Service_URL group="Phone/XML_Service">tftp://<?php echo $server_ip ?>/directorio-yealink.xml</XML_Directory_Service_URL>
	
	<!-- Codecs -->
	<Preferred_Codec_1_ group="Ext_1/Audio_Configuration">G722</Preferred_Codec_1_>
	<Use_Pref_Codec_Only_1_ group="Ext_1/Audio_Configuration">No</Use_Pref_Codec_Only_1_>
	<Second_Preferred_Codec_1_ group="Ext_1/Audio_Configuration">G711a</Second_Preferred_Codec_1_>
	<Third_Preferred_Codec_1_ group="Ext_1/Audio_Configuration">G729</Third_Preferred_Codec_1_>
	
</flat-profile>
