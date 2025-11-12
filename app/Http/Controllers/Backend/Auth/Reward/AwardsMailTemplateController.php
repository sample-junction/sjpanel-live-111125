<?php

namespace App\Http\Controllers\Backend\Auth\Reward;

use App\Http\Controllers\Controller;
use App\Models\Reward\Award;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Services\RewardService;
use App\Models\Reward\AwardsMailTemplate;
use App\Models\Reward\AwardsMailHistory;
use App\Models\Setting\Setting;



/**
 * Class CountryInfoController.
 */
class AwardsMailTemplateController extends Controller
{
    /**
     * @var RewardService
     */
    protected $rewardService;

    /**
     * CountryInfoController constructor.
     *
     * @param RewardService $rewardService
     */
    public function __construct(RewardService $rewardService)
    {
        $this->rewardService = $rewardService;
    }

    public function index()
    {
        $testMode = $this->rewardService->getAwardTestSettings();
        // dd($testMode);
        
        $award_templates = AwardsMailTemplate::get();
        return view('backend.auth.reward.award_template.index')->with([
            'award_templates' => $award_templates,
            'test_mode_settings' => $testMode
        ]);
    }

    public function add()
    {
        return view('backend.auth.reward.award_template.add')->with([
            'demoData' => $this->rewardService->getAwardMailVariablesValue(true)
        ]);
    }

    public function postAdd(Request $request)
    {

        $this->validate($request, [
            'template_name' => 'required',
            'email_subject' => 'required',
            'template_content' => 'required',
        ]);

        $saveData = [
            'template_name' => $request->template_name,
            'template_content' => $request->template_content,
            'email_subject' => $request->email_subject,
            'created_by' => $request->user_id,
        ];

        AwardsMailTemplate::create($saveData);
        return redirect()->back()
            ->with('flash_success', 'New Award Template Created');
    }

    public function edit($id)
    {
        $award_templates = AwardsMailTemplate::whereId($id)->first();
        // dd($award_templates);
        return view('backend.auth.reward.award_template.edit')->with([
            'award_templates' => $award_templates,
            'demoData' => $this->rewardService->getAwardMailVariablesValue(true)
        ]);
    }


    public function postEdit(Request $request, $id)
    {
        $this->validate($request, [
            'template_name' => 'required',
            'email_subject' => 'required',
            'template_content' => 'required',
        ]);

        $saveData = [
            'template_name' => $request->template_name,
            'template_content' => $request->template_content,
            'email_subject' => $request->email_subject,
        ];


        AwardsMailTemplate::where('id', $id)->update($saveData);
        return redirect()->back()
            ->with('flash_success', 'New Award Template Updated');
    }

    public function delete($id)
    {
        try {
            AwardsMailTemplate::where('id', $id)->delete();
            return redirect()->back()
                ->with('flash_success', 'Award Template Deleted');
        } catch (\Exception $e) {
            // dd($e->getMessage());
        }

        return redirect()->back()
            ->with('flash_danger', 'Award Template Not Deleted');
    }

    public function templateHistoryList(Request $request)
    {
        $templates = AwardsMailTemplate::pluck('template_name', 'id')->toArray();
        return view('backend.auth.reward.award_template.history_list')->with([
            'templates' => $templates,
            'countries' => $this->rewardService->getAllCountriesInfo(),
        ]);
    }

