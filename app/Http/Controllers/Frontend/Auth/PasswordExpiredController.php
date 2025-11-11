<?php

namespace App\Http\Controllers\Frontend\Auth;
use App\Helpers\Auth\Auth;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Auth\UserRepository;
use App\Http\Requests\Frontend\User\UpdatePasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Repositories\Inpanel\General\GeneralRepository;


/**
 * Class PasswordExpiredController.
 */
class PasswordExpiredController extends Controller
{
    public function __construct(GeneralRepository $generalRepository) {
        $this->generalRepository = $generalRepository;
    }
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function expired(Request $request)
    {
        [$flags, $uuid, $DFIQ, $countryCode, $country, $countries] = $this->getFlags($request);
        abort_unless(config('access.users.password_expires_days'), 404);
        $expired = true;
        return view('frontend.auth.passwords.expired')
        ->with('uuid',$uuid)
                ->with('dfiq',$DFIQ)
                ->with('expired',$expired)
                ->withCountries($countries) 
                ->with('country_name',strtoupper($country))
                ->with('countryCode',$countryCode)
                ->with('flags',$flags);
    }

    /**
     * @param UpdatePasswordRequest $request
     * @param UserRepository        $userRepository
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     */
    public function update(UpdatePasswordRequest $request, UserRepository $userRepository)
    {
        abort_unless(config('access.users.password_expires_days'), 404);

       $result= $userRepository->updatePassword($request->only('old_password', 'password'), true);
        auth()->logout();
        return redirect()->route('frontend.auth.login')
            ->withFlashSuccess(__('strings.frontend.user.password_updated'));
    }
    private function getFlags(Request $request)
    {

        $uuid = Str::uuid()->toString();
        $ip = request()->ip();
        $DFIQ = config('settings.dfiq.status');
        $geodata = geoip(request()->ip());
        $countries = $this->generalRepository->getActiveCountries();
        $country = $geodata->getAttribute('country');
        $countryCode = $geodata->getAttribute('iso_code');

        if ($countryCode != 'US') {
            if (!empty($request->session()->get('locale'))) {
                $flags = str_replace('_', '-', strtoupper($request->session()->get('locale')));
            } else {
                app()->setLocale('EN-' . $countryCode);
                $flags = 'EN-' . $countryCode;
            }
        } else {
            $flags = str_replace('_', '-', strtoupper($request->session()->get('locale')));
        }

        return [$flags, $uuid, $DFIQ, $countryCode, $country, $countries];
    }
}
