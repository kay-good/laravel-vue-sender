<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;
use Inertia\Response;
use stdClass;

class StatsController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Stats/Index', []);
    }

    public function store(Request $request)
    {
        $response = Http::get('https://smsc.ru/sys/get.php', [
            'get_messages' => 1,
            'login' => env('SMSC_API_LOGIN'),
            'psw' => env('SMSC_API_PASSWORD'),
            'start' => $request->startTime,
            'end' => $request->endTime,
            'cnt' => "1000",
        ]);

        $responseData = mb_convert_encoding($response->body(), 'UTF-8', 'Windows-1251');
        $responseStringArray = explode("\n", $responseData);
        $responseFormatted = [];
        foreach ($responseStringArray as $responceString) {
            $arrayOfParameters = explode(", ", $responceString);
            $objectOfParameters = new stdClass();
            foreach ($arrayOfParameters as $pair) {
                list($key, $value) = explode(" = ", $pair);
                $objectOfParameters->$key = $value;
            }
            $responseFormatted[] = $objectOfParameters;
        }

        return inertia('Stats/Index', [
            'stats' => $responseFormatted,
        ]);
    }
}
