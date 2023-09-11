<?php

include "db_conn.php";

session_start(); $_SESSION['activeTab'] = 'boeken'; $activeTab = $_SESSION['activeTab']; include_once("navbar.php"); 

$sql = "SELECT * FROM boeken";
$result = mysqli_query($conn, $sql);

if (isset($_GET['filter']) && isset($_GET['filter_query'])) {
    $filter = $_GET['filter'];
    $filter_query = $_GET['filter_query'];
    // Prepare the query using placeholders
    $sql = "SELECT * FROM boeken WHERE $filter LIKE ?";
    $stmt = mysqli_prepare($conn, $sql);

    // Bind the values to the placeholders
    $filter_query = '%' . $filter_query . '%';
    mysqli_stmt_bind_param($stmt, "s", $filter_query);

    // Execute the prepared statement
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $sql = "SELECT boeken.*, images.image_path FROM boeken LEFT JOIN images ON boeken.boek_id = images.boek_id";
  include("../navbar.php");


}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style.css">
    <title>Crud</title>
</head>
<body> 


<!--filter systeem-->
    <div class="sidebar">
        <h2>Filters</h2>
        <form action="" method="get">
            <label for="filter">Filter by:</label>
            <select name="filter" id="filter">
                <option value="titel">Title</option>
                <option value="categorie">Category</option>
                <option value="datum">Date</option>
                <option value="uitgever">Publisher</option>
                <option value="schrijver">Author</option>
            </select>
            <br>
            <label for="filter_query">Search term:</label>
            <input type="text" name="filter_query" id="filter_query">
            <br>
            <button type="submit">Filter</button>
        </form>
    </div>

    <div class="container">
        <div class="box">
            <?php
            $i = 0;
            while ($rows = mysqli_fetch_assoc($result)) {
                $i++;
                ?>
                <tr>
                    <td>
                        <div class="row">
                            <div class="boek1">
                                <div class="col-md-4">
                                    <!--het plaatje-->
                                    <a href="book_details.php?boek_id=<?=$rows['boek_id']?>"> <!--als je op het plaatje klikt kom je op een pagina met meer info over het boek-->
                                        <?php if (!empty($rows['image'])) { ?>
                                            <img src="../uploads/<?=$rows['image']?>" alt="<?=$rows['titel']?>" width="100">
                                        <?php } else { ?>
                                            <img src="../uploads/plaatje boek.png" alt="No Image" width="100">
                                        <?php } ?>
                                    </a>
                                </div>
                                
                                <?php 
                                
                                
                                ?>
                                    <!--de boek informatie-->
                                <div class="col-md-8">
                                    <h5 class="Titel">Titel: <br><?=$rows['titel']?></h5>

                                    <p class="rows"><?=$rows['categorie']?></p>

                                    <!--<p><?=$rows['datum']?></p>-->

                                    <p class="rows">Publisher: <?=$rows['uitgever']?></p>

                                    <p class="rows">Schrijver <?=$rows['schrijver']?></p>

                                    <p class="rows">Uitgeleend: <?php if ($rows['uitgeleend'] == 0) {
                                            echo "Nee";
                                        } else {
                                            echo "Ja";
                                        } ?></p>
                                    <p><?=$rows['description']?></p>

                                    <div><!--het gedeelte dat voor de rollen zorgt-->
                                        <?php if (isset($_SESSION['role']) && $_SESSION['role'] == 'Lezer') {
                                            if ($rows['uitgeleend'] == 0) { ?>
                                                <form action="borrow_book.php" method="POST">
                                                    <input type="hidden" name="boek_id" value="<?=$rows['boek_id']?>">
                                                    <button type="submit" name="uitlenen" class="btn btn-primary">Borrow</button>
                                                </form>
                                            <?php } else { ?>
                                                <p>dit boek is al uitgeleend.</p>
                                            <?php }
                                        } elseif (isset($_SESSION['role']) && ($_SESSION['role'] == 'Medewerker' || $_SESSION['role'] == 'Admin')) { ?>
                                            <a href="update.php?id=<?=$rows['boek_id']?>" class="btn btn-warning">Edit</a>
                                            <a href="delete.php?id=<?=$rows['boek_id']?>" class="btn btn-danger">Delete</a>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php } ?>
        </div>
    </div>
</body>
</html>
