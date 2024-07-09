<?php

// log out the user

use Core\Authenticator;

$auth = new Authenticator();
$auth->logout();
redirect('/');
