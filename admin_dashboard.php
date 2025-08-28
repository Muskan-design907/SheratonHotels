<?php
require 'db.php';
if(empty($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin'){ header('Location: admin_login.php'); exit; }
 
$msg='';
if(isset($_GET['action']) && isset($_GET['id'])){
    $id=intval($_GET['id']);
    if($_GET['action']==='toggle'){ $pdo->prepare("UPDATE hotels SET is_featured = 1 - is_featured WHERE id = ?")->execute([$id]); header('Location: admin_dashboard.php'); exit; }
    if($_GET['action']==='delete'){ $pdo->prepare("DELETE FROM hotels WHERE id = ?")->execute([$id]); header('Location: admin_dashboard.php'); exit; }
    if($_GET['action']==='delbooking'){ $pdo->prepare("DELETE FROM bookings WHERE id = ?")->execute([$id]); header('Location: view_bookings.php'); exit; }
}
 
// add hotel (handle file upload)
if($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['add_hotel'])){
    $name = trim($_POST['name']); $location = trim($_POST['location']); $desc = trim($_POST['description']);
    $price = floatval($_POST['price']); $rating = floatval($_POST['rating']); $amen = trim($_POST['amenities']);
    $isf = isset($_POST['is_featured']) ? 1 : 0;
    $imagePath = '';
 
    if(isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK){
        $f = $_FILES['image'];
        $ext = pathinfo($f['name'], PATHINFO_EXTENSION);
        $allowed = ['jpg','jpeg','png','webp'];
        if(!in_array(strtolower($ext), $allowed)) $msg = "Invalid image type.";
        else {
            $newName = 'uploads/'.time().'_'.bin2hex(random_bytes(6)).'.'.$ext;
            if(move_uploaded_file($f['tmp_name'], $newName)) $imagePath = $newName;
            else $msg = "Upload failed.";
        }
    } else {
        $imagePath = trim($_POST['image_url'] ?? '');
    }
 
    if(!$name || !$location) $msg = "Name and location required.";
    else {
        $pdo->prepare("INSERT INTO hotels (name, location, description, price, image, rating, amenities, is_featured) VALUES (?,?,?,?,?,?,?,?)")
            ->execute([$name,$location,$desc,$price,$imagePath,$rating,$amen,$isf]);
        $msg = "Hotel added.";
    }
}
 
// fetch all hotels
$hotels = $pdo->query("SELECT * FROM hotels ORDER BY created_at DESC")->fetchAll();
$bookingsCount = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
?>
<!doctype html><html><head><meta charset="utf-8"><title>Admin Dashboard</title>
<style>body{font-family:Arial;padding:18px}.wrap{max-width:1100px;margin:auto} table{width:100%;border-collapse:collapse} th,td{border:1px solid #ddd;padding:8px} form.add{background:#fff;padding:12px;border-radius:8px;margin-bottom:12px} a.btn{padding:6px 10px;background:#003580;color:#fff;text-decoration:none;border-radius:6px}</style>
</head><body>
<div class="wrap">
  <h2>Admin Dashboard</h2>
  <p>Welcome, <?=htmlspecialchars($_SESSION['user']['name'])?> • <a href="logout.php">Logout</a></p>
  <p>Total bookings: <strong><?=$bookingsCount?></strong></p>
 
  <h3>Add hotel</h3>
  <?php if($msg) echo "<div style='color:green'>$msg</div>"; ?>
  <form class="add" method="post" enctype="multipart/form-data">
    <input name="name" placeholder="Hotel name" required style="width:48%;padding:8px;margin:6px">
    <input name="location" placeholder="Location" required style="width:48%;padding:8px;margin:6px"><br>
    <input name="image_url" placeholder="Image URL (optional)" style="width:98%;padding:8px;margin:6px"><br>
    <input type="file" name="image" accept="image/*" style="margin:6px"><br>
    <textarea name="description" placeholder="Description" style="width:98%;padding:8px;margin:6px"></textarea>
    <input name="price" placeholder="Price (e.g. 120.00)" style="padding:8px;margin:6px">
    <input name="rating" placeholder="Rating (e.g. 4.5)" style="padding:8px;margin:6px">
    <input name="amenities" placeholder="Comma separated amenities" style="width:98%;padding:8px;margin:6px">
    <label style="display:block;margin:6px"><input type="checkbox" name="is_featured"> Mark as featured</label>
    <button type="submit" name="add_hotel" style="padding:8px 12px;background:#28a745;color:#fff;border:none;border-radius:6px">Add Hotel</button>
  </form>
 
  <h3>Hotels</h3>
  <table><tr><th>ID</th><th>Name</th><th>Location</th><th>Featured</th><th>Image</th><th>Actions</th></tr>
  <?php foreach($hotels as $h): ?>
    <tr>
      <td><?=$h['id']?></td>
      <td><?=$h['name']?></td>
      <td><?=$h['location']?></td>
      <td><?= $h['is_featured'] ? 'Yes' : 'No' ?></td>
      <td><img src="<?=htmlspecialchars($h['image'])?>" style="max-width:120px"></td>
      <td>
        <a class="btn" href="admin_dashboard.php?action=toggle&id=<?=$h['id']?>">Toggle Featured</a>
        <a class="btn" href="hotel.php?id=<?=$h['id']?>">View</a>
        <a class="btn" href="admin_dashboard.php?action=delete&id=<?=$h['id']?>" onclick="return confirm('Delete hotel?')">Delete</a>
      </td>
    </tr>
  <?php endforeach; ?>
  </table>
 
  <p style="margin-top:12px"><a href="view_bookings.php" class="btn">View All Bookings</a></p>
</div>
</body></html>
 
