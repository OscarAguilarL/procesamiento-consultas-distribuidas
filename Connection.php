<?php

header('Content-Type: application/json;charset=utf-8');


function connection()
{
    $port = 1433;
    $serverName = "tcp:sd-oal-02.database.windows.net,$port";
    $database = "BikeStores";
    $userName = "Student";
    $password = "Pa55w.rd";
    try {
        $conn = new PDO("sqlsrv:server = $serverName,$port; Database = $database", $userName, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo json_encode(array(
            'ok' => false,
            'message' => 'Connection to database failed'
        ), JSON_UNESCAPED_UNICODE);
        die();
    }
}
