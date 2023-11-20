<!-- GetReview.php -->
<?php
session_start();

// 데이터베이스 연결 설정
$servername = "localhost";
$username = "team05";
$password = "team05";
$dbname = "team05";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the delete button is clicked
    if (isset($_POST['submit'])) {
        // Get the entered password and review code
        $enteredPassword = $_POST['password'];
        $reviewCode = $_POST['review_code'];

        // Retrieve the correct password from the database based on the review code
        $passwordSql = "SELECT * FROM review WHERE review_code = '$reviewCode'";
        $passwordResult = $conn->query($passwordSql);

        if ($passwordResult->num_rows > 0) {
            $row = $passwordResult->fetch_assoc();
            $correctPassword = $row['password'];
            $ratingToDelete = $row['rating'];
            $code = $row['Code'];

            // Check if the entered password is correct
            if ($enteredPassword !== $correctPassword) {
                echo '<script>';
                echo 'alert("Incorrect password. Please try again.");';
                echo 'document.getElementById("password-error").innerText = "Incorrect password. Please try again.";';
                echo '</script>';
            } else {
                // The password is correct, proceed with deleting the review
                $deleteSql = "DELETE FROM review WHERE review_code = '$reviewCode'";
                if ($conn->query($deleteSql) === TRUE) {
                    // Update rating table for the corresponding restaurant
                    $updateSql = "UPDATE rating 
                    SET total_rating = (SELECT COUNT(*) FROM review WHERE Code = '$code'), 
                        RATE = (SELECT AVG(rating) FROM review WHERE Code = '$code')
                    WHERE Code = '$code'";
                    if ($conn->query($updateSql) === TRUE) {
                        echo '<script>';
                        echo 'alert("Review deleted successfully.");';
                        echo '</script>';
                    } else {
                        echo '<script>';
                        echo 'alert("Error updating review: ' . $conn->error . '");';
                        echo '</script>';
                    }
                }
                else{
                    echo '<script>';
                    echo 'alert("Error deleting rating: ' . $conn->error . '");';
                    echo '</script>';
                }
            }
        }
    }
}

$code = $_SESSION['CODE'];

// 데이터베이스에서 리뷰 가져오기
$sql = "SELECT * FROM review WHERE Code = '".  $code ."' ORDER BY review_code DESC";
$result = $conn->query($sql);

$avg_rate_sql = "SELECT AVG(rating) AS avg_rate FROM review WHERE Code = '$code' GROUP BY Code";
$avg_result = $conn->query($avg_rate_sql);

$total_num_sql = "SELECT Code, SUM(1) AS total_num FROM review WHERE Code = '$code' GROUP BY Code;";
$total_result = $conn->query($total_num_sql);

$type_avg_num_sql = "
SELECT r.TypeCode, t.Type, AVG(r.review_count) AS avg_review_count
FROM (
    SELECT restaurant.Code, restaurant.TypeCode, COUNT(Review.review_code) AS review_count
    FROM restaurant
    JOIN Review ON restaurant.Code = Review.Code
    GROUP BY restaurant.Code, restaurant.TypeCode
) r
JOIN types t ON r.TypeCode = t.Code
WHERE r.TypeCode IN (
    SELECT restaurant.TypeCode
    FROM restaurant
    WHERE restaurant.Code = '$code'
)
GROUP BY r.TypeCode, t.Type;";

$type_avg_result = $conn->query($type_avg_num_sql);

// 가져온 리뷰를 HTML 형식으로 반환
if ($result->num_rows > 0) {
    // 가져온 리뷰의 개수를 계산
    $reviewCount = $result->num_rows;

    // 동적으로 적용할 스타일을 생성
    echo '<style>';
    echo '.wrapper { margin: ' . ($reviewCount * 16.5). 'vh 0; }';
    echo '.container { margin: ' . ($reviewCount * 2) . 'vh 0; }';
    echo '.password-container { display: flex; align-items: center; }';
    echo '.password {
        width: 20vw;
        padding-left: 4%;
        background: #ffffff;
        border: 0.8px solid #979797;
        box-shadow: 0px 1px 8px rgba(156, 156, 156, 0.15);
        border-radius: 10px;
        font-size: 22px;
        margin-left: 3%;
      }';
    echo '.delete {
        width: auto; /* Set width as needed */
        margin-left: 10px; /* Adjust margin as needed */
        font-size: 16px; /* Adjust font size as needed */
        display: flex; /* Add flex display for centering */
        align-items: center; /* Center text vertically */
        justify-content: center; /* Center text horizontally */
        text-align: center; /* Center text horizontally */
        line-height: 25px; /* Adjust line height for vertical centering */
      }';
    echo '</style>';

    if ($avg_result) {
        // Fetch the average rate
        $avg_row = $avg_result->fetch_assoc();
        $avg_rate = $avg_row['avg_rate'];
    
        // Display the average rate
        echo '<h3><strong>⭐ Average Rate : </strong>' . $avg_rate . '</h3>';
    } else {
        echo 'Error calculating average rate: ' . $conn->error;
    }

    if ($total_result) {
        // Fetch the average rate
        $total_row = $total_result->fetch_assoc();
        $total_num = $total_row['total_num'];
    
        // Display the average rate
        echo '<h3><strong>🔢 Total number of reviews : </strong>' . $total_num . '</h3>';
    } else {
        echo 'Error calculating total number: ' . $conn->error;
    }

    if ($type_avg_result) {
        // Fetch the average rate
        $type_avg_row = $type_avg_result->fetch_assoc();
        $avg_review_count = $type_avg_row['avg_review_count'];
    
        // Display the average rate
        echo '<h3><strong>🔍 Average number of reviews per type : </strong>' . $avg_review_count . '</h3>';
    } else {
        echo 'Error calculating average number: ' . $conn->error;
    }

    while ($row = $result->fetch_assoc()) {
        echo '<div class="review">';
        echo '<p><strong>🌟 Rating</strong> ' . $row['rating'] . '</p>';
        echo '<p><strong>🙂 Review</strong> ' . $row['review'] . '</p>';

        // Add a form for deleting the review (you may want to improve the UI)
        echo '<form action="" method="post">';
        echo '<input type="hidden" name="review_code" value="' . $row['review_code'] . '"/>';

        // Password input and delete button layout
        echo '<div class="password-container">';
        echo '<p><strong>🗑️ Password</strong></p>';
        echo '<input type="password" name="password" required class="password"/>';
        echo '<input type="submit" name="submit" value="Delete   " class="delete"/>';
        echo '<span id="password-error" style="color: red;"></span>'; // Display error message here
        echo '</div>';

        echo '</form>';

        echo '</div>';
    }
} else {
    echo '<div class="review">';
    echo '<p>No reviews available.</p>';
    echo '</div>';
}

// Scroll position restoration with a delay
echo '<script>';
echo 'setTimeout(function() { window.scrollTo(0, scrollPos); }, 500);';
echo '</script>';

// 데이터베이스 연결 종료
$conn->close();
?>
