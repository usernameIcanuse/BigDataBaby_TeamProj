<?php
session_start();

$mysqli = mysqli_connect("localhost", "team05", "team05", "team05");

if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
} else {
    $sql = "SELECT Name, Type, A.Code as Code, B.Code as TypeCode FROM Restaurant A INNER JOIN Types B ON A.TypeCode = B.Code WHERE Name = ? AND Type = ?";

    if ($stmt = mysqli_prepare($mysqli, $sql)) {
        mysqli_stmt_bind_param($stmt, "ss", $first, $second);

        $first = $_SESSION['NAME'];
        $second = $_SESSION['TYPE'];

        mysqli_stmt_execute($stmt);

        if ($res = mysqli_stmt_get_result($stmt)) {
            echo '<table class="result-table">';
            echo '<thead><tr><th>Name</th><th>Type</th></tr></thead>';
            echo '<tbody>';

            while ($newArray = mysqli_fetch_array($res)) {
                echo '<tr>';
                echo '<td>' . $newArray['Name'] . '</td>';
                echo '<td>' . $newArray['Type'] . '</td>';
                echo '</tr>';
                $_SESSION['CODE'] = $newArray['Code'];
            }

            echo '</tbody>';
            echo '</table>';
        }

        mysqli_free_result($res);
    }
    mysqli_stmt_close($stmt);
    mysqli_close($mysqli);
}
?>
