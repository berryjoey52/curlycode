<?php

/**
 * Class: csci303sp20
 * User: $(USER)
 * Date: $(DATE)
 * Time: $(TIME)
 */

 $connString = "mysql:host=localhost;dbname=csci303sp20";
 $user = "csci303sp20";
 $pass = "csci303sp20";
 $pdo = new PDO ($connString, $user, $pass);
 $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 ?>