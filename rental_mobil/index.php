<?php
session_start();
include 'config.php';

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($connect, $_POST['username']);
    $password = mysqli_real_escape_string($connect, $_POST['password']);

    $query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
    $result = mysqli_query($connect, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];

        if ($row['role'] == 'Admin') {
            header("Location: admin/dashboard.php");
        } elseif ($row['role'] == 'Petugas') {
            header("Location: petugas/dashboard.php");
        }
        exit(); 
    } else {
        echo "<script>alert('Username atau Kode Salah!'); window.location='index.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/input.css">
    <style>    
        select, input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px; /* Jarak antar kolom input */
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box; /* Sangat penting agar padding tidak merusak lebar */
            font-size: 15px;
            transition: 0.3s;
        }

        option {
            color: #555;
        }
    </style>
    </style>
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form method="POST">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Kode User" required>
            <br><br>
            <button type="submit" name="login">Login</button>
        </form>
    </div>
</body>
</html>

