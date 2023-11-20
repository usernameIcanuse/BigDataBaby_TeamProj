<!-- SubmitReview.php -->
<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "team05";
$password = "team05";
$dbname = "team05";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
// POST로 전달된 리뷰, 별점, 비밀번호 정보 가져오기
$review = $_POST['review'];
$rating = $_POST['rating'];
$password = $_POST['password'];
$code = $_SESSION['CODE'];

// 데이터베이스에 리뷰 저장
$sql = "INSERT INTO review (Code, review, rating, password) VALUES ('". $code ."', '$review', '$rating', '$password')";

if ($conn->query($sql) === TRUE) {
    // Update total_rating and RATE in the rating table
    $updateSql = "UPDATE rating 
                    SET total_rating = (SELECT COUNT(*) FROM review WHERE Code = '$code'), 
                        RATE = (SELECT AVG(rating) FROM review WHERE Code = '$code')
                    WHERE Code = '$code'";

    if ($conn->query($updateSql) === TRUE) {
        header("Location: ../html/Review.html");
        exit;
    } else {
        echo "Error updating rating: " . $conn->error;
    }
} else {
    echo "Error inserting review: " . $conn->error;
}

// 데이터베이스 연결 종료
$conn->close();
?>
