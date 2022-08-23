<?php
 // generate a encrypted password to put in the database
$hashed_password = crypt('jerry', 'rl');
echo $hashed_password;
/* Current users and their password 
    admin: admin
    jerry: jerry
*/
?>
