<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Models\Table;
use Carbon\Carbon;
use Throwable;

class TableController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(){

        
        $products = Product::get();

        $tables = Table::limit(5)
        ->whereNull('closed_at')
        ->with('products')
        ->get();    
        
        $tables = collect($tables->toArray());
        
        $subtotal = [];
        
        foreach($tables as $table){

            $products_of_table = collect($table['products']);
            
            $subtotal[$table['id']] = $products_of_table->sum('price');
            
        }
            
        return view('table.index', [ 
            'tables' => $tables,
            'products' => $products,
            'subtotal' => $subtotal
        ]);
        
    }
        
    public function store($table_number, Request $request){
        
        $opened_table = 
            Table::whereNull('closed_at')
            ->where('number', '=', $table_number)
            ->get();

        if($opened_table->count() > 0){
            
            $request->session()->flash('error', 'A mesa já está aberta.');
            
            return redirect()
            ->route('table.index');
        }
        
        try{

            DB::beginTransaction();
            
            $table = Table::create([
                'number' => $table_number
            ]);

            DB::commit();
            
            $request->session()->flash('success', 'Mesa aberta com sucesso.');            
            
            return redirect()
                ->route('table.index');
        
        }catch(Throwable $th){

            dd($th);

            DB::rollBack();

            $request->session()->flash('error', 'Erro ao abrir a mesa.');

            return redirect()
                ->route('table.index');

        }
    }

    public function show($table_id, Request $request){

        try{
            
            $table = Table::findOrFail($table_id);

            $total = $table->products()
                ->sum('price');

            return view('table.show', [ 
                'table' => $table,
                'total' => $total
            ]);            
        
        }catch(Throwable $th){

            $request->session()->flash('error', 'Erro ao ao consultar mesas.');

            return redirect()
                ->route('table.index');

        }

    }

    public function close($table_id, Request $request){

        try{

            DB::beginTransaction();
            
            $methods = collect($request->except(['_token', '_method']));
            
            $methods = $methods->filter(function($value, $key){
                
                return $value != 0;
            });
            
            $total_peoples = $methods->count();        
            
            $table = Table::findOrFail($table_id);
            
            $total = $table->products()
                ->sum('price');

            $quota = $total / $total_peoples;

            foreach($methods as $method){

                

                $table->payments()->create([
                    'method' => $method,
                    'quota' => $quota
                ]);
            }

            $now = Carbon::now()
                ->toDateTimeString();

            $table->update([
                'closed_at' => $now
            ]);

            DB::commit();

            $request->session()->flash('success', 'Mesa fechada com sucesso.');

            return redirect()
                ->route('table.index');

        }catch(Throwable $th){

            DB::rollback();

            $request->session()->flash('error', 'Erro ao fechar a mesa.');

            return redirect()
                ->route('table.index');

        }
    }

    public function addProduct($table_id, $product_id, Request $request){

        try{

            DB::beginTransaction();

            $table = Table::findOrFail($table_id);
            $table->products()->attach($product_id);

            DB::commit();

            $request->session()->flash('success', 'Pedido feito com sucesso.');

            return redirect()
                ->route('table.index');

        }catch(Throwable $th){

            DB::rollback();

            $request->session()->flash('error', 'Erro ao fazer o pedido.');

            return redirect()
                ->route('table.index');

        }
    }
}
