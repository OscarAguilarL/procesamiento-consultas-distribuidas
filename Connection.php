<?php

class Connection extends PDO
{
    private string $host = '156.67.73.201';
    private string $dbName = 'u551768457_world';
    private string $user = 'u551768457_admin';
    private string $password = 'Admin12345.';

    public function __construct()
    {
        try {
            parent::__construct("mysql:host=$this->host;dbname=$this->dbName;charset=utf8", $this->user, $this->password);
            parent::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }
}
