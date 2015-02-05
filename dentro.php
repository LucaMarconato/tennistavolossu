<?php
session_start();
if(!session_is_registered(myusername)){
header("location:index.html");
}
?>

<html>
<body>
loggato!

<form name="logout" action="logout.php" method="post">
	<input type="submit" value="logout">
</form>

</body>
</html>