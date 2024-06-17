<?php
// Kiểm tra xem session đã được bắt đầu chưa trước khi gọi session_start()
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Bắt đầu session nếu chưa được kích hoạt
}

// Các cấu hình và tệp bao gồm cần thiết
include("../config/config.php");
include("../config/user.php");

$login_error = ""; // Biến báo lỗi cho đăng nhập
$signup_error = ""; // Biến báo lỗi cho đăng ký

// Xử lý đăng nhập
if (isset($_POST['dangnhap'])) {
    $user = trim($_POST['user']); // Tên người dùng
    $pass = trim($_POST['pass']); // Mật khẩu 

    $conn = connectdb(); // Kết nối cơ sở dữ liệu

    if ($conn) { // Kiểm tra nếu kết nối thành công
        $result = checkuser($user, $pass); // Kiểm tra người dùng và trả về kết quả
        
        if ($result !== false && is_array($result)) { // Kiểm tra nếu kết quả là một mảng và không phải false
            if ($result['role'] == 1 || $result['role'] == 0) { // Nếu là admin hoặc người dùng
                $_SESSION['role'] = $result['role']; // Lưu vai trò vào session
                $_SESSION['user'] = array(
                    'id' => $result['id'], // Lưu ID của người dùng vào session
                    'username' => $user, // Lưu tên người dùng vào session
                );
                if ($result['role'] == 1) {
                    header('Location: index.php'); // Chuyển hướng đến trang admin
                } else {
                    header('Location: ../../user/web/index.php'); // Chuyển hướng đến trang người dùng
                }
                exit; // Đảm bảo mã dừng sau khi chuyển hướng
            }
        } else {
            $login_error = "Username or password incorrect"; // Thông báo lỗi đăng nhập
        }
    } else {
        $login_error = "Database connection error"; // Thông báo lỗi kết nối
    }
}

