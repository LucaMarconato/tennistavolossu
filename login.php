<?php

$host="localhost";
$username="tennistavolossu"; 
$password="regkimuska63";
$db_name="my_tennistavolossu";
$tbl_name="utenti";

// connessione al db
mysql_connect("$host", "$username", "$password")or die("errore db"); 
mysql_select_db("$db_name")or die("cannot select DB");

// myusername e mypassword sono i dati dell'utente
$myusername=$_POST['email']; 
$mypassword=$_POST['pw']; 

// anti-iniezione
$myusername = stripslashes($myusername);
$mypassword = stripslashes($mypassword);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);
$sql="SELECT * FROM $tbl_name WHERE email='$myusername' and password='$mypassword'";
$result=mysql_query($sql);

$count=mysql_num_rows($result);

if($count==1){

session_register("myusername");
session_register("mypassword"); 
header("location:dentro.php");
}
else {
echo "mail/pw errato";
}

?>