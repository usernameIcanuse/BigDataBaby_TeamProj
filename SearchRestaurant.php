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


	$sql = "select Name, Type, A.Code as Code, B.Code as TypeCode  from Restaurant A inner join Types B on A.TypeCode = B.Code
		where Name = ? AND Type = ?";

	if($stmt = mysqli_prepare($mysqli, $sql))
	{
		mysqli_stmt_bind_param($stmt, "ss", $first, $second);

		$first = $_SESSION['NAME'];
		$second = $_SESSION['TYPE'];
		
		mysqli_stmt_execute($stmt);

		if($res = mysqli_stmt_get_result($stmt))
		{
			while($newArray = mysqli_fetch_array($res))
			{
				echo "Name: ".$newArray['Name']." Type: ".$newArray['Type']."\n";
				$_SESSION['CODE'] = $newArray['Code'];

			}
		}
		mysqli_free_result($res);
	}
	mysqli_stmt_close($stmt);
	mysqli_close($mysqli);

}


?>