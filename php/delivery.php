<?php

// Establish a connection to the MySQL database
$conn = mysqli_connect("localhost", "team05", "team05", "team05", "3306");

// Check if the connection is successful
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

// Append the ORDER BY clause if a sorting option is selected
if (!empty($order_by)) {
    $sql .= " ORDER BY $order_by";
}

// Execute the SQL query
$result = $conn->query($sql);

// Display results in a table
if ($result->num_rows > 0) {
    echo "<div class='container' style='margin: 50px auto;'>"; // Added style attribute for center alignment

    echo "<h2>Restaurants Available for Delivery</h2>"; // Heading inside the container

    echo "<form method='get'>
            <label for='order_by'>Sort Order:</label>
            <select name='order_by' id='order_by' onchange='this.form.submit()'>
                <option value='' " . ($order_by == '' ? 'selected' : '') . ">Default</option>
                <option value='dlvy_price' " . ($order_by == 'dlvy_price' ? 'selected' : '') . ">Sorted by Low Delivery Fees</option>
                <option value='dlvy_ok_price' " . ($order_by == 'dlvy_ok_price' ? 'selected' : '') . ">Sorted by Low Minimum Order Amounts</option>
            </select>
          </form>";

    echo "<table>
            <tr>
                <th>Name</th>
                <th>Type</th>
                <th>Delivery fee</th>
                <th>Minimum Order Amount</th>
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
    echo "</div>"; // Close the container div
} else {
    echo "<div class='container' style='margin: 50px auto;'>"; // Added style attribute for center alignment
    echo "<h2>Restaurants Available for Delivery</h2>"; // Heading inside the container
    echo "No Restaurants available.";
    echo "</div>"; // Close the container div
}

// Close the database connection
$conn->close();

?>
