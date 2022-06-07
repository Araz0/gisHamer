<nav class="header">
    <ul>
        <li><a href="/"><img src="/media/logo.png" alt="Gishamer Logo"></a></li>
        <li><a href="/">Home</a></li>
        <?php 
            if(userIsLoggedIn()){
            ?>
                <li><a href="/admin/">Admin</a></li>
                <li><a href="/logout.php">Logout</a></li>
            <?php }else{ ?>
                <li><a href="/login.php">Login</a></li>
            <?php 
            }
        ?>
    </ul>
</nav>
