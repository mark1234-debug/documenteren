<?php
/*include "./db_conn.php";

if (isset($_GET['filter']) && isset($_GET['filter_query'])) {
    $filter = $_GET['filter'];
    $filter_query = $_GET['filter_query'];
    
    // Prepare the query using placeholders
    $sql = "SELECT boeken.*, images.image_path FROM boeken LEFT JOIN images ON boeken.boek_id = images.boek_id WHERE $filter LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the values to the placeholders
    $filter_query = '%' . $filter_query . '%';
    mysqli_stmt_bind_param($stmt, "s", $filter_query);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    // Fetch all books
    $sql = "SELECT boeken.*, images.image_path FROM boeken LEFT JOIN images ON boeken.boek_id = images.boek_id";
    $result = mysqli_query($conn, $sql);
}

include("./navbar.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Head content here -->
</head>
<body> 
    <div class="navbar">
        <!-- Navbar content here -->
    </div>

    <div class="sidebar">
        <!-- Sidebar content here -->
    </div>

    <div class="container">
        <div class="box">
            <?php
            $i = 0;
            while ($rows = mysqli_fetch_assoc($result)) {
                $i++;
                ?>
                <tr>
                    <!-- Book information display code here -->
                </tr>
            <?php } ?>
        </div>
    </div>
</body>
</html>