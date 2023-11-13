<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "mydb", "3306"); #알아서 수정

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// SQL query to retrieve data with ranking
$sql = "SELECT restaurant.name, rating.rate, types.type,
               @rank := @rank + 1 AS 순위
        FROM restaurant
        JOIN rating ON restaurant.code = rating.code
        JOIN types ON restaurant.typecode = types.code
        CROSS JOIN (SELECT @rank := 0) r
        ORDER BY rating.rate DESC";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Output data in a table
    echo "<table border='1'>
            <tr>
                <th>순위</th>
                <th>레스토랑 명</th>
                <th>별점</th>
                <th>종류</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["순위"] . "</td>
                <td>" . $row["name"] . "</td>
                <td>" . $row["rate"] . "</td>
                <td>" . $row["type"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();

?>
