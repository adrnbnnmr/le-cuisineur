<?php
 function get_pdo_connection(): PDO {
    return new PDO('pgsql:host=db;port=5432;dbname=lecuisineur', 'cuisineur', 'cuisineur');
 }