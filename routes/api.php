<?php

use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\Project\ProjectController;
use App\Http\Controllers\Api\Cron\CronController;
use App\Http\Controllers\TestApiController;
use App\Http\Controllers\Api\mobileAPI\AuthController;
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/
Route::post('project/pull-invites', [ProjectController::class, 'pullInvitesBySpec'])->name('pullinvites.show');
Route::post('project/send-test-invite', [ProjectController::class, 'sendTestInvite'])->name('sendtestinvite.show');
Route::post('project/send-invite', [ProjectController::class, 'sendInvitePulledUser'])->name('sendinvite.pulled.user');
Route::post('project/send-invite-reminder', [ProjectController::class, 'sendInvitePulledUserReminder'])->name('sendinvite_reminder.pulled.user');
Route::post('project/update-reconcilation', [ProjectController::class, 'updateReconcilation'])->name('reconcilation.update');

/*********This url called from Cron**********/
Route::get('project/insert-survey-count', [ProjectController::class, 'insertSurveyStartCount'])->name('project.insertSurveyCount');
Route::get('project/update-response-rate', [ProjectController::class, 'updateResponseRate'])->name('project.insertResponseRate');
Route::get('cron/updateSurveyReport', [CronController::class, 'addUpadteSurveyReport'])->name('cron.surveyReport');

//Route::post('project/create', [ProjectController::class, 'createProject'])->name('project.create');

Route::group([
    'middleware' => 'auth:api',
], function (){

   
    Route::get('survey/survey-number/{survey_code}', [ProjectController::class, 'checkProject'])->name('project.check');
    Route::get('survey/surveyResponse', [ProjectController::class, 'surveyResponse'])->name('project.surveyResponse');
    Route::post('project/create', [ProjectController::class, 'createProject'])->name('project.create');
    Route::post('project/change-status/{survey_code}', [ProjectController::class, 'changeStatus'])->name('project.change.status');
    Route::post('project/update-project/{survey_code}', [ProjectController::class, 'updateProject'])->name('project.update');
    Route::post('project/add-quota/{survey_code}', [ProjectController::class, 'addQuota'])->name('quota.add');
    Route::post('project/update-quota/{survey_code}/{quota_id}', [ProjectController::class, 'updateQuota'])->name('quota.update');
    Route::post('project/quota-status-change/{survey_code}/{quota_name}', [ProjectController::class, 'changeQuotaStatus'])->name('quota.status.change');
});

Route::get('test-api-json',[TestApiController::class, 'testApiResponse']);

/* Mobiles API's Started*/
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::post('forgetPasswordOTP', [AuthController::class, 'forgetPasswordOTP']);
Route::post('verifyforgetOTP', [AuthController::class, 'verifyforgetOTP']);
Route::post('updatePassword', [AuthController::class, 'updatePassword']);

/* Mobiles API's End*/
