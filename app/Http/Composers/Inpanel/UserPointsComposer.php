<?php
/**
 * Created by PhpStorm.
 * User: SampleJunction
 * Date: 05-04-2019
 * Time: 05:51 PM
 */

namespace App\Http\Composers\Inpanel;

use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\View\View;
use App\Models\Setting\Setting;

class UserPointsComposer
{
    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * SidebarComposer constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @param View $view
     *
     * @return bool|mixed
     */
    public function compose(View $view)
    {
        //$threshold_value = config('app.points.metric.threshold_points');
        $getThresholdValue = setting::where('key','=','PANEL_REDEEMPTIOM_THRESHOLD_POINTS')->first();
        $threshold_value = $getThresholdValue->value;
        $view->with('global_user_points', $this->userRepository->getUserPoints(auth()->user()))
            ->with('threshold_point',$threshold_value);
    }
}
