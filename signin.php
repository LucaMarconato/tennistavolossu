<!--TODO: aggiungere assolutamente l'anti iniezione prima che raggiunga troppa visibilità-->
<!DOCTYPE html>
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<title>Iscrizione Rating System</title>
</head>

<body>
<script>

//NON FUNZIONA, AMEN
function validateFormDati()
{
	var x=document.forms["dati"]["nome"].value;
	var y=document.forms["dati"]["cognome"].value;
	var z=document.forms["dati"]["email"].value;
	var t=document.forms["dati"]["password"].value;
	if (x==null || x=="" || y==null || y=="" || z==null || z=="" || t==null || t==""))
	{
		alert("Devi compilare tutti i campi.");
		return false;
	}
	//document.div["attendi"]["attendi"].value = "testing !!!!!";
	//document.div["attendi"]["attendi"].hidden=false;
	return true;
}
</script>

<?php
$nome=$_POST['nome'];
$cognome=$_POST['cognome'];
$email=$_POST['email'];
$password=$_POST['password'];
if($nome != "" && $nome != null)
{
	include_once("mySql.php");
	$database = new db();
	$database->cmd_my_sql("INSERT INTO utenti(nome,cognome,email,password,amministratore) VALUES ('".addslashes($nome)."','".addslashes($cognome)."','".addslashes($email)."','".addslashes($password)."','false')",__FILE__,__LINE__);
	$res = $database->cmd_my_sql("SELECT * FROM utenti WHERE email = '$email'");
	$fetched = mysql_fetch_array($res);
	$userId = $fetched['userId'];
	$timeId = date('Y-m-d H:i:s');
	$database->cmd_my_sql("INSERT INTO elo(userId,timeId,rating) VALUES ('$userId','$timeId','1200')",__FILE__,__LINE__);
	echo "$nome, ti sei iscritto.<BR>Per il momento il sito non e' funzionante, scriveremo nel gruppo Facebook quando lo sara'.<BR><BR>";
	echo "<meta http-equiv=\"Refresh\" content=\"3; index.html\">";
	return ;
}
?>

<!--
Muahahhaah, pubblicità
<script type="text/javascript">
/* <![CDATA[ */
document.write('<s'+'cript type="text/javascript" src="http://ad.altervista.org/js.ad/size=300X250/r='+new Date().getTime()+'"><\/s'+'cript>');
/* ]]> */
</script>-->
Completa i seguenti dati per registrarti. Devi usare un indirizzo @gmail.com. Le mail che ti invieremo, per qualche mese, le troverai in "posta indesiderata".<br><br><br>

<form id="dati" name="dati" method="post" action="signin.php" onsubmit="return validateFormDati()">
	<label for="titolo">Dati per partecipare</label>
	<br>
	<label for="nome">Nome</label>
    <input name="nome" type="text" id="nome" value="" size="55" />
	<br>
	<label for="cognome">Cognome</label>
    <input name="cognome" type="text" id="cognome" value="" size="55" />
	<br>
	<label for="email">Email</label>
    <input name="email" type="text" id="email" value="" size="55" />
	<br>
	<label for="passsword">Password</label>
    <input name="password" type="password" id="password" value="" size="55" />
	<br>
    <input type="submit" name="registrati" id="registrati" value="Registrati"/>
</form>
<br>
<br>
</body>
</html>