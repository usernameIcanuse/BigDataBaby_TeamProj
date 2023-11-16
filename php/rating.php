<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "RESTAURANT", "3306");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT restaurant.name, rating.rate, types.type,
               @rank := @rank + 1 AS 순위
        FROM restaurant
        JOIN rating ON restaurant.code = rating.code
        JOIN types ON restaurant.typecode = types.code
        CROSS JOIN (SELECT @rank := 0) r
        ORDER BY rating.rate DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<div class='tableWrapper'>
            <div id='tableTitle'>Ranking</div>
            <table>
                <tr>
                    <th>Rank</th>
                    <th>Name</th>
                    <th>Rate</th>
                    <th>Type</th>
                </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td class='rank'>" . $row["순위"] . "</td>
                <td class='restaurant-name'>" . $row["name"] . "</td>
                <td class='rating'>" . $row["rate"] . "</td>
                <td class='restaurant-type'>" . $row["type"] . "</td>
              </tr>";
    }

    echo "</table></div>";
} else {
    echo "0 results";
}

$conn->close();

?>
