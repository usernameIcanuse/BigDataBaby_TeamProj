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


	echo "Restaurant: ".$_SESSION['NAME']."<br/>";
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
				echo $newArray['PhoneNum']."<br/>";
			}
		}
		mysqli_free_result($res);
	}

	$sql = "select * from hashtag A inner join restaurant B inner join on A.hashtag_code = B.hashtag_code inner join Available C on B.Code = C.Code inner join BreakTime D on B.Code = D.Code inner join rating E on B.Code = E.Code 
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
				echo "Available :".$newArray['Start']." ~ ".$newArray['End']."<br/>";
				echo "BreakTime :".$newArray['BreakStart']." ~ ".$newArray['BreakEnd']."<br/>";
				echo "Rating : ".$newArray['rate']." rate : ".$newArray['rate']."<br/>";
			}
		}
		mysqli_free_result($res);
	}


	echo "</br>Menu<br/>";
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