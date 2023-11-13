<?php

$mysqli = mysqli_connect("localhost","team05","team05","team05");

if(mysqli_connect_errno())
{
	printf("Connect failed: %s\n",mysqli_connect_error());
	exit();
}
else
{
	$sql = "select Location, Type, Count(C.Code) as total 
		from Location A inner join Restaurant B on A.Code = B.Code inner join Types C on B.TypeCode = C.Code group by A.Location, C.Type with rollup
		";

	if($res = mysqli_query($mysqli, $sql))
	{
		
		while($newArray = mysqli_fetch_array($res))
		{
			echo $newArray['Location']."  ". $newArray['Type']."  ".$newArray['total']."</br>";
		}
	}
	mysqli_free_result($res);
	mysqli_close($mysqli);

}

?>