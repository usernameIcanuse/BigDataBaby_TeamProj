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


	$sql = "select * from Restaurant where Name = ? AND Type = ? AND Location = ?";

	if($stmt = mysqli_prepare($mysqli, $sql))
	{
		mysqli_stmt_bind_param($stmt, "sss", $first, $second, $third);

		$first = $_SESSION['NAME'];
		$second = $_SESSION['TYPE'];
		$third = $_SESSION['LOCATION'];
		
		mysqli_stmt_execute($stmt);

		if($res = mysqli_stmt_get_result($stmt))
		{
			while($newArray = mysqli_fetch_array($res))
			{
				echo "Name: ".$newArray['Name']." Type: ".$newArray['Type']." Location: ".$newArray['Location']."\n";
			}
		}
		mysqli_free_result($res);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($mysqli);

}


?>