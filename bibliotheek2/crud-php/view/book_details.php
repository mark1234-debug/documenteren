<?php
include "db_conn.php";
/**
 * @uses
 * hello there
 * 
 */

session_start(); $_SESSION['activeTab'] = 'boeken'; $activeTab = $_SESSION['activeTab']; include_once("navbar.php"); 

$result = null; // Declare and initialize $result variable

if (isset($_GET['boek_id'])) {
    $bookId = $_GET['boek_id'];
    $sql = "SELECT * FROM boeken WHERE boek_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $bookId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        $book = mysqli_fetch_assoc($result);
        // Continue with displaying the book details
    } else {
        echo "Book not found.";
    }
} else {
    echo "Invalid book ID.";
}

if (!$result) {
    echo "Error: " . mysqli_error($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Details</title>
    <style>
        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            width: 400px;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .popup p {
            margin: 0;
        }

        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }

        .main{
            background-color: rgb(195, 214, 210);
            width: 1000px;
            height: 1500px;
            display: flex;
            display: grid; 
            place-items: center;
        }

        body{
            display: flex;
            display: grid; 
            place-items: center;
        }


        .main {
        background-color: rgb(195, 214, 210);
        width: 1000px;
        height: 1500px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .bookdetails {
        display: grid;
        gap: 10px;
    }

    .image {
        display: flex;
        justify-content: left;
        align-items: center;
    }

    </style>
    <script>
        function showPopup() {
            document.getElementById('popup').style.display = 'block';
            document.getElementById('overlay').style.display = 'block';
        }

        function hidePopup() {
            document.getElementById('popup').style.display = 'none';
            document.getElementById('overlay').style.display = 'none';
        }
    </script>
</head>
<body>
    <div class="main">
    <?php if (isset($book)): ?>
        <div class="bookdetails">
        <h2>Book Details</h2>
        <p>Title: <?=$book['titel']?></p>
        <p>Category: <?=$book['categorie']?></p>
        <p>Publisher: <?=$book['uitgever']?></p>
        <p>Author: <?=$book['schrijver']?></p>
        <p>Description: <?=$book['description']?></p>
        <a href="">uitlenen</a>
        <!-- Additional book details -->
        </div>
        <div class="image">
            <img src="../uploads/<?=$book['image']?>" alt="<?=$book['titel']?>" onclick="showPopup()">
        </div>





        

        <div id="overlay" class="overlay"></div>

    <?php endif; ?>
    </div>
</body>
</html>
