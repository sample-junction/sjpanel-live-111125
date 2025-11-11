<?php

namespace App\Http\Controllers\Inpanel\Project;

use App\Models\Project\UserProject;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\ServerException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    use ApaceMethods;
    public $url, $project_code, $apiKey;
    public function __construct()
    {
        $this->url = config('settings.APACE.API_URL');
        $this->apiKey = config('settings.APACE.API_KEY');
    }

    public function getCCR()
    {
        $actionUrl = "{{url}}/api/project/show/{{ProjectCode}}";
        $expectedStatusCode = 200;
        $user = auth()->user();
        $user_projects = UserProject::where('user_id', '=', $user->id)->with('project')->get();
        foreach($user_projects as $user_project){
            $apace_project_code = $user_project->project->apace_project_code;
            $project = $user_project->project;
            $this->project_code = $apace_project_code;
            $callApiData = [
                'action_url' => $actionUrl,
                'expected_status_code' => $expectedStatusCode,
                'post_data' => $apace_project_code,
            ];
            $response = $this->callSJPanelAPI($callApiData);
            if($response){
                $user_project->order = $response->ccr;
                $user_project->save();
                $project->ccr = $response->ccr;
                $project->save();
                Log::alert('SJPanel CCR Check User Project ID --> '.$user_project->id);
            }else{
                Log::alert('SJPanel CCR Check Unsuccessful User Project ID --> '.$user_project->id);
            }
        }
        dd("done");
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
            $response = $client->get($finalUrl, $requestArray);
            $responseCode = $response->getStatusCode();
            if ($responseCode !== $statusCode) {
                return false;
            }
            $responseBody = $response->getBody();
            $responseContent = $responseBody->getContents();
           /* dd($response, $responseBody, json_decode($responseContent),$responseContent);*/
            return json_decode($responseContent);
        }catch(ServerException $e){
            dd('ServerException, error on launching in FL', $e);
        } catch (GuzzleException $e) {
            dd('GuzzleException', $e);
        }
    }
}
