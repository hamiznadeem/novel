<?php
session_start();
include 'database/db_conn.php';

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){
       $data = trim($data);
       $data = stripslashes($data);
       $data = htmlspecialchars($data);
       return $data;
    }

    $uname = validate($_POST['username']);
    $pass = validate($_POST['password']);

    if (empty($uname)) {
        header("Location: admin_login.php?error=User Name is required");
        exit();
    }else if(empty($pass)){
        header("Location: admin_login.php?error=Password is required");
        exit();
    }else{
        $sql = "SELECT * FROM admin_login WHERE username=? ";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            if (password_verify($pass, $row['password'])) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                header("Location: dashboard.php");
                exit();
            } else {
                header("Location: admin_login.php?error=Incorect User name or password");
                exit();
            }
        } else {
            header("Location: admin_login.php?error=Incorect User name");
            exit();
        }
    }
    // To create a user with a hashed password, you can use the following PHP code.
    // You can run this in a separate script or use a tool like phpMyAdmin to insert a user.
    // $username = 'admin';
    // $password = 'password';
    // $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    // $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    // $stmt = $conn->prepare($sql);
    // $stmt->bind_param("ss", $username, $hashed_password);
    // $stmt->execute();

}else{
    header("Location: admin_login.php");
    exit();
}
