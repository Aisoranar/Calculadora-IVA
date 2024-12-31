<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Calculation;
use Carbon\Carbon;

class CalculationController extends Controller
{
    public function priceWithoutIVA()
    {
        return view('calculators.form', [
            'title' => 'Hallar Precio Sin IVA (Precio + IVA)',
            'action' => route('calculators.calculate'),
            'type' => 'sin_iva_precio_mas_iva',
        ]);
    }

    public function priceWithoutIVAWithTax()
    {
        return view('calculators.form', [
            'title' => 'Hallar Precio Sin IVA (IVA)',
            'action' => route('calculators.calculate'),
            'type' => 'sin_iva_iva',
        ]);
    }

    public function priceWithIVA()
    {
        return view('calculators.form', [
            'title' => 'Hallar Precio Más IVA',
            'action' => route('calculators.calculate'),
            'type' => 'con_iva',
        ]);
    }

    public function calculate(Request $request)
    {
        $value = $request->input('value');
        $iva = $request->input('iva') / 100;
        $type = $request->input('type', 'sin_iva');
        
        $result = match ($type) {
            'sin_iva_precio_mas_iva' => $value / (1 + $iva),
            'sin_iva_iva' => $value / $iva,
            default => null,
        };
    
        // Para 'con_iva', hacer el cálculo fuera del match
        if ($type === 'con_iva') {
            // Calcular el IVA
            $ivaAmount = $value * $iva;
            // Sumar el valor original y el IVA
            $result = $value + $ivaAmount;
        }
    
        Calculation::create([
            'value' => $value,
            'iva' => $iva * 100,
            'result' => $result,
            'type' => $type,
        ]);
    
        return redirect()->route('dashboard')->with('success', "Resultado: $result");
    }

    public function dashboard()
    {
        // Obtén los cálculos ordenados por fecha en orden descendente
        $calculations = Calculation::orderBy('created_at', 'desc')->get();
    
        // Pasa los cálculos a la vista
        return view('dashboard', compact('calculations'));
    }

    public function destroy($id)
    {
        try {
            // Busca el cálculo por ID
            $calculation = Calculation::findOrFail($id);
            $calculation->delete();
    
            return response()->json(['success' => true], 200);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error al eliminar el cálculo.'], 500);
        }
    }
    
}
