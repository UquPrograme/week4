<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Edit Menu Items - Yummy Bootstrap Template</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900&family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Amatic+SC:wght@400;700&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="assets/vendor/aos/aos.css" rel="stylesheet">
    <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
    <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- =======================================================
    * Template Name: Yummy
    * Template URL: https://bootstrapmade.com/yummy-bootstrap-restaurant-website-template/
    * Updated: Jun 29 2024 with Bootstrap v5.3.3
    * Author: BootstrapMade.com
    * License: https://bootstrapmade.com/license/
    ======================================================== -->
</head>

<body class="starter-page-page">

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container position-relative d-flex align-items-center justify-content-between">

            <a href="index.php" class="logo d-flex align-items-center me-auto me-xl-0">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">Yummy</h1>
                <span>.</span>
            </a>

            <nav id="navmenu" class="navmenu">
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="add_product.php">add new</a>

        </div>
    </header>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title" data-aos="fade">
            <div class="container">
                <h1>Edit the menu items</h1>
            </div>
        </div>

        <!-- Display Menu Items -->
        <div class="container">
            <div class="row">
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

                // Handle form submission for updating menu items
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
                    $id = $_POST['id'];
                    $title = $_POST['title'];
                    $description = $_POST['description'];
                    $price = $_POST['price'];
                    $category = $_POST['category'];
                    $image_url = $_POST['image_url'];

                    $update_sql = "UPDATE menu_items SET title='$title', description='$description', price='$price', category='$category', image_url='$image_url' WHERE id='$id'";
                    if ($conn->query($update_sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Menu item updated successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error updating menu item: " . $conn->error . "</div>";
                    }
                }

                // Handle form submission for deleting menu items
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'delete') {
                    $id = $_POST['id'];

                    $delete_sql = "DELETE FROM menu_items WHERE id='$id'";
                    if ($conn->query($delete_sql) === TRUE) {
                        echo "<div class='alert alert-success' role='alert'>Menu item deleted successfully.</div>";
                    } else {
                        echo "<div class='alert alert-danger' role='alert'>Error deleting menu item: " . $conn->error . "</div>";
                    }
                }

                $sql = "SELECT * FROM menu_items";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    // Output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='col-lg-4 menu-item'>";
                        echo "<h4>".$row['title']."</h4>";
                        echo "<p>".$row['description']."</p>";
                        echo "<p>$".$row['price']."</p>";
                        echo "<p>Category: ".$row['category']."</p>";
                        echo "<p><img src='".$row['image_url']."' alt='Image' style='width:100%; height:auto;'></p>";

                        // Edit form
                        echo "<form method='POST' action='edit.php'>";
                        echo "<input type='hidden' name='id' value='".$row['id']."'>";
                        echo "<input type='hidden' name='action' value='update'>";
                        echo "<div class='mb-3'>";
                        echo "<label for='title' class='form-label'>Title</label>";
                        echo "<input type='text' class='form-control' id='title' name='title' value='".$row['title']."' required>";
                        echo "</div>";
                        echo "<div class='mb-3'>";
                        echo "<label for='description' class='form-label'>Description</label>";
                        echo "<textarea class='form-control' id='description' name='description' rows='3' required>".$row['description']."</textarea>";
                        echo "</div>";
                        echo "<div class='mb-3'>";
                        echo "<label for='price' class='form-label'>Price</label>";
                        echo "<input type='number' class='form-control' id='price' name='price' value='".$row['price']."' step='0.01' required>";
                        echo "</div>";
                        echo "<div class='mb-3'>";
                        echo "<label for='category' class='form-label'>Category</label>";
                        echo "<input type='text' class='form-control' id='category' name='category' value='".$row['category']."' required>";
                        echo "</div>";
                        echo "<div class='mb-3'>";
                        echo "<label for='image_url' class='form-label'>Image URL</label>";
                        echo "<input type='text' class='form-control' id='image_url' name='image_url' value='".$row['image_url']."' required>";
                        echo "</div>";
                        echo "<button type='submit' class='btn btn-primary'>Save Changes</button>";
                        echo "</form>";

                        // Delete form
                        echo "<form method='POST' action='edit.php' class='mt-2'>";
                        echo "<input type='hidden' name='id' value='".$row['id']."'>";
                        echo "<input type='hidden' name='action' value='delete'>";
                        echo "<button type='submit' class='btn btn-danger'>Delete</button>";
                        echo "</form>";

                        echo "</div>";
                    }
                } else {
                    echo "0 results";
                }

                $conn->close();
                ?>
            </div>
        </div>

    </main>

    <footer id="footer" class="footer dark-background">

        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-geo-alt icon"></i>
                    <div class="address">
                        <h4>Address</h4>
                        <p>A108 Adam Street</p>
                        <p>New York, NY 535022</p>
                        <p></p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-telephone icon"></i>
                    <div>
                        <h4>Contact</h4>
                        <p>
                            <strong>Phone:</strong> <span>+1 5589 55488 55</span><br>
                            <strong>Email:</strong> <span>info@example.com</span><br>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-clock icon"></i>
                    <div>
                        <h4>Opening Hours</h4>
                        <p>
                            <strong>Mon-Sat:</strong> <span>11AM - 23PM</span><br>
                            <strong>Sunday</strong>: <span>Closed</span>
                        </p>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <h4>Follow Us</h4>
                    <div class="social-links d-flex">
                        <a href="#" class="twitter"><i class="bi bi-twitter"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">Yummy</strong> <span>All Rights Reserved</span></p>
            <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you've purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>

    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>

</body>

</html>
