<?php
include "db_conn.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM boeken WHERE boek_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crud</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1>Update</h1>
        <form action="../model/updatemodel.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $row['boek_id']; ?>">
            <div>
                <label for="titel">Titel Boek:</label>
                <input type="text" name="titel" class="form-control" id="titel" placeholder="vul in de titel"
                    value="<?= $row['titel'] ?>">
            </div>
            <div>
                <label for="cat">Categorie:</label>
                <input type="text" name="cat" class="form-control" id="cat" placeholder="vul in de categorie"
                    value="<?= $row['categorie'] ?>">
            </div>
            <div>
                <label for="datum">Datum:</label>
                <input type="date" name="datum" class="form-control" id="datum" placeholder="vul in de datum"
                    value="<?= $row['datum'] ?>">
            </div>
            <div>
                <label for="uitgever">Uitgever:</label>
                <input type="text" name="uitgever" class="form-control" id="uitgever" placeholder="vul in de uitgever"
                    value="<?= $row['uitgever'] ?>">
            </div>
            <div>
                <label for="schrijver">Schrijver:</label>
                <input type="text" name="schrijver" class="form-control" id="schrijver"
                    placeholder="vul in de schrijver" value="<?= $row['schrijver'] ?>">
            </div>
            <div>
                <div>
                    <label for="uitgeleend">Uitgeleend:</label>
                    <input type="checkbox" name="uitgeleend" id="uitgeleend"
                        <?php if ($row['uitgeleend'] == 1) echo 'checked'; ?>>
                </div>
                <div>
                    <label for="description">Beschrijving:</label>
                    <input name="description" class="form-control" id="description"
                        placeholder="vul in de beschrijving" value="<?= $row['description'] ?>">
                </div>
                <div>
                    <label for="image">Afbeelding:</label>
                    <input type="file" name="image" id="image" value="<?php echo $row['image'] ?>">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="read.php">Cancel</a>
        </form>
    </div>
</body>

</html>