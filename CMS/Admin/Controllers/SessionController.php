<?php

class SessionController {

    public function __construct() {
        echo $_POST['userid'];
        echo $_POST['token'];
    }
    
}

new SessionController();