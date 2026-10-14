<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VectorController extends Controller
{
    public function index()
    {
        return view('simulators.vectors');
    }

    public function calculate(Request $request)
    {
        $vectors = $request->input('vectors', []);
        $sumFx = 0;
        $sumFy = 0;
        $steps = [];

        foreach ($vectors as $index => $v) {
            $mag = (float) $v['magnitude'];
            $deg = (float) $v['angle'];
            $rad = deg2rad($deg);

            $fx = $mag * cos($rad);
            $fy = $mag * sin($rad);

            $sumFx += $fx;
            $sumFy += $fy;

            $steps[] = [
                'name' => "V" . ($index + 1),
                'magnitude' => $mag,
                'angle' => $deg,
                'fx' => round($fx, 2),
                'fy' => round($fy, 2)
            ];
        }

        $resultant = sqrt(pow($sumFx, 2) + pow($sumFy, 2));
        $angleRad = atan2($sumFy, $sumFx);
        $angleDeg = rad2deg($angleRad);
        if ($angleDeg < 0) {
            $angleDeg += 360;
        }

        return response()->json([
            'steps' => $steps,
            'sumFx' => round($sumFx, 2),
            'sumFy' => round($sumFy, 2),
            'resultant' => round($resultant, 2),
            'angle' => round($angleDeg, 2)
        ]);
    }
}