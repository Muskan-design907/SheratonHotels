<?php
require 'db.php';
if(empty($_SESSION['user']) || $_SESSION['user']['role']!=='admin'){ header('Location: admin_login.php'); exit; }
 
if(isset($_GET['delete']) && intval($_GET['delete'])){
    $pdo->prepare("DELETE FROM bookings WHERE id = ?")->execute([intval($_GET['delete'])]);
    header('Location: view_bookings.php'); exit;
}
 
$stmt = $pdo->query("SELECT b.*, u.name as user_name, u.email as user_email, h.name as hotel_name, h.location as hotel_location
                     FROM bookings b
                     JOIN users u ON b.user_id = u.id
                     JOIN hotels h ON b.hotel_id = h.id
                     ORDER BY b.created_at DESC");
$rows = $stmt->fetchAll();
?>
<!doctype html><html><head><meta charset="utf-8"><title>All Bookings</title>
<style>body{font-family:Arial;padding:18px}table{border-collapse:collapse;width:100%}th,td{border:1px solid #ddd;padding:8px}</style></head><body>
<h2>All Bookings</h2>
<p><a href="admin_dashboard.php">← Back to admin</a></p>
<table>
<tr><th>ID</th><th>Hotel</th><th>User</th><th>Email</th><th>Check-in</th><th>Check-out</th><th>Guests</th><th>Booked At</th><th>Action</th></tr>
<?php foreach($rows as $r): ?>
<tr>
  <td><?=htmlspecialchars($r['id'])?></td>
  <td><?=htmlspecialchars($r['hotel_name'])?> (<?=htmlspecialchars($r['hotel_location'])?>)</td>
  <td><?=htmlspecialchars($r['user_name'])?></td>
  <td><?=htmlspecialchars($r['user_email'])?></td>
  <td><?=htmlspecialchars($r['check_in'])?></td>
  <td><?=htmlspecialchars($r['check_out'])?></td>
  <td><?=htmlspecialchars($r['guests'])?></td>
  <td><?=htmlspecialchars($r['created_at'])?></td>
  <td><a href="view_bookings.php?delete=<?= $r['id'] ?>" onclick="return confirm('Delete booking?')">Delete</a></td>
</tr>
<?php endforeach; ?>
</table>
</body></html>
 
