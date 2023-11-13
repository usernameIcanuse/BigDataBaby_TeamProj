
<?php

$conn = mysqli_connect("127.0.0.1", "root", "", "mydb", "3306");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user selected a sorting option
$order_by = isset($_GET['order_by']) ? $_GET['order_by'] : '';

// SQL query to retrieve data with ordering
$sql = "SELECT restaurant.name, types.type, delivery.dlvy_price, delivery.dlvy_ok_price
        FROM restaurant
        JOIN delivery ON restaurant.code = delivery.code
        JOIN types ON restaurant.typecode = types.code
        WHERE delivery.dlvy_avail = 1";

if (!empty($order_by)) {
    $sql .= " ORDER BY $order_by";
}

$result = $conn->query($sql);

// Display results in a table
if ($result->num_rows > 0) {
    echo "<form method='get'>
            <label for='order_by'>정렬 순서:</label>
            <select name='order_by' id='order_by' onchange='this.form.submit()'>
                <option value='' " . ($order_by == '' ? 'selected' : '') . ">정렬 없음</option>
                <option value='dlvy_price' " . ($order_by == 'dlvy_price' ? 'selected' : '') . ">배달비 낮은 순</option>
                <option value='dlvy_ok_price' " . ($order_by == 'dlvy_ok_price' ? 'selected' : '') . ">최소 주문 금액 낮은 순</option>
            </select>
          </form>";

    echo "<table>
            <tr>
                <th>레스토랑 이름</th>
                <th>음식 종류</th>
                <th>배달비</th>
                <th>최소 주문 금액</th>
            </tr>";

    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . $row["name"] . "</td>
                <td>" . $row["type"] . "</td>
                <td>" . $row["dlvy_price"] . "</td>
                <td>" . $row["dlvy_ok_price"] . "</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "배달 가능한 레스토랑이 없습니다.";
}

$conn->close();

?>
