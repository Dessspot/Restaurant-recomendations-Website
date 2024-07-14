<?php
    $connect = new PDO("pgsql:host=localhost; port=1234; dbname=course",
    username: 'Alikhan', password: 'Alikh001231550246'); 
    if (!$connect) {
        die('Error connect to DataBase');
    }
?>