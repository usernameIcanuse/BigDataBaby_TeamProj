<?php
    session_start();

    // DB connection
    $mysqli = mysqli_connect("localhost","team05","team05","team05");

    if(mysqli_connect_errno())
    {
        printf("Connect failed: %s\n",mysqli_connect_error());
        exit();
    }
    else
    {

        // 데이터 삽입
        $sql = "insert into Reservation (Code, ReserveName, ReserveDate, ReserveTime, PersonCount) values (?, ?, ?, ?, ?)";

        // transaction
        mysqli_begin_transaction($mysqli);
        try{
            if($stmt = mysqli_prepare($mysqli, $sql)){
                mysqli_stmt_bind_param($stmt, "ssssi", $first, $second, $third, $fourth, $fifth);
        
                // 입력 데이터
                $first = $_POST['inputRestaurant'];
                $second = $_POST['reserveName'];
                $third = $_POST['reserveDate'];
                $fourth = $_POST['inputReserveTime'];
                $fifth = $_POST['people'];
        
                if(mysqli_stmt_execute($stmt)){
                    echo "Your reservation has been confirmed.<br>";
                    echo "<button onclick=\"location.href='Main.html'\">Go to the main</button>";
                }else{
                    echo "Could not proceed with your reservation. ".mysqli_error($mysqli);
                    echo "<button onclick=\"location.href='Main.html'\">Go to the main</button>";
                }
            }

            mysqli_stmt_close($stmt);

            mysqli_commit($mysqli);
        }catch(mysqli_sql_exception $exception){
            mysqli_rollback($mysqli);

            throw $exeption;
        }
    }

    mysqli_close($mysqli);
?>
