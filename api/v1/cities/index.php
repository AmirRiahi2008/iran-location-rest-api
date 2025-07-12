<?php
include "../../../loader.php";
use App\Services\CityService;
use App\Utilities\Cache;
use App\Utilities\Response;
$token = getBearerToken();
if (!$token)
    Response::respondAndDie(['Invalid Token!'], Response::HTTP_UNAUTHORIZED);
$user = isValidToken($token);
if (!$user)
    Response::respondAndDie(['Invalid Token!'], Response::HTTP_UNAUTHORIZED);

$cityServiceModel = new CityService();
$requestBody = json_decode(file_get_contents("php://input"), true);
$requestMethod = $_SERVER["REQUEST_METHOD"];


switch ($requestMethod) {
    case 'GET':
        $provinceId = $_GET["province_id"] ?? null;
        $orderBy = $_GET["order_by"] ?? null;
        $fields = $_GET["fields"] ?? null;
        $page = $_GET["page"] ?? null;
        $pageSize = $_GET["page_size"] ?? null;
        if ((isset($provinceId) && !is_numeric($provinceId)) || (isset($page) && !is_numeric($page)))
            Response::respondAndDie(["Invalid Property"], Response::HTTP_NOT_ACCEPTABLE);
        if (!hasAccessToProvince($user, $provinceId))
            Response::respondAndDie(["You Don't Have Access To These Citites"]);
        Cache::start();
        $data = ["province_id" => $provinceId, "order_by" => $orderBy, "fields" => $fields, "page" => $page, "page_size" => $pageSize];
        $result = $cityServiceModel->getCities($data);
        if (!$result)
            Response::respondAndDie(["Error"], Response::HTTP_NOT_ACCEPTABLE);
        echo Response::respond($result);
        Cache::end();
        break;
    case "POST":
        $provinceId = $requestBody["province_id"] ?? null;
        $cityName = $requestBody["name"] ?? null;
        if ($provinceId === null || $cityName === null || !is_numeric($provinceId))
            Response::respondAndDie(["Invalid Property"], Response::HTTP_NOT_ACCEPTABLE);
        $data = ["name" => $cityName, "province_id" => $provinceId];
        $result = $cityServiceModel->addCity($data);
        if (!$result)
            Response::respondAndDie(["Invalid Property"], Response::HTTP_NOT_ACCEPTABLE);
        Response::respondAndDie($result, Response::HTTP_CREATED);
        break;
    case "DELETE":
        $cityId = $_GET["city_id"] ?? null;
        if ($cityId === null || !is_numeric($cityId))
            Response::respondAndDie(["Invalid City ID"], Response::HTTP_NOT_FOUND);
        $result = $cityServiceModel->deleteCity($cityId);
        if (!$result)
            Response::respondAndDie(["Erorr Deleting City"], Response::HTTP_NOT_ACCEPTABLE);
        Response::respondAndDie($result);
        break;
    case "PUT":
        $name = $requestBody["city_name"] ?? null;
        $cityId = $requestBody["city_id"] ?? null;
        if ($cityId === null || !is_numeric($cityId))
            Response::respondAndDie(["Invalid City ID"], Response::HTTP_NOT_FOUND);
        $result = $cityServiceModel->changeCityName($name, $cityId);
        if (!$result)
            Response::respondAndDie(["Error Changeing City Name Please Try Again Later"], Response::HTTP_NOT_ACCEPTABLE);
        Response::respondAndDie($result);
    default:
        Response::respondAndDie(["Invalid Method !!"], Response::HTTP_METHOD_NOT_ALLOWED);

}