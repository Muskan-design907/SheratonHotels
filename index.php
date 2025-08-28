<?php
require 'db.php';
 
// fetch featured hotels
$stmt = $pdo->query("SELECT * FROM hotels WHERE is_featured = 1 ORDER BY rating DESC LIMIT 6");
$featured = $stmt->fetchAll();
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sheraton-like — Home</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<style>
/* internal CSS similar to earlier design */
body{font-family:Arial,Helvetica,sans-serif;margin:0;background:#f6f7f8;color:#222}
.header{background:#003580;color:#fff;padding:14px 18px;display:flex;justify-content:space-between;align-items:center}
.header .brand{font-weight:700}
.container{max-width:1100px;margin:20px auto;padding:0 18px}
.searchbar{background:#fff;padding:16px;border-radius:8px;box-shadow:0 6px 20px rgba(0,0,0,0.06);display:flex;gap:10px;align-items:center;flex-wrap:wrap}
.searchbar input{padding:10px;border:1px solid #ddd;border-radius:6px;min-width:160px}
.searchbar button{background:#c1272d;color:#fff;border:none;padding:10px 14px;border-radius:6px;cursor:pointer}
.feature-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(240px,1fr));gap:16px;margin-top:18px}
.card{background:#fff;border-radius:8px;overflow:hidden;box-shadow:0 6px 18px rgba(0,0,0,0.06)}
.card img{width:100%;height:160px;object-fit:cover;display:block}
.card .body{padding:12px}
.admin-btn{background:#333;color:#fff;padding:8px 12px;border-radius:6px;text-decoration:none}
.small{font-size:13px;color:#666}
@media(max-width:600px){.searchbar{flex-direction:column}}
</style>
</head>
<body>
  <div class="header">
    <div class="brand">Sheraton-style Booking (Demo)</div>
    <div>
      <?php if(!empty($_SESSION['user'])): ?>
        Hello, <?=htmlspecialchars($_SESSION['user']['name'])?> • <a href="logout.php" style="color:#fff;text-decoration:underline">Logout</a>
        &nbsp;•&nbsp;<a href="my_bookings.php" style="color:#fff;text-decoration:underline">My Bookings</a>
      <?php else: ?>
        <a href="login.php" style="color:#fff;text-decoration:underline;margin-right:10px">Login</a>
        <a href="signup.php" style="color:#fff;text-decoration:underline">Sign up</a>
      <?php endif; ?>
      &nbsp;&nbsp;
      <a href="admin_login.php" class="admin-btn">Admin</a>
    </div>
  </div>
 
  <div class="container">
    <div class="searchbar">
      <form method="get" action="search.php" style="display:flex;gap:8px;flex:1;align-items:center;flex-wrap:wrap">
        <input type="text" name="destination" placeholder="Destination (e.g., Islamabad)" required>
        <label class="small">Check-in <input type="date" name="checkin"></label>
        <label class="small">Check-out <input type="date" name="checkout"></label>
        <select name="guests" style="padding:10px;border-radius:6px;border:1px solid #ddd">
          <option value="1">1 guest</option>
          <option value="2">2 guests</option>
          <option value="3">3 guests</option>
          <option value="4">4 guests</option>
        </select>
        <button type="submit">Search</button>
      </form>
    </div>
 
    <h2 style="margin-top:18px">Featured Hotels</h2>
    <div class="feature-grid">
      <?php foreach($featured as $h): ?>
        <div class="card">
          <img src="<?=htmlspecialchars($h['image'])?>" alt="<?=htmlspecialchars($h['name'])?>">
          <div class="body">
            <h3 style="margin:0"><?=htmlspecialchars($h['name'])?></h3>
            <div class="small"><?=htmlspecialchars($h['location'])?></div>
            <div style="margin-top:8px;font-weight:700">$<?=number_format($h['price'],2)?> / night</div>
            <div style="margin-top:10px"><a href="hotel.php?id=<?=$h['id']?>" style="color:#c1272d;text-decoration:none">View & Book →</a></div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>
</html>
 
