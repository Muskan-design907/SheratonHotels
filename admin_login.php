<?php
require 'db.php';
session_start();
$err='';
if($_SERVER['REQUEST_METHOD']==='POST'){
    $email=trim($_POST['email'] ?? '');
    $pass=trim($_POST['password'] ?? '');
 
    if(!$email || !$pass) {
        $err='Enter credentials.';
    } else {
        // ✅ Check for your fixed admin login first
        if($email === 'muskannaeem435@gmail.com' && $pass === '/123xyz@@/') {
            $_SESSION['user']=[
                'id'=>0,
                'name'=>'Muskan Naeem',
                'email'=>$email,
                'role'=>'admin'
            ];
            header('Location: admin_dashboard.php'); 
            exit;
        }
 
        // Otherwise, check from database
        $stmt=$pdo->prepare("SELECT * FROM users WHERE email=? AND role='admin' LIMIT 1");
        $stmt->execute([$email]);
        $u=$stmt->fetch();
        if(!$u) {
            $err='Invalid admin credentials.';
        } else {
            if(password_verify($pass,$u['password_hash'])){
                $_SESSION['user']=['id'=>$u['id'],'name'=>$u['name'],'email'=>$u['email'],'role'=>$u['role']];
                header('Location: admin_dashboard.php'); 
                exit;
            } else {
                $err='Invalid admin credentials.';
            }
        }
    }
}
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Admin Login</title>
<style>
body{font-family:Arial;padding:20px}
form{max-width:360px;margin:auto;background:#fff;padding:14px;border-radius:8px;box-shadow:0 4px 12px rgba(0,0,0,0.06)}
input{width:100%;padding:10px;margin:8px 0;border:1px solid #ddd;border-radius:6px}
button{background:#333;color:#fff;padding:10px;border:none;border-radius:6px}
</style>
</head>
<body>
<h2 style="text-align:center">Admin Login</h2>
<form method="post">
<?php if($err) echo "<div style='color:red'>".htmlspecialchars($err)."</div>"; ?>
<input name="email" type="email" placeholder="Admin email" required>
<input name="password" type="password" placeholder="Password" required>
<button type="submit">Login</button>
</form>
</body>
</html>
 
