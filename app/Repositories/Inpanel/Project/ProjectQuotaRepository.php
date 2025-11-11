<?php

namespace App\Repositories\Inpanel\Project;

use App\Models\Project\Project;
use App\Models\Project\ProjectQuota;


/**
 * This repository class is used for adding, updating the Project Quotas.
 *
 * Class ProjectQuotaRepository
 * @author Pankaj Jha
 * @author Akash Sharma
 * @access public
 * @package App\Repositories\Inpanel\Project\ProjectQuotaRepository
 */
class ProjectQuotaRepository
{

    /**
     * This action is used for adding new Project Quota for the particular project.
     *
     * @param $project_id
     * @param $quotaArray
     * @return mixed
     */
    public function addProjectQuota($project_id, $quotaArray)
    {
        $projectQuotaItem = [
            'project_id' => $project_id,
            'name' => $quotaArray['Name'],
            'apace_quota_id' => $quotaArray['apace_quota_id'],
            'description' => $quotaArray['Name'],
            'formatted_quota_spec' => json_encode($quotaArray['Conditions']),
        ];
        $quota = ProjectQuota::create($projectQuotaItem);
        return $quota;
    }

    /**
     * This action is used for getting the project quotas by their project ids.
     *
     * @param $project_id
     * @param $quotaName
     * @return mixed
     */
    public function getProjectQuota($project_id, $quotaId)
    {
        $quota = ProjectQuota::where('project_id', '=', $project_id)
            ->where('id', '=', $quotaId)
            ->first();

        return $quota;
    }

    /**
     * This action is used for updating the Project Quota.
     *
     * @param ProjectQuota $quota
     * @param $quotaArray
     * @return ProjectQuota|bool
     */
    public function updateProjectQuota(ProjectQuota $quota, $quotaArray)
    {
        $projectQuotaItem = [
            'name' => $quotaArray['Name'],
            'description' => $quotaArray['Name'],
            'formatted_quota_spec' => json_encode($quotaArray['Conditions']),
        ];

        if (isset($quotaArray['status'])) {
            $projectQuotaItem['status'] = $quotaArray['status'];
        }

        if (isset($quotaArray['CPI'])) {
            $projectQuotaItem['cpi'] = $quotaArray['CPI'];
        }
        if (isset($quotaArray['Count'])) {
            $projectQuotaItem['count'] = $quotaArray['Count'];
        }
        $status = $quota->update($projectQuotaItem);
        return ($status)?$quota:$status;
    }
}
