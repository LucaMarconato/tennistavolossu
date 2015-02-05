<?
include_once("cmd_my_sql.php");

$database = new db();

function confermaPunteggio($matchCode)
{

	$idDestinatario = $database->cmd_my_sql("SELECT idGiocatore1 FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	$idAvversario = $database->cmd_my_sql("SELECT idGiocatore2 FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	//vinte sono quelle vinte dall'avversario
	$vinte = $database->cmd_my_sql("SELECT punteggio1 FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	$perse = $database->cmd_my_sql("SELECT punteggio2 FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);

	$email = $database->cmd_my_sql("SELECT email FROM utenti WHERE id = '".addslashes($idDestinatario)."'",__FILE__,__LINE__);
	$nomeDestinatario = $database->cmd_my_sql("SELECT nome FROM utenti WHERE id = '".addslashes($idDestinatario)."'",__FILE__,__LINE__);
	$cognomesDestinatario = $database->cmd_my_sql("SELECT cognome FROM utenti WHERE id = '".addslashes($idDestinatario)."'",__FILE__,__LINE__);
	$nomeAvversario = $database->cmd_my_sql("SELECT nome FROM utenti WHERE id = '".addslashes($idAvversario)."'",__FILE__,__LINE__);
	$cognomeAvversario = $database->cmd_my_sql("SELECT nome FROM utenti WHERE id = '".addslashes($idAvversario)."'",__FILE__,__LINE__);

	$url = "tennistavolossu.altervista.org/ole.php?code=matchCode=".$matchCode;

	$testo = "Ciao ".$nome.", clicca il link sottostante per confermare il seguente esito:\n".$nomeAvversario." ".$cognomeAvversario." ".$vinte." ".$nomeDestinatario." ".$cognomesDestinatario." ".$perse.".\n\n".$url;
		
	mail($destinatario,"Tennis Tavolo SSU",$testo);
}
?>