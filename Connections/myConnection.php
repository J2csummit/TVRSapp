<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_myConnection = "http://mysql-tvrs.immtcnj.com/";
$database_myConnection = "tvrstcnj";
$username_myConnection = "justincheng";
$password_myConnection = "tvrsd0s4g3";
$myConnection = mysql_pconnect($hostname_myConnection, $username_myConnection, $password_myConnection) or trigger_error(mysql_error(),E_USER_ERROR); 
?>