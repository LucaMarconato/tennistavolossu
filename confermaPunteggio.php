<!--TODO: aggiungere anti-iniezione-->
<!--TODO: ci sono problemi di invio mail, nel dettaglio non ricevono mail gli indirizzi @icloud.com e @libero.it, mentre @gmail.com le ricevono come indesiderata. Nel futuro, quando non utilizzeremo altervista, visto che cambierà il metodo che invia le mail, questo problema dovrebbe sparire. Per ora ci limiteremo a dire ai giocatori di fornirci un indirizzo email google per registrarli e diremo loro di controllare in indesiderata se sanno che dovranno ricevere una mail-->
<?
include_once("mySql.php");
//la riga seguente serve solo per il debug
confermaPunteggio($_GET['matchCode']);

function confermaPunteggio($matchCode)
{
	$database = new db();

	$res = $database->cmd_my_sql("SELECT * FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	$fetched = mysql_fetch_array($res);
	$idMittente = $fetched['giocatore1'];
	$idDestinatario = $fetched['giocatore2'];
	$vinteMittente = $fetched['punteggio1']; //vinte sono quelle vinte dall'avversario
	$vinteDestinatario = $fetched['punteggio2'];

	$res = $database->cmd_my_sql("SELECT * FROM utenti WHERE userId = '".addslashes($idDestinatario)."'",__FILE__,__LINE__);
	$fetched = mysql_fetch_array($res);
	$emailDestinatario = $fetched['email'];
	$nomeDestinatario = $fetched['nome'];
	$cognomesDestinatario = $fetched['cognome'];

	$res = $database->cmd_my_sql("SELECT * FROM utenti WHERE userId = '".addslashes($idMittente)."'",__FILE__,__LINE__);
	$fetched = mysql_fetch_array($res);
	$nomeMittente = $fetched['nome'];
	$cognomeMittente = $fetched['cognome'];

	$url = "http://tennistavolossu.altervista.org/elo.php?reportMatch=".$matchCode;
	$testo = "Ciao ".$nomeDestinatario.", abbiamo aggiornato il tuo rating con la seguente partita:\n".$nomeMittente." ".$cognomeMittente." ".$vinteMittente." ".$nomeDestinatario." ".$cognomesDestinatario." ".$vinteDestinatario.".\n\nSe non hai disputato tale partita, o se il risulato è differente, clicca il link sottostante per cancellarla e ricalcolare il rating senza di essa\n".$url;
	//echo "emailDestinatario = $emailDestinatario, testo = $testo<BR>";
	mail($emailDestinatario,"Tennis Tavolo SSU",$testo);
}
?>