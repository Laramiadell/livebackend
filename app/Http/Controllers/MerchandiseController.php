<?php

namespace App\Http\Controllers;

use App\Models\Merchandise;
use Exception;
use Illuminate\Http\Request;

class MerchandiseController extends Controller
{
    public function show(Merchandise $merchandise) {
        return response()->json($merchandise,200);
    }

    public function search(Request $request) {
        $request->validate(['key'=>'string|required']);

        $merchandises = Merchandise::where('brand','like',"%$request->key%")
            ->orWhere('product','like',"%$request->key%")->get();

        return response()->json($merchandises, 200);
    }

    public function store(Request $request) {
        $request->validate([
            'brand' => 'string|required',
            'product' => 'string|required',
            'description' => 'string|required',
            'price' => 'numeric|required',
            'quantity' => 'numeric|required',
        ]);

        try {
            $merchandise = Merchandise::create([
                'brand' => $request->brand,
                'product' => $request->product,
                'description' => $request->description,
                'price' => $request->price,
                'quantity' => $request->quantity,
                'user_id' => auth()->user()->id
            ]);
            return response()->json($merchandise, 202);
        }catch(Exception $ex) {
            return response()->json([
                'message' => $ex->getMessage()
            ],500);
        }

    }

    public function update(Request $request, Merchandise $merchandise) {
        try {
            $merchandise->update($request->all());
            return response()->json($merchandise, 202);
        }catch(Exception $ex) {
            return response()->json(['message'=>$ex->getMessage()], 500);
        }
    }

    public function destroy(Merchandise $merchandise) {
        $merchandise->delete();
        return response()->json(['message'=>'Merchandise deleted.'],202);
    }

    public function index() {
        $merchandises = Merchandise::where('user_id', auth()->user()->id)->orderBy('quantity')->get();
        return response()->json($merchandises, 200);
    }
}