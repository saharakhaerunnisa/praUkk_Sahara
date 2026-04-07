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
        
        $_SESSION['user_id']  = $row['id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['role']     = $row['role'];

        if ($row['role'] == 'Admin') {
            header("Location: admin/dashboard.php");
            exit(); 
        } elseif ($row['role'] == 'Siswa') {
            header("Location: siswa/dashboard.php");
            exit(); 
        }
    } else {
        echo "<script>alert('Username atau Password Salah!'); window.location='index.php';</script>";
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
</head>
<body>
    <main>
        <div class="content">
            <article class="card">
                <h1>Login</h1>
                    <form method="POST">
                        <input type="text" name="username" placeholder="Username" required>
                        <input type="password" name="password" placeholder="Password" required>
                        <br><br>
                        <button type="submit" name="login">Login</button>
                    </form>
            </article>
        </div>
    </main>
</body>
</html>