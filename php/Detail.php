<?php
session_start();

$mysqli = mysqli_connect("localhost","team05","team05","team05");

if(mysqli_connect_errno())
{
	printf("Connect failed: %s\n",mysqli_connect_error());
	exit();
}
else
{


	echo "<h1 style=\"text-align: Left;\">".$_SESSION['NAME']."</h1><br/>";
	echo "Phone Number: ";

	$sql = "select * from Contact
		where Code = ?";

	if($stmt = mysqli_prepare($mysqli, $sql))
	{
		mysqli_stmt_bind_param($stmt, "s", $first);

		$first = $_SESSION['CODE'];
		
		mysqli_stmt_execute($stmt);

		if($res = mysqli_stmt_get_result($stmt))
		{
			while($newArray = mysqli_fetch_array($res))
			{
				echo "<strong>".$newArray['PhoneNum']."</strong><br/>";
			}
		}
		mysqli_free_result($res);
	}

	$sql = "select * from hashtag A inner join restaurant B on A.hashtag_code = B.hashtag_code inner join Available C on B.Code = C.Code inner join BreakTime D on B.Code = D.Code inner join rating E on B.Code = E.Code 
		where B.Code = ?";

	if($stmt = mysqli_prepare($mysqli, $sql))
	{
		mysqli_stmt_bind_param($stmt, "s", $first);

		$first = $_SESSION['CODE'];
		
		mysqli_stmt_execute($stmt);

		if($res = mysqli_stmt_get_result($stmt))
		{
			while($newArray = mysqli_fetch_array($res))
			{
				echo "Available :".$newArray['Start']." AM ~ ".$newArray['End']." PM<br/>";
				echo "BreakTime :".$newArray['BreakStart']." PM ~ ".$newArray['BreakEnd']."<br/>";
				echo "Rate : ⭐".$newArray['RATE']."<br/>";
			}
		}
		mysqli_free_result($res);
	}


	echo "</br><h2 style =\"text-align: center;\">Menu</h1><br/>";
	$sql = "select * from menu
		where Code = ?";

	if($stmt = mysqli_prepare($mysqli, $sql))
	{
		mysqli_stmt_bind_param($stmt, "s", $first);

		$first = $_SESSION['CODE'];
		
		mysqli_stmt_execute($stmt);

		if($res = mysqli_stmt_get_result($stmt))
		{
			
			while($newArray = mysqli_fetch_array($res))
			{
				echo $newArray['Menu_Name']."     ".$newArray['Menu_Prices']." Won"."<br/>";
			}
		}
		mysqli_free_result($res);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($mysqli);

}


?>