<!-- getReview.php -->
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

// 데이터베이스에서 리뷰 최대 10개 가져오기
$sql = "SELECT * FROM review WHERE Code = '3180000-101-2016-00033' ORDER BY review_code DESC";
$result = $conn->query($sql);

// 가져온 리뷰를 HTML 형식으로 반환
if ($result->num_rows > 0) {
    // 가져온 리뷰의 개수를 계산
    $reviewCount = $result->num_rows;

    // 동적으로 적용할 스타일을 생성
    echo '<style>';
    echo '.wrapper { margin: ' . ($reviewCount * 11.5). 'vh 0; }';
    echo '.container { margin: ' . ($reviewCount * 2) . 'vh 0; }';
    echo '</style>';

    while ($row = $result->fetch_assoc()) {
        echo '<div class="review">';
        echo '<p><strong>🌟 Rating</strong> ' . $row['rating'] . '</p>';
        echo '<p><strong>🙂 Review</strong> ' . $row['review'] . '</p>';
        echo '</div>';
    }
} else {
    echo '<div class="review">';
    echo '<p>No reviews available.</p>';
    echo '</div>';
}

// 데이터베이스 연결 종료
$conn->close();
?>
