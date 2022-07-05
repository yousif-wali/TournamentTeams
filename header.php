<header>
        <div>Future Div Teams</div>
        <nav>
            <ul>
            <li data-link="index.php">Home</li>
                <?php
                if(isset($_SESSION['member'])){
                    echo '<li><form action="validateForm.php" method="post"><button name="logout" style="border:none;">Log out</button></form></li>';
                }else{
                    echo '<li onclick="window.location.href=`login.php`">Login</li>';
                }
                ?>
            </ul>
        </nav>
    </header>