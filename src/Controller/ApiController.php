<?php

namespace App\Controller;

use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class ApiController extends AbstractController
{
    private JWTTokenManagerInterface $JWTManager;
    public function __construct(JWTTokenManagerInterface $JWTManager)
    {
        $this->JWTManager = $JWTManager;
    }

    #[Route('api/stations/somalia-ethiopia/', name: 'stations-somalia-ethiopia')]
    public function somaliaEthiopia(): Response
    {
        $apiKey = "1ef1ea94158a22838989ec0dfdbd6b14101ff575e9f189499ab2a00a20611857480810b64e5d43526a5c9692e974a369a1f3bd63ec959b9f6cf7e9152572b103";
        $url = "localhost:9000/api/contract/stations";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "API-key: $apiKey"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return new JsonResponse($response, 200, [], true);
    }

    #[Route('api/stations/somalia-ethiopia/station/{id}', name: 'station-somalia-ethiopia')]
    public function somaliaEthiopiaStation(int $id): Response
    {
        $apiKey = "1ef1ea94158a22838989ec0dfdbd6b14101ff575e9f189499ab2a00a20611857480810b64e5d43526a5c9692e974a369a1f3bd63ec959b9f6cf7e9152572b103";
        $url = "localhost:9000/api/contract/station/$id/measurements";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "API-key: $apiKey"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return new JsonResponse($response, 200, [], true);
    }

    #[Route('api/stations/mogadishu-1500km/', name: 'stations-mogadishu')]
    public function mogadishu(): Response
    {
        $apiKey = "03bc5dea28605aa505733f5a5e271ba40982272a3db743d898dc1455e158e04496c98c0d9aaf7cc6782aabba0f804600e5449793988d09d7263800f92f70da04";
        $url = "localhost:9000/api/contract/stations";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "API-key: $apiKey"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return new JsonResponse($response, 200, [], true);
    }

    #[Route('api/stations/mogadishu-1500km/station/{id}', name: 'station-mogadishu')]
    public function mogadishuStation(int $id): Response
    {
        $apiKey = "03bc5dea28605aa505733f5a5e271ba40982272a3db743d898dc1455e158e04496c98c0d9aaf7cc6782aabba0f804600e5449793988d09d7263800f92f70da04";
        $url = "localhost:9000/api/contract/station/$id/measurements";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "API-key: $apiKey"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        return new JsonResponse($response, 200, [], true);
    }

    #[Route('api/top10/airpressure/{date}', name: 'airpressure-date')]
    public function top10Airpressure(string $date): Response
    {
        $apiKey = "1ef1ea94158a22838989ec0dfdbd6b14101ff575e9f189499ab2a00a20611857480810b64e5d43526a5c9692e974a369a1f3bd63ec959b9f6cf7e9152572b103";
        $url = "localhost:9000/api/contract/all/measurements";

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "API-key: $apiKey"
        ]);

        $response = curl_exec($curl);
        curl_close($curl);

        $data = json_decode($response, true);

        $filteredData = [];

        foreach ($data as $item) {
            $timestamp = $item['timestamp']['date'];
            if (strpos($timestamp, $date) === 0) {
                $filteredData[] = $item;
            }
        }

        usort($filteredData, function ($a, $b) {
            return $b['station_air_pressure'] <=> $a['station_air_pressure'];
        });

        $top10Data = array_slice($filteredData, 0, 10);

        $filteredJsonData = json_encode($top10Data, JSON_PRETTY_PRINT);
        return new JsonResponse($filteredJsonData, 200, [], true);
    }
}