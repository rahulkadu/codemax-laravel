<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

use Auth;
use Dingo\Api\Routing\Helpers;
use Hash;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use JWTAuth;
use Validator;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'quantity' => 'required|numeric',
            'amount' => 'required',
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {

            $errors = implode(' ', $validator->errors()->all());
            return response()->json(['message' => $errors], 401);
        }

        $file = $request->file('image');
        $extension = $file->getClientOriginalExtension();

        $filename = md5(Date("YmdHis") . '_' . rand(9, 999));
        $targetFile = 'public/' . $filename . '.' . $extension;
        $file_upload = Storage::disk('local')->put($targetFile, file_get_contents($file->getRealPath()));
        // die;
        
        $url = Storage::disk('local')->url($targetFile);
        // $asd = asset($url);
        // dd($asd);

        $product = new Product();
        $product->name = $request->get('name');
        $product->description = $request->get('description');
        $product->quantity = $request->get('quantity');
        $product->amount = $request->get('amount');
        $product->image_url = $url;
        $product->save();

        return response()->json(['success' => 1]);
    }

    public function listProduct(Request $request)
    {
        $product = Product::get();

        foreach ($product as $key => $value) {

            $product[$key]->url = asset($value->image_url);
        }

        return response()->json(['products' => $product]);
    }
}
