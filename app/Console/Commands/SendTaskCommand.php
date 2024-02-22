<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

class SendTaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-task-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle() // php artisan app:send-task-command
    {
        $tasks = Task::all();
        $clients = Client::all();
        $currentTime = Carbon::now();

        foreach ($tasks as $task) {
            $taskTime = Carbon::parse($task->time);

            if ($taskTime->isSameMinute($currentTime)) {
                $phoneNumbersString = "";

                foreach ($clients as $client) {
                    $clientsBirthday = Carbon::parse($client->birthday);
                    $futureDate = $currentTime->copy()->addDays(7);
                    $clientsBirthday->year = $futureDate->year;

                    if ($currentTime->diffInDays($clientsBirthday) < 7) {
                        $phoneNumbersString = $phoneNumbersString . "," . $client->phone;
                        if ($phoneNumbersString[0] === ',') {
                            $phoneNumbersString = substr($phoneNumbersString, 1);
                        }
                    }
                }

                $response = Http::get('https://smsc.ru/sys/send.php', [
                    'login' => env('SMSC_API_LOGIN'),
                    'psw' => env('SMSC_API_PASSWORD'),
                    'phones' => $phoneNumbersString,
                    'mes' => $task->message,
                ]);

                if ($response->successful()) {
                    $responseData = $response->body();
                    echo "Request was successful. Response: $responseData";
                } else {
                    $errorCode = $response->status();
                    $errorMessage = $response->body();
                    echo "Request failed with status code $errorCode. Error message: $errorMessage";
                }
            }
        };
    }
}
