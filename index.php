<?php

include_once './Connection.php';
include_once './getIpAddress.php';
include_once './getCountryCode.php';

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json;charset=utf-8');

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $conn = new Connection();
        $ip = getIpAddress();
        // $countryCode = getCountryCode('187.191.15.151'); // dev
        $countryCode = getCountryCode($ip); // production
        $citys = array();
        $countryName = '';

        $sql = "select ci.District, co.Name from city as ci
                inner join country as co on co.Code = ci.CountryCode
                where co.Code2 like '$countryCode' group by ci.District order by ci.District;";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $countryName = $result[0]['Name'];

        foreach ($result as $city) {
            if ($countryCode == 'SG') {
                array_push($citys, $city['District']);
            } else {
                array_push($citys, utf8_decode($city['District']));
            }
        }

        $apiResponse = array(
            'ok' => true,
            'result' => array(
                'country_code' => $countryCode,
                'country_name' => $countryName,
                'citys' => $citys,
            ),
        );
        echo json_encode($apiResponse, JSON_UNESCAPED_UNICODE);
        http_response_code(200);
        break;

    default:
        header('HTTP/1.1 405 Method Not Allowed');
        echo json_encode(array(
            'ok' => false,
            'result' => array(
                'message' => 'Method not allowed'
            )
        ), JSON_UNESCAPED_UNICODE);
        http_response_code(405);
        break;
}
