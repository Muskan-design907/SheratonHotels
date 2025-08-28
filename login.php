<?php
require 'db.php';
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email'] ?? '');
    $pass=trim($_POST['password'] ?? '');
    if(!$email || !$pass) $err='Enter email & password.';
    else {
        $stmt=$pdo->prepare("SELECT * FROM users WHERE email=? LIMIT 1");
        $stmt->execute([$email]);
        $u=$stmt->fetch();
        if(!$u) $err='Invalid credentials.';
        else {
            if(password_verify($pass, $u['password_hash'])){
                $_SESSION['user'] = ['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
                if($u['role']==='admin') header('Location: admin_dashboard.php');
                else header('Location: index.php');
                exit;
            } else $err='Invalid credentials.';
        }
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Login</title>
<style>body{font-family:Arial;padding:20px}form{max-width:420px;margin:auto;background:#fff;padding:18px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.06)}input{width:100%;padding:10px;margin:8px 0;border:1px solid #ddd;border-radius:6px}button{background:#003580;color:#fff;padding:10px;border:none;border-radius:6px;cursor:pointer}</style>
</head><body>
<h2 style="text-align:center">Login</h2>
<form method="post">
    <?php if($err) echo "<div style='color:red;margin-bottom:8px'>".htmlspecialchars($err)."</div>"; ?>
    <input name="email" type="email" placeholder="Email" required>
    <input name="password" type="password" placeholder="Password" required>
    <button type="submit">Login</button>
    <p style="text-align:center;margin-top:8px">Don't have an account? <a href="signup.php">Sign up</a></p>
</form>
</body></html>
 
