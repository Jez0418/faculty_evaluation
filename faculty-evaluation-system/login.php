<?php
session_start();
require 'includes/db.php';

$error = "";

if(isset($_POST['login'])){

    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username=?");
    $stmt->execute([$username]);

    $user = $stmt->fetch();

    if($user && password_verify($password,$user['password'])){

        $_SESSION['user_id']=$user['id'];
        $_SESSION['fullname']=$user['fullname'];
        $_SESSION['role']=$user['role'];

        if($user['role']=="admin"){

            header("Location: admin/dashboard.php");

        }else{

            header("Location: student/dashboard.php");

        }

        exit;

    }else{

        $error="Invalid Username or Password";

    }

}
?>

<!DOCTYPE html>
<html>
<head>

<title>Faculty Evaluation System</title>

<style>

body{
font-family:Arial;
background:#f4f4f4;
display:flex;
justify-content:center;
align-items:center;
height:100vh;
}

.login-box{

width:350px;
background:white;
padding:30px;
border-radius:10px;
box-shadow:0 0 15px rgba(0,0,0,.2);

}

input{

width:100%;
padding:10px;
margin:10px 0;

}

button{

width:100%;
padding:10px;
background:#007bff;
color:white;
border:none;
cursor:pointer;

}

.error{

color:red;

}

</style>

</head>

<body>

<div class="login-box">

<h2 align="center">
Faculty Evaluation
</h2>

<?php if($error!=""){ ?>

<p class="error"><?php echo $error; ?></p>

<?php } ?>

<form method="POST">

<input
type="text"
name="username"
placeholder="Username"
required>

<input
type="password"
name="password"
placeholder="Password"
required>

<button
name="login">

Login

</button>

</form>

</div>

</body>

</html>