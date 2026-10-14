<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UnitConversionController extends Controller
{
    public function index()
    {
        return view('simulators.units');
    }

    public function convert(Request $request)
    {
        $magnitude = $request->input('magnitude');
        $value = (float)$request->input('value');
        $from = $request->input('from_unit');
        $to = $request->input('to_unit');

        // Conversión especial para Temperatura
        if ($magnitude === 'temperatura') {
            $result = $this->convertTemperature($value, $from, $to);
            $procedure = "Conversión de temperatura de {$value} {$from} a {$to}: Resultado = {$result} {$to}";
            return response()->json(['result' => round($result, 2), 'procedure' => $procedure]);
        }

        // Factores exactos del Manual ITCA 2026 respecto a la unidad base del SI
        $factors = [
            'longitud' => [
                'm' => 1, 'cm' => 0.01, 'mm' => 0.001, 'um' => 1e-6, 'nm' => 1e-9,
                'km' => 1000, 'mi' => 1609.34, 'ft' => 0.3048, 'in' => 0.0254,
                'yd' => 0.9144, 'milla_nautica' => 1853.18, 'ano_luz' => 9.461e15
            ],
            'area' => [
                'm2' => 1, 'cm2' => 0.0001, 'in2' => 0.00064516, 'ft2' => 0.092903,
                'acre' => 4046.86, 'mi2' => 2590000
            ],
            'volumen' => [
                'm3' => 1, 'lt' => 0.001, 'cm3' => 1e-6, 'ft3' => 0.0283168,
                'gal' => 0.003788, 'oz' => 2.95735e-5, 'ml' => 1e-6
            ],
            'tiempo' => [
                's' => 1, 'min' => 60, 'h' => 3600, 'd' => 86400, 'ano' => 31556926
            ],
            'angulo' => [
                'rad' => 1, 'deg' => 0.0174533, 'rev' => 6.28318
            ],
            'velocidad' => [
                'm_s' => 1, 'ft_s' => 0.3048, 'km_h' => 0.277778, 'mi_h' => 0.44704, 'mi_min' => 26.8224
            ],
            'aceleracion' => [
                'm_s2' => 1, 'cm_s2' => 0.01, 'ft_s2' => 0.3048
            ],
            'masa' => [
                'kg' => 1, 'g' => 0.001, 'mg' => 1e-6, 'lb' => 0.453592, 'slug' => 14.5939
            ],
            'fuerza' => [
                'N' => 1, 'lb' => 4.44822, 'dyn' => 0.00001
            ],
            'presion' => [
                'Pa' => 1, 'psi' => 6894.76, 'lb_ft2' => 47.8803, 'atm' => 101325, 'mmHg' => 133.322
            ],
            'energia' => [
                'J' => 1, 'cal' => 4.186, 'Btu' => 1055, 'kWh' => 3.6e6
            ],
            'potencia' => [
                'W' => 1, 'hp' => 746, 'Btu_h' => 0.293071
            ]
        ];

        if (!isset($factors[$magnitude][$from]) || !isset($factors[$magnitude][$to])) {
            return response()->json(['result' => 'N/A', 'procedure' => 'Unidad no soportada']);
        }

        $baseValue = $value * $factors[$magnitude][$from];
        $result = $baseValue / $factors[$magnitude][$to];

        $procedure = "{$value} {$from} × (Factor: {$factors[$magnitude][$from]} / {$factors[$magnitude][$to]}) = " . sprintf("%.6g", $result) . " {$to}";

        return response()->json([
            'result' => sprintf("%.6g", $result),
            'procedure' => $procedure
        ]);
    }

    private function convertTemperature($val, $from, $to)
    {
        // Convertir primero a Celsius
        $c = $val;
        if ($from === 'F') $c = ($val - 32) * 5/9;
        if ($from === 'K') $c = $val - 273.15;

        // De Celsius a destino
        if ($to === 'C') return $c;
        if ($to === 'F') return ($c * 9/5) + 32;
        if ($to === 'K') return $c + 273.15;

        return $val;
    }
}