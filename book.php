<?php
// Process booking only if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $hotel_name = $_POST['hotel_name'] ?? '';
    $hotel_price = $_POST['hotel_price'] ?? '';
    $hotel_location = $_POST['hotel_location'] ?? '';
 
    // Here you can insert booking details into DB if needed
    // Example: mysqli_query($conn, "INSERT INTO bookings (...) VALUES (...)");
 
    echo "<h2 style='color:green;'>✅ Booking Successful!</h2>";
    echo "<p>You have booked: <b>$hotel_name</b></p>";
    echo "<p>📍 Location: $hotel_location</p>";
    echo "<p>💰 Price: $hotel_price</p>";
    echo "<a href='hotel.php' style='color:blue;'>🔙 Back to Hotels</a>";
} else {
    echo "<p style='color:red;'>❌ No booking data received.</p>";
    echo "<a href='hotel.php'>Back to Hotels</a>";
}
?>
 
