<?php
include "db_conn.php";

if(isset($_GET["id"])){
  $id = $_GET["id"];
  /**
 * This is a sample class.
 */
class SampleClass {
  /**
   * This is a sample method.
   *
   * @param int $param1 Description of the first parameter.
   * @param string $param2 Description of the second parameter.
   * @return bool Description of the return value.
   * @throws CustomException If something goes wrong.
   */
  public function sampleMethod($param1, $param2) {
      // Method code here.
  }
}

  // check if user confirmed deletion
  if(isset($_GET["confirm"]) && $_GET["confirm"] == "yes") {
    $sql = "DELETE FROM boeken WHERE boek_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    $result = mysqli_stmt_execute($stmt);
    if($result) {
      header("location: view/read.php?message=Deleted");
    } else {
      echo "Error:".mysqli_error($conn);
    }
  } else {
    // display confirmation message
    echo "Are you sure you want to delete this record?<br>";
    echo "<a href='delete.php?id=$id&confirm=yes'>Yes</a> | ";
    echo "<a href='view/read.php'>No</a>";
  }
}
?>