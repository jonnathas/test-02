<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

use Throwable;

class ProductController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){

        $products = Product::get();

        return view('product.index', [ 
            'products' => $products,
        ]);
    }

    public function edit($product_id, Request $request){

        try{

            $product = Product::findOrFail($product_id);

            return view('product.edit', [ 
                'product' => $product,
            ]);

        }catch(Throwable $th){

            $request->session()->flash('error', 'Erro ao consultar produto.');

            return redirect()
                ->route('product.index');

        }

    }

    public function update($product_id, Request $request){

        try{

            DB::beginTransaction();

            $data = $request->except(['_token', '_method']);

            $product = Product::findOrfail($product_id);

            $product->update($data);

            DB::commit();

            $request->session()->flash('success', 'Produto atualizado com sucesso.');

            return redirect()
                    ->route('product.index');

        }catch(Throwable $th){

            DB::rollback();

            $request->session()->flash('error', 'Erro ao atualizar produto.');

            return redirect()
                ->route('product.index');

        }

    }
}
