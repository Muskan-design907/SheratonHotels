<?php
require 'db.php';
if(empty($_SESSION['user'])){ header('Location: login.php'); exit; }
$user_id = $_SESSION['user']['id'];
$stmt = $pdo->prepare("SELECT b.*, h.name as hotel_name, h.location FROM bookings b JOIN hotels h ON b.hotel_id=h.id WHERE b.user_id=? ORDER BY b.created_at DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>My Bookings</title><style>body{font-family:Arial;padding:20px}table{width:100%;border-collapse:collapse}th,td{padding:8px;border:1px solid #ddd}</style></head><body>
<h2>My Bookings</h2>
<p><a href="index.php">Home</a></p>
<?php if(empty($bookings)): ?><p>You have no bookings yet.</p><?php else: ?>
<table><tr><th>ID</th><th>Hotel</th><th>Check-in</th><th>Check-out</th><th>Guests</th><th>Booked At</th></tr>
<?php foreach($bookings as $b): ?>
<tr>
<td><?=htmlspecialchars($b['id'])?></td>
<td><?=htmlspecialchars($b['hotel_name'])?> (<?=htmlspecialchars($b['location'])?>)</td>
<td><?=htmlspecialchars($b['check_in'])?></td>
<td><?=htmlspecialchars($b['check_out'])?></td>
<td><?=htmlspecialchars($b['guests'])?></td>
<td><?=htmlspecialchars($b['created_at'])?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endif; ?>
</body></html>
 
