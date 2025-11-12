<?php

namespace App\Console\Commands;

use App\Models\Project\Project;
use App\Models\Project\UserProject;
use Auth;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ProjectCCR extends Command
{
    use ApaceMethods;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'hourly:project_ccr';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Hourly Project CCR';

    public $url, $project_code, $apiKey;
    public  $time_zone;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->url = config('settings.APACE.API_URL');
        $this->apiKey = config('settings.APACE.API_KEY');
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $actionUrl = "{{url}}/api/project/show";
        $expectedStatusCode = 200;
        /*$user_projects = UserProject::with('project')->get();*/
        $projects = Project::all();
        $project_code = $projects->map(function ($user) {
            return collect($user->toArray())
                ->only(['apace_project_code'])
                ->all();
        })->toArray();
        $codes = array_column($project_code, 'apace_project_code');
        $callApiData = [
            'action_url' => $actionUrl,
            'expected_status_code' => $expectedStatusCode,
            'post_data' => [
                'code' => $codes
            ],
        ];
        $response = $this->callSJPanelAPI($callApiData);
        if($response){
            $max_value = count($response);
            foreach ($response as $index => $value){
                $project = Project::where('apace_project_code', '=', $value->project_code)
                    ->first();
                $user_project = UserProject::where('project_id', '=', $project->id)->first();
                if($user_project){
                    $user_project->order = $max_value;
                    $user_project->save();
                    $max_value-- ;
                }
                $project->ccr = $value->ccr;
                $project->save();
            }
            Log::alert('SJPanel CCR Check Successful');
        } else {
            Log::alert('SJPanel CCR Check Unsuccessful');
        }
        die();
    }
    public function callSJPanelAPI($apiData)
    {
        $actionUrl = $apiData['action_url'];
        $statusCode = $apiData['expected_status_code'];
        $postData = $apiData['post_data'];
        $finalUrl = $this->applyUrlChange($actionUrl);
        $requestArray = $this->getApiHeaders();
        $requestArray['json'] = $postData;
        try{
            $client = new Client();
            $response = $client->post($finalUrl, $requestArray);
            $responseCode = $response->getStatusCode();
            if ($responseCode !== $statusCode) {
                return false;
            }
            $responseBody = $response->getBody();
            $responseContent = $responseBody->getContents();
            /* dd($response, $responseBody, json_decode($responseContent),$responseContent);*/
            return json_decode($responseContent);
        }catch(ServerException $e){
            dd('ServerException, error on checking project in Apace', $e);
        } catch (GuzzleException $e) {
            dd('GuzzleException', $e);
        }
    }
}
