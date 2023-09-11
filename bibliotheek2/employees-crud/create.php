<?php
// Include config file
require_once "../crud-php/db_conn.php";
 
// Define variables and initialize with empty values
$name = $last_name = $address = $number = $email = $role = "";
$name_err = $last_name_err = $address_err = $number_err = $email_err = $role_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    
    // Validate name
    $input_name = trim($_POST["name"]);
    if(empty($input_name)){
        $name_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Please enter a valid name.";
    } else{
        $name = $input_name;
    }

    // Validate last name
    $input_last_name = trim($_POST["last_name"]);
    if(empty($input_last_name)){
        $last_name_err = "Please enter a last name.";
    } elseif(!filter_var($input_last_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $last_name_err = "Please enter a valid last name.";
    } else{
        $last_name = $input_last_name;
    }
    
    // Validate address
    $input_address = trim($_POST["address"]);
    if(empty($input_address)){
        $address_err = "Please enter an address.";     
    } else{
        $address = $input_address;
    }
    
    // Validate number
    $input_number = trim($_POST["number"]);
    if(empty($input_number)){
        $number_err = "Please enter your number.";
    } elseif(!ctype_digit($input_number)){
        $number_err = "Please enter a correct number.";
    } else{
        $number = $input_number;
    }

    // Validate email
    $input_email = trim($_POST["email"]);
    if(empty($input_email)){
        $email_err = "Please enter an email.";
    } else{
        $email = $input_email;
    }

    // Validate role
    $input_role = trim($_POST["role"]);
    if(empty($input_role)){
        $role_err = "Please select a role.";     
    } else{
        $role = $input_role;
    }
    
    // Check input errors before inserting in database
    if(empty($name_err) && empty($last_name_err) && empty($address_err) && empty($number_err) && empty($email_err) && empty($role_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO accounts (first_name, last_name, address, phone_number, email, role) VALUES (?, ?, ?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssssss", $param_name, $param_last_name, $param_address, $param_number, $param_email, $param_role);
            
            // Set parameters
            $param_name = $name;
            $param_last_name = $last_name;
            $param_address = $address;
            $param_number = $number;
            $param_email = $email;
            $param_role = $role;
            
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: index.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Please fill this form and submit to add employee record to the database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>first name</label>
                            <input type="text" name="name" class="form-control <?php echo (!empty($name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $name; ?>">
                            <span class="invalid-feedback"><?php echo $name_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Last name</label>
                            <input type="text" name="last name" class="form-control <?php echo (!empty($last_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $last_name; ?>">
                            <span class="invalid-feedback"><?php echo $last_name_err;?></span>

                        <div class="form-group">
                            <label>Address</label>
                            <textarea name="address" class="form-control <?php echo (!empty($address_err)) ? 'is-invalid' : ''; ?>"><?php echo $address; ?></textarea>
                            <span class="invalid-feedback"><?php echo $address_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>phone number</label>
                            <textarea name="number" class="form-control <?php echo (!empty($number_err)) ? 'is-invalid' : ''; ?>"><?php echo $number; ?></textarea>
                            <span class="invalid-feedback"><?php echo $number_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Email</label>
                            <textarea name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"><?php echo $email; ?></textarea>
                            <span class="invalid-feedback"><?php echo $email_err;?></span>
                        </div>

                        <div class="form-group">
                            <label>Role</label>
                            <form method="POST">
                                <select name="role" id="hoi">
                                <option value="Lezer">Lezer</option>
                                <option value="Medewerker">Medewerker</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </form>
                        <?php
                        if (isset($_POST['role'])) {
                            $role = $_POST['role'];

                            $query = "INSERT INTO accounts (role) VALUES ('$role')";
                            $result = mysqli_query($con, $query);
                            if ($result) {
                                echo 'Data inserted successfully.';
                            } else {
                                echo 'Error inserting data: ' . mysqli_error($con);
                            }
                        }
                        ?>
                            <span class="invalid-feedback"><?php echo $role_err;?></span>
                        </div>
                        
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="home.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>