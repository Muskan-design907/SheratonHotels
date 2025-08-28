<?php
// Example hotel list (replace with your DB query if needed)
$hotels = [
    ['name' => 'Pearl Continental', 'location' => 'Lahore', 'price' => '15000 PKR'],
    ['name' => 'Serena Hotel', 'location' => 'Islamabad', 'price' => '20000 PKR'],
    ['name' => 'Mövenpick Hotel', 'location' => 'Karachi', 'price' => '18000 PKR']
];
?>
 
<!DOCTYPE html>
<html>
<head>
    <title>Hotels</title>
</head>
<body>
    <h2>Available Hotels</h2>
 
    <?php foreach ($hotels as $hotel): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px; border-radius:6px;">
            <h3><?php echo $hotel['name']; ?></h3>
            <p>📍 Location: <?php echo $hotel['location']; ?></p>
            <p>💰 Price: <?php echo $hotel['price']; ?></p>
 
            <!-- ✅ One-step booking -->
            <form method="post" action="book.php" style="margin-top:12px">
                <input type="hidden" name="hotel_name" value="<?php echo $hotel['name']; ?>">
                <input type="hidden" name="hotel_price" value="<?php echo $hotel['price']; ?>">
                <input type="hidden" name="hotel_location" value="<?php echo $hotel['location']; ?>">
                <button type="submit" style="
                    background: #2e8b57; 
                    color: white; 
                    padding: 8px 15px; 
                    border: none; 
                    border-radius: 6px; 
                    cursor: pointer; 
                    font-size: 14px;
                    transition: 0.3s;">
                    ✅ Book Now
                </button>
            </form>
        </div>
    <?php endforeach; ?>
 
</body>
</html>
 
