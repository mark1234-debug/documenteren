<?php
include_once '../db_conn.php';

if (isset($_POST['titel']) && isset($_POST['cat']) && isset($_POST['datum']) && isset($_POST['uitgever']) && isset($_POST['schrijver']) && isset($_POST['description'])) {
  $titel = $_POST['titel'];
  $cat = $_POST['cat'];
  $datum = $_POST['datum'];
  $uitgever = $_POST['uitgever'];
  $schrijver = $_POST['schrijver'];
  $description = $_POST['description'];
  $uitgeleend = isset($_POST['uitgeleend']) ? 1 : 0;

  // Handle uploaded image
  $target_dir = "uploads/";
  $target_file = $target_dir . basename($_FILES['image']['name']);
  $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
  $extensions_arr = array("jpg", "jpeg", "png", "gif");

  if (in_array($imageFileType, $extensions_arr)) {
    move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
  }

  // Insert book information into the database using prepared statement
  $sql = "INSERT INTO boeken (titel, categorie, datum, uitgever, schrijver, description, uitgeleend, image) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
  $stmt = mysqli_stmt_init($conn);

  if (mysqli_stmt_prepare($stmt, $sql)) {
    mysqli_stmt_bind_param($stmt, "ssssssis", $titel, $cat, $datum, $uitgever, $schrijver, $description, $uitgeleend, $target_file);

    if (mysqli_stmt_execute($stmt)) {
      // Redirect to read.php after successful insertion
      header("Location: ../view/read.php");
      exit();
    } else {
      echo "ERROR: Could not execute $sql. " . mysqli_error($conn);
    }
  } else {
    echo "ERROR: Could not prepare $sql. " . mysqli_error($conn);
  }

  mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>