<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        $buildingSurvey = Survey::type('building')->where('created_at', '>=' ,Carbon::today())->count();
        $generalSurvey = Survey::type('general')->where('created_at', '>=' ,Carbon::today())->count();
        $safeSecuritySurvey = Survey::type('safeSecurity')->where('created_at', '>=' ,Carbon::today())->count();
        $surveyToday =  Survey::where('created_at', '>=' ,Carbon::today())->count();
        $totalSurvey = Survey::count();

        $data = [
            'buildingSurvey'        => $buildingSurvey,
            'generalSurvey'         => $generalSurvey,
            'safeSecuritySurvey'    => $safeSecuritySurvey,
            'surveyToday'           => $surveyToday,
            'totalSurvey'           => $totalSurvey,
        ];

        return view("dashboard.index")->with($data);
    }
}
