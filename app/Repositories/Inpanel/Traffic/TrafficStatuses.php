<?php
/**
 * Created by PhpStorm.
 * User: Sample Junction
 * Date: 4/17/2019
 * Time: 1:32 AM
 */

namespace App\Repositories\Inpanel\Traffic;


trait TrafficStatuses
{

    public function getStartedStatus()
    {
        return 0;
    }

    public function getCompleteStatus()
    {
        return 1;
    }

    public function getTerminateStatus()
    {
        return 2;
    }

    public function getQuotaFullStatus()
    {
        return 3;
    }
    public function getQualityTerminateStatus()
    {
        return 4;
    }

    public function getSurveyAlreadyTakenStatus()
    {
        return [
            $this->getTerminateStatus(),
            14  //Already Taken Status
        ];
    }

    public function getSurveySpeedFailedStatus()
    {
        return [
            $this->getTerminateStatus(),
            15  //Already Taken Status
        ];
    }

    public function getSurveyQuotaFullStatus()
    {
        return [
            $this->getQuotaFullStatus(),
            7  //sjQuotaFull
        ];
    }

    public function getSurveyNotLiveStatus()
    {
        return [
            $this->getQuotaFullStatus(),
            12  //sjTerminate_Not_Live
        ];
    }


    public function getTrafficStatuses($status_id = null)
    {
        $data = [
            null => __('inpanel.survey.status.active'),
            '0' => __('inpanel.survey.status.start'),
            '1' => __('inpanel.survey.status.complete'),
            '2' => __('inpanel.survey.status.terminate'),
            '3' => __('inpanel.survey.status.quota_full'),
            '4' => __('inpanel.survey.status.quality_terminate'),
            '5' => __('inpanel.survey.status.rejected'),
        ];
        if (!empty($status_id)) {
            return $data[$status_id];
        }
        return $data;
    }

    public function getTrafficRespStatuses($respStatusId = null)
    {
        $data = [
            '1' => 'cComplete',
            '2' => 'cTerminate',
            '3' => 'cQuotaFull',
            '4' => 'cAbandon',
            '5' => 'sjAbandon',
            '6' => 'sjTerminate',
            '7' => 'sjQuotaFull',
            '8' => 'cTimeTerminate',
            '9' => 'urlConsumed',
            '10' => 'sjTerminate_Geo_IP',
            '11' => 'sjTerminate_SJID_MisMatch',
            '12' => 'sjTerminate_Not_Live',
            '13' => 'sjTerminate_Attempted',
            '14' => 'sjTerminate_Already_Taken',
            '15' => 'sjTerminate_LOI_Time_Fail',
            '16' => 'sjTerminate_Invalid_VendorVars',
            '17' => 'sjSurvey_DeDupe',
            '18' => 'cRejected',
            '19' => 'sjTerminate_DuplicateIP',
            '20' => 'sjTerminate_FakeURL',
            '21' => 'sjTerminate_ConsentDeclined',
            '22' => 'sjRejected_On_ConsentPage',
            '23' => 'sjTerminate_Cookie_Already_Taken',
            '24' => 'sjTerminate_Fraud_Fail_On_Hash_Check',
            '25' => 'sjTerminate_Fraud_Fail_On_Param_Check',
            '26' => 'sjTerminate_Fraud_Fail_On_Pixel_Check',
            '27' => 'sjTerminate_Fraud_Fail_On_S2S_Check',
        ];

        if (!empty($respStatusId)) {
            return $data[$respStatusId];
        }
        return $data;
    }
}