// Xử lý đăng ký
if (isset($_POST['dangki'])) {
    $username = trim($_POST['user']); // Tên người dùng
    $email = trim($_POST['email']); // Email
    $password = trim($_POST['pass']); // Mật khẩu
    $confirm_password = trim($_POST['confirm_pass']); // Xác nhận mật khẩu
    $terms = isset($_POST['terms']); // Kiểm tra điều khoản

    // Kiểm tra tính hợp lệ
    if (!$terms) {
        $signup_error = "Bạn phải đồng ý với điều khoản và điều kiện.";
    } elseif (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $signup_error = "Vui lòng điền tất cả các trường.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $signup_error = "Email không hợp lệ.";
    } elseif ($password !== $confirm_password) {
        $signup_error = "Mật khẩu và xác nhận mật khẩu không khớp.";
    } elseif (strlen($password) < 6) {
        $signup_error = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else {
        $conn = connectdb(); // Kết nối cơ sở dữ liệu
    
        if ($conn) { // Kiểm tra nếu kết nối thành công
            try {
                $check_stmt = $conn->prepare("SELECT COUNT(*) FROM tbl_user WHERE user = ? OR email = ?");
                $check_stmt->execute([$username, $email]);
                $duplicate_count = $check_stmt->fetchColumn(); // Số lượng trùng lặp
                
                if ($duplicate_count > 0) {
                    $signup_error = "Tên người dùng hoặc email đã tồn tại."; // Thông báo lỗi trùng lặp
                } else {
                    // Băm mật khẩu bằng md5
                    $hashed_pass = md5($password); // Mã hóa mật khẩu bằng md5

                    $stmt = $conn->prepare("INSERT INTO tbl_user (user, email, pass) VALUES (?, ?, ?)");
                    $result = $stmt->execute([$username, $email, $hashed_pass]); // Chèn người dùng mới
                    if ($result) {
                        header("Location: login.php"); // Chuyển hướng đến trang đăng nhập
                        exit; // Dừng sau khi chuyển hướng
                    } else {
                        $signup_error = "Đăng ký thất bại, vui lòng thử lại.";
                    }
                }
            } catch (PDOException $e) {
                $signup_error = "Lỗi khi kiểm tra hoặc thêm người dùng vào cơ sở dữ liệu: " . $e->getMessage();
            }
        } else {
            $signup_error = "Database connection error"; // Thông báo lỗi kết nối
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css" rel="stylesheet">
    <style>
        body,
        html {
            height: 100%;
        }

        .container {
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-wrapper {
            max-width: 300px;
            width: 100%;
            padding: 15px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .form-wrapper.active {
            display: block;
        }

        .input-group {
            position: relative;
            margin-bottom: 30px;
        }

        .input-group input {
            width: 100%;
            padding: 15px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            font-size: 16px;
        }

        .input-group label {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            pointer-events: none;
            transition: 0.3s;
        }

        .input-group input:focus + label, 
        .input-group input:valid + label {
            top: 0;
            transform: translateY(-50%);
            font-size: 14px;
            color: #4285f4;
        }

        .btnLogin {
            display: block;
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 5px;
            background-color: #4285f4;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btnLogin:hover {
            background-color: #357ae8;
        }

        .form-footer {
            margin-top: 20px;
            text-align: center;
        }

        .form-footer p {
            margin-bottom: 0;
        }

        .form-footer a {
            color: #4285f4;
            text-decoration: none;
            transition: color 0.3s;
        }

        .form-footer a:hover {
            color: #357ae8;
        }

        .form-footer .separator {
            margin: 0 10px;
            font-size: 14px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="form-wrapper sign-in active">
        <h2 class="text-center mb-4">Login</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <div class="input-group">
                <input type="text" id="user" name="user" required>
                <label for="user">Username</label>
            </div>

            <div class="input-group">
                <input type="password" id="pass" name="pass" required>
                <label for="pass">Password</label>
            </div>

            <?php
            if (!empty($login_error)) { // Hiển thị thông báo lỗi đăng nhập
                echo "<span style='color: red; display: block; margin-bottom: 10px; text-align: center;'>" . $login_error . "</span>";
            }
            ?>

            <input type="submit" name="dangnhap" value="Login" class="btnLogin">

            <div class="form-footer">
                <p>Not a member? <a href="#" class="sign-up-link">Sign Up</a></p>
            </div>
        </form>
    </div>

    <div class="form-wrapper sign-up">
        <h2 class="text-center mb-4">Sign Up</h2>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
            <div class="input-group">
                <input type="text" id="user" name="user" required>
                <label for="user">Username</label>
            </div>

            <div class="input-group">
                <input type="email" id="email" name="email" required>
                <label for="email">Email</label>
            </div>

            <div class="input-group">
                <input type="password" id="pass" name="pass" required>
                <label for="pass">Password</label>
            </div>

            <div class="input-group">
                <input type="password" id="confirm_pass" name="confirm_pass" required>
                <label for="confirm_pass">Confirm Password</label>
            </div>

            <div class="form-check mb-4 text-start">
                <input class="form-check-input" type="checkbox" id="terms" name="terms" value="1">
                <label class="form-check-label" for="terms">I agree to the <a href="#">terms and conditions</a>.</label>
            </div>

            <?php
            if (!empty($signup_error)) { // Hiển thị thông báo lỗi đăng ký
                echo "<span style='color: red; display: block; margin-bottom: 10px; text-align: center;'>" . $signup_error . "</span>";
            }
            ?>

            <input type="submit" name="dangki" value="Sign Up" class="btnLogin">

            <div class="form-footer">
                <p>Already a member? <a href="#" class="sign-in-link">Sign In</a></p>
            </div>
        </form>
    </div>
</div>

<!-- MDB -->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var signInLink = document.querySelector(".sign-in-link");
        var signUpLink = document.querySelector(".sign-up-link");
        var signInForm = document.querySelector(".sign-in");
        var signUpForm = document.querySelector(".sign-up");

        signUpLink.addEventListener("click", function (e) {
            e.preventDefault();
            signInForm.classList.remove("active");
            signUpForm.classList.add("active");
        });

        signInLink.addEventListener("click", function (e) {
            e.preventDefault();
            signUpForm.classList.remove("active");
            signInForm.classList.add("active");
        });

        // Nếu có lỗi đăng ký, hiển thị form đăng ký, ngược lại chuyển đến form đăng nhập
        <?php if (!empty($signup_error)) { ?>
            signInForm.classList.remove("active");
            signUpForm.classList.add("active");
        <?php } ?>
    });
</script>

</body>
</html>
