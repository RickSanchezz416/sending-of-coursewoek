<?php

require 'lib/rb.php';

R::setup( 'mysql:host=localhost;dbname=sendcoursworksite',
    'root', 'root' );

session_start();
