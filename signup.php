<?php
require 'db.php';
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $name=trim($_POST['name'] ?? '');
    $email=trim($_POST['email'] ?? '');
    $pass=trim($_POST['password'] ?? '');
    if(!$name || !filter_var($email,FILTER_VALIDATE_EMAIL) || strlen($pass)<6){
        $errors[]='Provide a valid name, email and password (min 6 chars).';
    } else {
        $stmt=$pdo->prepare("SELECT id FROM users WHERE email=?");
        $stmt->execute([$email]);
        if($stmt->fetch()) $errors[]='Email already registered.';
        else {
            $pw = password_hash($pass, PASSWORD_DEFAULT);
            $stmt=$pdo->prepare("INSERT INTO users (name,email,password_hash,role) VALUES (?,?,?, 'user')");
            $stmt->execute([$name,$email,$pw]);
            $id = $pdo->lastInsertId();
            $_SESSION['user'] = ['id'=>$id,'name'=>$name,'email'=>$email,'role'=>'user'];
            header('Location: index.php'); exit;
        }
    }
}
?>
<!doctype html>
<html><head><meta charset="utf-8"><title>Sign Up</title>
<style>body{font-family:Arial;padding:20px}form{max-width:420px;margin:auto;background:#fff;padding:18px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.06)}input{width:100%;padding:10px;margin:8px 0;border:1px solid #ddd;border-radius:6px}button{background:#003580;color:#fff;padding:10px;border:none;border-radius:6px;cursor:pointer}</style>
</head><body>
<h2 style="text-align:center">Create account</h2>
<form method="post">
    <?php if($errors): foreach($errors as $e) echo "<div style='color:red;margin-bottom:8px'>".htmlspecialchars($e)."</div>"; endforeach;?>
    <input name="name" placeholder="Full name" required>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password (min 6)" required>
    <button type="submit">Sign up</button>
</form>
</body></html>
 
