<!-- GetReview.php -->
<?php
// 데이터베이스 연결 설정
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "RESTAURANT";

// 데이터베이스 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// Scroll position preservation
echo '<script>';
echo 'var scrollPos = window.scrollY || window.scrollTop || document.getElementsByTagName("html")[0].scrollTop;';
echo '</script>';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the delete button is clicked
    if (isset($_POST['submit'])) {
        // Get the entered password and review code
        $enteredPassword = $_POST['password'];
        $reviewCode = $_POST['review_code'];

        // Retrieve the correct password from the database based on the review code
        $passwordSql = "SELECT password FROM review WHERE review_code = '$reviewCode'";
        $passwordResult = $conn->query($passwordSql);

        if ($passwordResult->num_rows > 0) {
            $row = $passwordResult->fetch_assoc();
            $correctPassword = $row['password'];

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
                    echo '<script>';
                    echo 'alert("Review deleted successfully.");';
                    echo '</script>';
                } else {
                    echo '<script>';
                    echo 'alert("Error deleting review: ' . $conn->error . '");';
                    echo '</script>';
                }
            }
        }
    }
}

session_start();
// 데이터베이스에서 리뷰 가져오기
$sql = "SELECT * FROM review WHERE Code = '".  $_SESSION['CODE'] ."' ORDER BY review_code DESC";
$result = $conn->query($sql);

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
