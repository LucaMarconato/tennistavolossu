<?
include_once("mySql.php");

$database = new db();

$matchCode = $_GET['matchCode'];

$res = $database->cmd_my_sql("SELECT * FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
$fetched = mysql_fetch_array($res);
if($fetched['approvato'])
{
	echo "Il ranking e' gia' stato aggiornato.<BR>";
	return ;
}

$idGiocatore1 = $fetched['giocatore1'];
$idGiocatore2 = $fetched['giocatore2'];
$punteggio1 = $fetched['punteggio1'];
$punteggio2 = $fetched['punteggio2'];

$res =$database->cmd_my_sql("SELECT ranking FROM utenti WHERE id = '".addslashes($idGiocatore1)."'",__FILE__,__LINE__);
$fetched = mysql_fetch_array($res);

$ranking1 = $fetched['ranking'];
$ranking2 = $fetched['ranking'];

$database->cmd_my_sql("UPDATE partite SET approvato = ".true." WHERE matchCode = '".addslashes($matchCode)."'");

if($punteggio1 == $punteggio2)
{
	return ; 
}

//algoritmo elo
$se = 1/(1+pow(10, ($ranking1 - $ranking2)/400))*($punteggio1+$punteggio2);
$sr = $punteggio1;
$increment = ($sr - $se)*32;

$database->cmd_my_sql("UPDATE utenti SET ranking = ".($ranking1 + $increment)." WHERE id = ".addslashes($idGiocatore1),__FILE__,__LINE__);
$database->cmd_my_sql("UPDATE utenti SET ranking = ".($ranking2 - $increment)." WHERE id = ".addslashes($idGiocatore2),__FILE__,__LINE__);

echo "Ranking aggiornato.<BR>"
?>