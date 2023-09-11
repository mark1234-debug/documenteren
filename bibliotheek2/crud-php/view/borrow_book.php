<?php
$phpdoc;
/**
 * 
 * dit is een docblock
 * 
 * @return void
 */

include "db_conn.php";

if (isset($_POST['uitlenen'])) {
    $boek_id = $_POST['boek_id'];
    $gebruiker_id = $_SESSION['id'];

    // Check if the book is available for borrowing
    $sql = "SELECT uitgeleend FROM boeken WHERE boek_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $boek_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $book = mysqli_fetch_assoc($result);

    if ($book['uitgeleend'] == 0) {
        // Update the book status to borrowed
        $sql = "UPDATE boeken SET uitgeleend = 1 WHERE boek_id = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $boek_id);
        mysqli_stmt_execute($stmt);

        // Insert a new entry in the borrowed_books table
        $sql = "INSERT INTO borrowed_books (user_id, book_id) VALUES (?, ?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "ii", $id, $boek_id);
        mysqli_stmt_execute($stmt);

        echo "Book borrowed successfully.";
    } else {
        echo "Sorry, this book is already borrowed.";
    }
}
?>
