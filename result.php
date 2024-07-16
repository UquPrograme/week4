<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Yummy Bootstrap Template</title>

    <!-- Bootstrap CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <!-- Main CSS -->
    <link href="assets/css/main.css" rel="stylesheet">
</head>

<body>

    <div class="container mt-5">
        <?php
        // Check if a search query was submitted
        if (isset($_GET['q'])) {
            // Connect to database
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

            // Handle search query
            $query = $_GET['q'];
            $query = mysqli_real_escape_string($conn, $query);

            if (!empty($query)) {
                $sql = "SELECT category, title, description FROM menu_items WHERE 
                        category LIKE '%$query%' OR 
                        title LIKE '%$query%' OR 
                        description LIKE '%$query%'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    ?>
                    <div class="card">
                        <div class="card-header bg-light text-success">
                            <h2 class="text-center">Search Results</h2>
                        </div>
                        <div class="card-body">
                        <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Category</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    while ($row = $result->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row["category"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["title"]); ?></td>
                                            <td><?php echo htmlspecialchars($row["description"]); ?></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php
                } else {
                    echo '<p class="alert alert-info">No results found.</p>';
                }
            }

            $conn->close();
        }
        ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- Main JS -->
    <script src="assets/js/main.js"></script>

</body>

</html>
