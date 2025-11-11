<?php

namespace App\Http\Controllers\Backend\Auth\Setting;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Setting\CountriesCurrencies;
use App\Models\Country;
use App\Repositories\Backend\Auth\CountriesCurrenciesRepository;
use App\Repositories\Inpanel\General\GeneralRepository;
use Illuminate\Validation\Rule;

class CountriesCurrenciesController extends Controller
{
    /**
     * @var CountriesCurrenciesRepository
     * @var GeneralRepository
     */
    protected $countriesCurrenciesRepository,$generalRepository;

    /**
     * CountriesCurrenciesController constructor.
     *
     * @param CountriesCurrenciesRepository $countriesCurrenciesRepository
     */
    public function __construct(CountriesCurrenciesRepository $countriesCurrenciesRepository, GeneralRepository $generalRepository)
    {
        $this->countriesCurrenciesRepository = $countriesCurrenciesRepository;
        $this->generalRepository = $generalRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $points = $this->countriesCurrenciesRepository->getCountriesPoints();
        return view("backend.auth.setting.countries-points.index")->with("points", $points);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$countries = $this->generalRepository->getActiveCountries();   
        $countries = Country::get();   
        return view('backend.auth.setting.countries-points.create')->with('countries',$countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'country' => 'required|string',
            'country_language' => 'required|string|unique:country_points,country_language',
            'currency' => 'required|string',
            'points' => 'required|numeric',
        ]);

        // Assuming `countriesCurrenciesRepository` is properly injected and the `create` method works as expected
        $this->countriesCurrenciesRepository->create([
            'country' => $validatedData['country'],
            'country_language' => $validatedData['country_language'],
            'currency' => $validatedData['currency'],
            'points' => $validatedData['points'],
        ]);

        // Redirect with success message
        return redirect()->route('admin.auth.setting.countries_points')
            ->with('flash_success', 'Country points added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $countryPoint = $this->countriesCurrenciesRepository->getDetail($id);
        return view("backend.auth.setting.countries-points.show")->with('countryPoint',$countryPoint);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $countryPoint = $this->countriesCurrenciesRepository->getDetail($id);
        //$countries = $this->generalRepository->getActiveCountries();
        $countries = Country::get();     
        return view("backend.auth.setting.countries-points.edit")->with('countryPoint',$countryPoint)->with('countries',$countries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
                   'country' => 'required|string',
                   //'country_language' => 'required|string|unique:country_points,country_language|',
                   'country_language' => 'required|string|unique:country_points,country_language,' . $id,
                   /* 'country_language' => [
                       'required',
                       'string',
                       'max:255',
                     //  Rule::unique('country_points')->ignore($id),
                   ], */
				   
                   'currency' => 'required|string',
                   'points' => 'required|numeric',
               ]);

        // Assuming `countriesCurrenciesRepository` is properly injected and the `create` method works as expected
        $this->countriesCurrenciesRepository->update([
            'country' => $validatedData['country'],
            'country_language' => $validatedData['country_language'],
            'currency' => $validatedData['currency'],
            'points' => $validatedData['points'],
        ],$id);

        // Redirect with success message
        return redirect()->route('admin.auth.setting.countries_points')
            ->with('flash_success', 'Country points updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->countriesCurrenciesRepository->deletePoint($id);
        return redirect()->route('admin.auth.setting.countries_points')->withFlashSuccess('Country point is deleted successfully.');   
    }
}
