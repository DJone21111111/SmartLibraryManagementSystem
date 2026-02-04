<?php
return [
  'dsn'  => 'mysql:host=mysql;port=3306;dbname=SmartLibraryManagementSystem;charset=utf8mb4',
  'user' => 'root',
  'pass' => 'secret123',
  'opts' => [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
  ]
];