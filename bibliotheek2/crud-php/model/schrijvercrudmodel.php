<?php
include_once '../db_conn.php';

if (isset($_POST['naam'])) {
    $naam = $_POST['naam'];
    $nationaliteit = $_POST['nationaliteit'];
    $geboortedatum = $_POST['geboortedatum'];
    $beschrijving = $_POST['beschrijving'];

    // Insert schrijver information into the database using prepared statement
    $sql = "INSERT INTO schrijvers (naam, nationaliteit, geboortedatum, beschrijving) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);

    if (mysqli_stmt_prepare($stmt, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $naam, $nationaliteit, $geboortedatum, $beschrijving);

        if (mysqli_stmt_execute($stmt)) {
            mysqli_stmt_close($stmt);
            mysqli_close($conn);
            header("Location: ../view/read.php");
            exit();
        } else {
            echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
        }
    } else {
        echo "ERROR: Could not prepare $sql. " . mysqli_error($conn);
    }
}

// Uncomment the following lines to display errors and debug information
error_reporting(E_ALL);
ini_set('display_errors', true);

var_dump($_POST);

mysqli_close($conn);
?>