    public function tempHistoryDTable(Request $request)
    {
        $query = AwardsMailHistory::query()
            ->leftJoin('awards_mail_template', 'awards_mail_template.id', '=', 'awards_mail_history.mail_template')
            ->select(
                'awards_mail_history.*',
                'awards_mail_template.template_name'
            );

        // Apply filters
        if ($request->search) {
            $search = $request->search['value'];
            // dd($search);
            $query->where(function ($q) use ($search) {
                $q->where('panellist_id', 'like', "%{$search}%")
                    ->orWhere('template_name', 'like', "%{$search}%");
            });
        }
        if ($request->templates_id) $query->where('mail_template', $request->templates_id);
        if ($request->country_code) $query->where('country_code', $request->country_code);
        if ($request->start_date) $query->where('awards_mail_history.created_at', '>=', $request->start_date);
        if ($request->end_date) $query->where('awards_mail_history.created_at', '<=', $request->end_date);

        $templates = AwardsMailTemplate::pluck('template_name', 'id')->toArray();

        // Check if export requested
        if ($request->has('export') && $request->export == 1) {
            $data = $query->orderBy('created_at', 'desc')->get();

            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=template_history.csv",
            ];
            $columns = ['Panellist Id', 'Template Name', 'Country Code', 'Created At'];

            $callback = function () use ($data, $columns, $templates) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns);
                foreach ($data as $row) {
                    fputcsv($file, [
                        $row->panellist_id,
                        isset($templates[$row->mail_template]) ? $templates[$row->mail_template] : '{Deleted}',
                        $row->country_code,
                        $row->created_at->format('Y-m-d H:i:s')
                    ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }

        // Otherwise, normal DataTable JSON response
        $totalData = $query->count();

        $start = $request->input('start');
        $length = $request->input('length');
        $orderColumn = $request->input('order.0.column', 3);
        $dir = $request->input('order.0.dir', 'desc');
        $columnsList = ['panellist_id', 'mail_template', 'id','country_code', 'created_at'];
        $order = $columnsList[$orderColumn];

        $data = $query->offset($start)
            ->limit($length)
            ->orderBy($order, $dir)
            ->get();

        $response = [];
        foreach ($data as $row) {
            $response[] = [
                'panellist_id' => $row->panellist_id,
                'country_code' => $row->country_code,
                'template_name' => isset($templates[$row->mail_template]) ? $templates[$row->mail_template] : '{Deleted}',
                'preview' => '<i class="fas fa-eye preview_eye" data-history_link="' .
                    route('admin.auth.reward.template_history.preview', $row->id) .
                    '" style="color: #17a2b8; cursor: pointer;"></i>',
                'created_at' => $row->created_at->format('Y-m-d H:i:s'),
            ];
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $totalData,
            'recordsFiltered' => $totalData,
            'data' => $response,
        ]);
    }


    public function historyPreviewHtml($id)
    {

        $historyData = AwardsMailHistory::leftJoin('awards_mail_template', 'awards_mail_history.mail_template', '=', 'awards_mail_template.id')
            ->where('awards_mail_history.id', $id)
            ->select('awards_mail_template.email_subject', 'awards_mail_template.template_content', 'awards_mail_history.mail_data')
            ->first();

        $subject = '';
        $content = '';


        if ($historyData && $historyData->mail_data) {

            $mail_data = json_decode($historyData->mail_data, true);

            if ($mail_data) {
                $subject = str_replace(array_keys($mail_data), array_values($mail_data), $historyData->email_subject);
                $content = str_replace(array_keys($mail_data), array_values($mail_data), $historyData->template_content);
            }
        }

        return response()->json(['subject' => $subject, 'content' => $content]);
    }

    /*public function manualRewardEmailForm(){

        $templates = AwardsMailTemplate::pluck('template_name', 'id')->toArray();
        return view('backend.auth.reward.award_template.send_mail')->with([
            'templates' => $templates,
            'award_type' => $this->rewardService->getActiveAwards(),
            'countries' => $this->rewardService->getAllCountriesInfo(),
        ]);
    }

    public function postManualRewardEmailForm(Request $request){
            //     return redirect()->back()
            // ->with('flash_success', 'New Award Template Created');
        dd($request->all());
    }*/

    public function testMode(Request $request){
        $test_mode = $request->test_mode;

        $settingsData = [
            'PANEL_AWARD_TEST_EMAIL_IDS' => trim($request->test_emails),
            'PANEL_AWARD_TEST_MODE' => ($test_mode)?$test_mode:0
        ];

        foreach ($settingsData as $key => $value) {
            Setting::updateOrCreate(
                ['key' => $key],           
                ['value' => $value]        
            );
        }

        return redirect()->back()
                ->with('flash_success', 'Settings updated successfully');
    }
}
