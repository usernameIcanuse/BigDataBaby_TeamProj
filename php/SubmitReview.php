<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RESTAURANT";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 확인
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// POST로 전달된 리뷰, 사진, 별점 정보 가져오기
$review = $_POST['review'];
$rating = $_POST['rating'];

// 데이터베이스에 리뷰 저장
$sql = "INSERT INTO review (review, rating) VALUES ('$review', '$rating')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../html/Review.html");
    exit;
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// 데이터베이스 연결 종료
$conn->close();
?>