<nav class="header">
    <ul>
        <li><a href="/"><img src="/media/logo.png" alt="Gishamer Logo"></a></li>
        <li><a href="/">Home</a></li>
        <?php 
            if(isset($_SESSION['USER'])){
            ?>
                <li><a href="/admin/">Admin</a></li>
                <li><a href="/admin/logout.php">Logout</a></li>
            <?php }else{ ?>
                <li><a href="/admin/login.php">Login</a></li>
            <?php 
            }
        ?>
    </ul>
</nav>
