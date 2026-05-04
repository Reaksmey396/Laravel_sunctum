<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function getProduct(){
        $Product = Product::with('user')->get();

        return apiResponse($Product, 200, 'product is successfully!!');
    }

    public function getProductById($id) {
        $Product = Product::with('user')->findOrFail($id);

        return apiResponse($Product, 200, 'product is successfully!!');
    }

    public function addProduct(Request $req) {
        $Product = $req->validate([
            'pro_name' => 'required',
            'description' => 'nullable'
        ]);

        $Product['user_id'] = $req->user_id;

        if($req->hasFile('image')) {
            $file = $req->file('image');
            $fileName = time().'_'.$file->getClientOriginalName();
            $file->move('image/', $fileName);
            $Product['image'] = url('image/'.$fileName);
        }

        Product::create($Product);

        return apiResponse($Product, 201, 'Added product');
    }
}
