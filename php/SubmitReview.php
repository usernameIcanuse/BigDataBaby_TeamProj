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

// POST로 전달된 리뷰, 별점, 비밀번호 정보 가져오기
$review = $_POST['review'];
$rating = $_POST['rating'];
$password = $_POST['password'];

// 데이터베이스에 리뷰 저장
$sql = "INSERT INTO review (review, rating, password) VALUES ('$review', '$rating', '$password')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../html/Review.html");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 데이터베이스 연결 종료
$conn->close();
?>
