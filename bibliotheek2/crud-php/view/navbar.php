<?php

include "db_conn.php";

$role = 'Admin'
?>

<!DOCTYPE html>
<html>
<body>
    
<div class="header">
        <h1 style="float: left;">FIRDA</h1>
<!-- de navbar in de header -->
    <div class="navbar">
    <!-- Links in the navbar -->
    <a href="index.php" <?php if ($activeTab === 'home') echo 'class="active"'; ?>>Home</a>
    <a href="read.php" <?php if ($activeTab === 'boeken') echo 'class="active"'; ?>>Boeken</a>

    <?php if ($role === 'Admin' || $role === 'Medewerker'): ?>
        <a href="admin-pannel.php" <?php if ($activeTab === 'admin') echo 'class="active"'; ?>>Admin Panel</a>
        <?php endif; ?>
    <?php if ($role === 'Admin' || $role === 'Medewerker' || $role === 'Lid'): ?>
        <a href="#" <?php if ($activeTab === 'reservaties') echo 'class="active"'; ?>>Reservaties</a>
        <a href="#" <?php if ($activeTab === 'logout') echo 'class="active"'; ?>>Log out</a>
        <?php endif; ?>
    <?php if ($role === ''): ?>
        <a href="#" <?php if ($activeTab === 'login') echo 'class="active"'; ?>>Log in</a>
        <?php endif; ?>
</div>

</div>
</body>
</html>