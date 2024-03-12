<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LinearController extends Controller
{
    public function view_linear(Request $request)
    {
        // dd($request->all());
        $dataset = Dataset::orderBy('id', 'ASC')->get();

        return view('view_linear', compact('dataset'));
    }

    public function view_linear_post(Request $request)
    {
        // dd($request->all());
        $dataset = DB::table('dataset')->insert([
            'x' => $request->x,
            'y' => $request->y,
        ]);

        // Dataset::truncate();
        return redirect()->back();
    }

    public function chart_view()
    {
        return view('chart');
    }
}
