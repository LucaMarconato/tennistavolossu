<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="utf-8">
<title>Tennis Tavolo SSU</title>
<meta name="description" content="">
<meta name="author" content="Edoardo Annunziata, Luca Marconato">


<style type="text/css">
</style>
</head>
<body>
<!--TODO: fare in modo che si vedano i cambiamenti (ad esempio in verde +100) rispetto alla settimana precedente-->
Login:
<form name="login" action="login.php" method="post">
	<input type="text" name="email" id="email">
	<input type="password" name="pw" id="pw">
	<input type="submit" value="login">
</form>
<br>
Classifica Tennis Tavolo Scuola Superiore di Udine<br>
<table border="1" style="width:75%">
<tr>
	<td>Ranking</td>
    <td>Giocatore</td> 
    <td>Rating</td>
</tr>
<?php
include_once("mySql.php");
$database = new db();

$listaGiocatori = array();
$res1 = $database->cmd_my_sql("SELECT * FROM utenti WHERE hidden = 0",__FILE__,__LINE__);
while($fetched1 = mysql_fetch_array($res1))
{
	$res2 = $database->cmd_my_sql("SELECT * FROM elo WHERE userId = '".$fetched1['userId']."' AND timeId = (SELECT MAX(timeId) FROM elo WHERE userId = '".$fetched1['userId']."')",__FILE__,__LINE__);
	$fetched2 = mysql_fetch_array($res2);
	$giocatore = array();
	array_push($giocatore,$fetched2['userId'],$fetched2['rating']);
	array_push($listaGiocatori,$giocatore); 
}
$ordinati = false;
$arrayLength = count($listaGiocatori); 

while(!$ordinati)
{
	$ordinati = true;
	for($i = 1; $i < $arrayLength; $i++)
	{
		if($listaGiocatori[$i][1] > $listaGiocatori[$i-1][1])
		{
			$ordinati = false;
			$swap = $listaGiocatori[$i];
			$listaGiocatori[$i] = $listaGiocatori[$i-1];
			$listaGiocatori[$i-1] = $swap;
		}
	}
}

for($i = 0; $i < $arrayLength; $i++)
{
	$res = $database->cmd_my_sql("SELECT * FROM utenti WHERE userId = '".$listaGiocatori[$i][0]."'",__FILE__,__LINE__);
	$fetched = mysql_fetch_array($res);
	$nomeCognome = $fetched['nome']." ".$fetched['cognome'];
	if($nomeCognome == "Luca Marconato")
	{
		$nomeCognome = "<a href=\"campione.JPG\">Luca Marconato</A>";
	}
	echo "<tr><td>".($i+1)."</td><td>".$nomeCognome."</td><td>".$listaGiocatori[$i][1]."</td></tr>";
}
?>
</table>
<br><br>
Ultime dieci giocate disputate (prima le piu' recenti). I numeri indicano le partite vinte.<br><br>
<?php
$res1 = $database->cmd_my_sql("SELECT * FROM partite WHERE approvato = 1 ORDER BY timeId DESC LIMIT 10",__FILE__,__LINE__);
while($fetched1 = mysql_fetch_array($res1))
{
	$res2 = $database->cmd_my_sql("SELECT * FROM utenti WHERE userId = '".$fetched1['giocatore1']."'",__FILE__,__LINE__);
	$fetched2 = mysql_fetch_array($res2);
	$nomeCognome1 = $fetched2['nome']." ".$fetched2['cognome'];

	$res2 = $database->cmd_my_sql("SELECT * FROM utenti WHERE userId = '".$fetched1['giocatore2']."'",__FILE__,__LINE__);
	$fetched2 = mysql_fetch_array($res2);
	$nomeCognome2 = $fetched2['nome']." ".$fetched2['cognome'];

	$punteggio1 = $fetched1['punteggio1'];
	$punteggio2 = $fetched1['punteggio2'];

	if($nomeCognome1 > $nomeCognome2)
	{
		$swap = $punteggio1;
		$punteggio1 = $punteggio2;
		$punteggio2 = $swap;

		$swap = $nomeCognome1;
		$nomeCognome1 = $nomeCognome2;
		$nomeCognome2 = $swap;
	}

	//ordina alfabeticamente i due giocatori prima dell'echo
	echo $nomeCognome1." ".$punteggio1." - ".$punteggio2." ".$nomeCognome2."<BR>";
}
?>

</body>
</html>