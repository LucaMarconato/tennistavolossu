<!--TODO: aggiungere anti-iniezione-->
<?
include_once("mySql.php");

$matchCode = $_GET['matchCode'];
$action = $_GET['action']; //updateRatingFromMatchCode, reportMatch

if($action == "updateRatingFromMatchCode")
{
	//echo "calling updateRatingFromMatchCode()<BR>";
	updateRatingFromMatchCode($matchCode);
}
else if ($action == "reportMatch") 
{
	//echo "calling reportMatch()<BR>";
	reportMatch($matchCode);
}
function updateRatingFromMatchCode($matchCode)
{
	//echo "in updateRatingFromMatchCode()<BR>";
	$database = new db();

	$res = $database->cmd_my_sql("SELECT * FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	$fetched = mysql_fetch_array($res);
	if($fetched['approvato'])
	{
		echo "Il rating e' gia' stato aggiornato.<BR>";
		return ;
	}
	$database->cmd_my_sql("UPDATE partite SET approvato = ".true." WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	//echo "appena fatta la query "."UPDATE partite SET approvato = ".true." WHERE matchCode = '".addslashes($matchCode)."'<BR>";

	$timeId = $fetched['timeId'];
	updateRatingFromTimeId($timeId);
}

function updateRatingFromTimeId($timeId)
{	
	//echo "in updateRatingFromTimeId()<BR>";
	$database = new db();

	$database->cmd_my_sql("DELETE FROM elo WHERE timeId >= '$timeId' AND startingPoint = 0",__FILE__,__LINE__);
	$res1 = $database->cmd_my_sql("SELECT * FROM partite WHERE timeId >= '$timeId' AND approvato = 1 ORDER BY timeId ASC",__FILE__,__LINE__);
	while($fetched1 = mysql_fetch_array($res1))
	{
		$idGiocatore1 = $fetched1['giocatore1'];
		$idGiocatore2 = $fetched1['giocatore2'];
		$punteggio1 = $fetched1['punteggio1'];
		$punteggio2 = $fetched1['punteggio2'];

		$res2 = $database->cmd_my_sql("SELECT * FROM elo WHERE userId = '$idGiocatore1' AND timeId = (SELECT MAX(timeId) FROM elo WHERE userId = '$idGiocatore1')",__FILE__,__LINE__);
		$fetched2 = mysql_fetch_array($res2);
		$rating1 = $fetched2['rating'];
		$res2 = $database->cmd_my_sql("SELECT * FROM elo WHERE userId = '$idGiocatore2' AND timeId = (SELECT MAX(timeId) FROM elo WHERE userId = '$idGiocatore2')",__FILE__,__LINE__);
		$fetched2 = mysql_fetch_array($res2);
		$rating2 = $fetched2['rating'];

		if($punteggio1 != $punteggio2)
		{
			//algoritmo elo
			$se = 1/(1+pow(10, ($ranking1 - $ranking2)/400))*($punteggio1+$punteggio2);
			$sr = $punteggio1;
			$increment = ($sr - $se)*24;
			$newRating1 = $rating1 + $increment;
			$newRating2 = $rating2 - $increment;

			$database->cmd_my_sql("INSERT INTO elo(userId,timeId,rating) VALUES ('$idGiocatore1','".$fetched1['timeId']."','$newRating1')",__FILE__,__LINE__);
			$database->cmd_my_sql("INSERT INTO elo(userId,timeId,rating) VALUES ('$idGiocatore2','".$fetched1['timeId']."','$newRating2')",__FILE__,__LINE__);
		}
	}
	echo "Rating aggiornato.<BR>";
}

function reportMatch($matchCode) //TODO: bisogna criptare il numero della partita
{
	//echo "in reportMatch()<BR>";
	$database = new db();

	$database->cmd_my_sql("UPDATE partite SET approvato = 0 WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	$res = $database->cmd_my_sql("SELECT * FROM partite WHERE matchCode = '".addslashes($matchCode)."'",__FILE__,__LINE__);
	$fetched = mysql_fetch_array($res);
	$timeId = $fetched['timeId'];
	updateRatingFromTimeId($timeId);
	echo "Partita eliminata.<BR>";
}
?>