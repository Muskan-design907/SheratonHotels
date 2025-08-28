<?php
require 'db.php';
$destination = trim($_GET['destination'] ?? '');
$checkin = $_GET['checkin'] ?? '';
$checkout = $_GET['checkout'] ?? '';
$guests = intval($_GET['guests'] ?? 1);
$hotels = [];
if($destination !== ''){
    $stmt = $pdo->prepare("SELECT * FROM hotels WHERE location LIKE :d OR name LIKE :d ORDER BY rating DESC");
    $stmt->execute([':d'=>"%{$destination}%"]);
    $hotels = $stmt->fetchAll();
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Search: <?=htmlspecialchars($destination)?></title>
<style>body{font-family:Arial;margin:0;background:#f5f5f5} .container{max-width:1100px;margin:20px auto;padding:0 18px}.header{background:#003580;color:#fff;padding:12px 18px;display:flex;justify-content:space-between;align-items:center}.card{background:#fff;border-radius:8px;box-shadow:0 6px 18px rgba(0,0,0,0.06);overflow:hidden;display:flex;margin:16px 0}.card img{width:320px;height:220px;object-fit:cover}.card .body{padding:14px;flex:1}.btn{background:#c1272d;color:#fff;padding:10px 14px;border-radius:6px;text-decoration:none}.small{color:#666;font-size:14px}</style>
</head><body>
<div class="header"><div>Search results</div><div><a href="index.php" style="color:#fff;text-decoration:underline">Home</a></div></div>
<div class="container">
  <h2>Hotels matching "<?=htmlspecialchars($destination)?>"</h2>
  <?php if(empty($hotels)): ?>
    <p style="color:#666">No hotels found for that destination.</p>
  <?php else: foreach($hotels as $h): ?>
    <div class="card">
      <img src="<?=htmlspecialchars($h['image'])?>" alt="">
      <div class="body">
        <h3><?=htmlspecialchars($h['name'])?></h3>
        <div class="small"><?=htmlspecialchars($h['location'])?> • <?=htmlspecialchars($h['rating'])?> ★</div>
        <p style="margin-top:10px"><?=htmlspecialchars(substr($h['description'],0,200))?></p>
        <div style="margin-top:12px;font-weight:700">$<?=number_format($h['price'],2)?> / night</div>
        <div style="margin-top:12px">
          <a class="btn" href="hotel.php?id=<?=$h['id']?>&checkin=<?=$checkin?>&checkout=<?=$checkout?>&guests=<?=$guests?>">View & Book</a>
        </div>
      </div>
    </div>
  <?php endforeach; endif; ?>
</div>
</body></html>
 
