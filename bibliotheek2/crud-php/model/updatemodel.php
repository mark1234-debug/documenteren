<?php
include "../db_conn.php";

// isset checkt of de form ge submit is en of het id aanwezig is
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    $titel = $_POST["titel"];
    $cat = $_POST["cat"];
    $datum = $_POST["datum"];
    $uitgever = $_POST["uitgever"];
    $schrijver = $_POST["schrijver"];
    $description = $_POST["description"];

    if (isset($_POST['uitgeleend'])) {
        $uitgeleend = 1;
    } else {
        $uitgeleend = 0;
    }

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image = $_FILES['image']['name']; 
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $extensions_arr = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $extensions_arr)) {
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }
    }

    // sql wilt de table boeken updaten 
    $sql = "UPDATE boeken SET titel=?, categorie=?, datum=?, uitgever=?, schrijver=?, description=?, uitgeleend=?, image=? WHERE boek_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssssssisi", $titel, $cat, $datum, $uitgever, $schrijver, $description, $uitgeleend, $image, $id);
    mysqli_stmt_execute($stmt); //ervoor zorgen dat sql injection proof is met special characters

    if (mysqli_stmt_affected_rows($stmt) > 0) {
        header("Location: ../view/read.php?message=update_success");
        exit();
    } else {
        header("Location: ../view/read.php?message=update_failed");
        exit();
    }
}
?>