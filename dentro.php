<?php
session_start();
if(!session_is_registered(myusername)){
header("location:index.html");
}
?>

<html>
<body>
loggato!
<!--
TODO: aggiungere controllo se l'utente è amministratore o no e a seconda di ciò fare apparire un'interfaccia diversa, nel caso in cui sia un utente normale, comparirà qualcosa che gli permetterà di selezionare il giocatore contro cui ha vinto e specificare il punteggio. Quando l'utente conferma, bisognerà aggiungere alla tabella "partite" del database, i dati della partita, specificando "confermata=false". Dovrà quindi essere chiamata la funzione confermaPunteggio() specifiando il matchCode della partita (che è la chiave primaria della tabella ed è auto increment). A quel punto all'altro giocatore arriverà la mail.
Se invece è l'amministratore a loggarsi, esso avrà un interfaccia che gli permetterà di inserire facilmente le partite senza dover chiedere conferma agli altri giocatori. E' necessario inserire un sistema di "undo" nel caso in cui digitasse robe sbagliate. Inoltre le partite che inserisce andranno inserite nella tabella "partite" con "confermata=true".
-->

<form name="logout" action="logout.php" method="post">
	<input type="submit" value="logout">
</form>

</body>
</html>