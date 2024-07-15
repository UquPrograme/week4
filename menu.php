<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_menu";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$categories = ['Starters', 'Breakfast', 'Lunch', 'Dinner'];

foreach ($categories as $category) {
    $sql = "SELECT * FROM menu_items WHERE category='$category'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<div class='tab-pane fade' id='menu-".strtolower($category)."'>";
        echo "<div class='tab-header text-center'>";
        echo "<p>Menu</p>";
        echo "<h3>$category</h3>";
        echo "</div>";
        echo "<div class='row gy-5'>";

        while($row = $result->fetch_assoc()) {
            echo "<div class='col-lg-4 menu-item'>";
            echo "<a href='".$row['image_url']."' class='glightbox'><img src='".$row['image_url']."' class='menu-img img-fluid' alt=''></a>";
            echo "<h4>".$row['title']."</h4>";
            echo "<p class='ingredients'>".$row['description']."</p>";
            echo "<p class='price'>$".$row['price']."</p>";
            echo "</div>";
        }

        echo "</div>";
        echo "</div>";
    }
}

$conn->close();
?>