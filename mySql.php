<?
class db
{
	var $dbhost = 'localhost';
	var $dbname = 'my_tennistavolossu';
	var $dbuser = 'tennistavolossu';
	var $dbpassword = 'regkimuska63';
	var $die_error = true;

	public function cmd_my_sql($request,$file,$riga)
	{
		$this->speed_cnt = mysql_connect($this->dbhost,$this->dbuser,$this->dbpassword); // Gestisco la prima connessione al database mysql
		if(!$this->speed_cnt) 
		{
			if($this->die_error)
			{
				$this->cmd_my_sql_error($request,mysql_error(),$file,$riga);
				die;
			}
		return false;
		}
		
		$this->speed_dbselect = mysql_select_db($this->dbname, $this->speed_cnt); // Seleziono il database
		if(!$this->speed_dbselect) 
		{
			if($this->die_error)
			{
				$this->cmd_my_sql_error($request,mysql_error(),$file,$riga);
				die;
			}
			return false;
		}
		
		$this->speed_result = mysql_query($request, $this->speed_cnt);
		if(!$this->speed_result) 
		{
			if($this->die_error)
			{
				$this->cmd_my_sql_error($request,mysql_error(),$file,$riga);
				die;
			}
			return false;
		}
		else 
		{
			return $this->speed_result;
		}
	}
	private function cmd_my_sql_error($request,$error,$file,$riga)
	{
		$message = "Non e' stato possibile completare la richiesta a causa di un errore nell'accesso al database.<BR>Tale comportamento anomalo e' stato segnalato e verra' risolto al piu' presto.<BR>";
        echo $message;
		$dettagliErrore = "File: \"".$file."\".\nRiga: \"".$riga."\".\nRichiesta: \"".$request."\".\nDettagli:\n\"".$error."\".\n";

		$debugMode = true;
		if($debugMode)
		{
			echo "Dettagli errore:<BR>".$dettagliErrore."<BR>";
		}
		else
		{
			mail("m.lucalmer@gmail.com","Tennis Tavolo SSU - Errore MYSQL",$dettagliErrore);
		}
	}
}
?>