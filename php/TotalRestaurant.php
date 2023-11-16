<?php

$mysqli = mysqli_connect("localhost", "team05", "team05", "team05");
$TypeArr= array("Asian","Bunsik","Chicken", "Chinese","Dessert","Etc","Japanese","Korean","LightWestern");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} else {
    $sql = "SELECT Location, Type, COUNT(C.Code) AS total 
            FROM Location A 
            INNER JOIN Restaurant B ON A.Code = B.Code 
            INNER JOIN Types C ON B.TypeCode = C.Code 
            GROUP BY A.Location, C.Type WITH ROLLUP";

    if ($res = mysqli_query($mysqli, $sql)) {
        echo '<table class="restaurant-table">';
        echo '<thead><tr><th>Location</th><th>Asian</th><th>Bunsik</th><th>Chicken</th><th>Chinese</th><th>Dessert</th><th>Etc</th><th>Japanese</th><th>Korean</th><th>LightWestern</th><th>Total</th></tr></thead>';
        echo '<tbody>';
	$location = "";
	$first=0;
	$Index = 0;
        while ($newArray = mysqli_fetch_array($res)) {
            if($location != $newArray['Location'])
	    {
		if($first != 0)
	        {    echo '</tr>';}
		echo '<tr>';
            	echo '<td>' . $newArray['Location'] . '</td>';
		$location = $newArray['Location'];
		$Index =0;
            }
	    while($Index != 9 && $newArray['Type'] != $TypeArr[$Index])
	    {
		echo '<td>0</td>';
		$Index +=1;

	    }
	    $Index+=1;
            echo '<td>' . $newArray['total'] . '</td>';
        }
	echo '</tr>';
        echo '</tbody>';
        echo '</table>';
    }

    mysqli_free_result($res);
    mysqli_close($mysqli);
}
?>
