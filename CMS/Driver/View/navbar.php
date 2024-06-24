<?php
require_once '../Services/NavbarServices.php';

$navbarServices = new NavbarServices();

$navbarResponse = $navbarServices->adminNavbar();

if ($navbarResponse && !empty($navbarResponse)) {
    ?>

    <link rel="stylesheet" href="../../../Common/Common file/user_navbar.css">


    <div class="mobile-nav">
        <div class='wrapper'>
            <div class='app'>
                <div class='nav'>
                    <div class='nav-bar'>
                        <div class='logo'>AstronuX</div>
                        <div class='nav-btn'>
                            <div class='btn-bar menu'></div>
                            <div class='btn-bar menu'></div>
                            <div class='btn-bar menu'></div>
                            <div class='btn-bar close'></div>
                            <div class='btn-bar close'></div>
                        </div>
                    </div>
                    <div class='nav-content' style="display: none;">
                        <ul class="nav-list" style="display: none; position: relative; z-index: 10;">
                            <?php
                            foreach ($navbarResponse as $navbarData) {
                                ?>
                                <li>
                                    <a href="<?=$navbarData['url']?>">
                                        <?=$navbarData['icon']?>
                                        <span class="nav-text"><?=$navbarData['label']?></span>
                                    </a>
                                </li>
                                <?php
                            }

                            ?>
                        </ul>

                        <div class='background'>
                            <div class='portion'></div>
                            <div class='portion'></div>
                            <div class='portion'></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../../../Common/Common file/navbar.js"></script>
    <script src="../../../Common/Common file/mobile_navbar.js"></script>

    <?php
} else {
    echo "fuck you";
}
?>