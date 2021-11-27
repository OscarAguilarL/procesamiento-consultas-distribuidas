<?php

include_once './Connection.php';
include_once './getIpAddress.php';
include_once './getCountryCode.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json;charset=utf-8');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $conn = connection();
        $ip = getIpAddress();
        // $countryCode = getCountryCode('187.191.15.151'); // dev
        $countryCode = getCountryCode($ip); // production

        $sql = "SELECT * FROM [production].[products]";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $apiResponse = array(
            'ok' => true,
            'result' => $result,
        );
        echo json_encode($apiResponse, JSON_UNESCAPED_UNICODE);
        http_response_code(200);
        break;

    default:
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(array(
            'ok' => false,
            'result' => 'Method not allowed'
        ), JSON_UNESCAPED_UNICODE);
        http_response_code(405);
        break;
}
