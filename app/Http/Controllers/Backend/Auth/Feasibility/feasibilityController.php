<?php

namespace App\Http\Controllers\Backend\Auth\Feasibility;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class feasibilityController extends Controller
{
    public function index(){
        return view('backend.auth.feasibility.feasibility');
    }
}
