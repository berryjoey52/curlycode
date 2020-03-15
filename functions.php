<?php

/**
 * Class: csci303sp20
 * User: $(USER)
 * Date: $(DATE)
 * Time: $(TIME)
 */

 function checkDuplicates($pdo, $sql, $field)
 {
     $stmt = $pdo->prepare($sql);
     $stmt->bindValue(1, $field);
     $stmt->execute();
     $row = $stmt->fetch(PDO::FETCH_ASSOC);
     return $row;
 }

 ?>
