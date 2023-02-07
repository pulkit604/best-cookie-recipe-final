<?php

namespace App\Http\Controllers;

use App\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getHighScore(Request $request)
    {
        $requestBody = json_decode($request->getContent(), true);
        return response()->json(Score::getTotalScore($requestBody['Ingredients'], $requestBody['calorieCheck'] ?? null));
    }
}
