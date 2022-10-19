<?php

namespace App\Http\Controllers;

use App\Models\Demand;
use App\Models\Payment;
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

class ReportController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index(Request $request){

        $data = $request->except(['after']);

        $tables = Table::where($data);

        if($request->has('after')){
            $tables = $tables->where('closed_at', '>', $request->input('after'));
        }

        $tables= $tables->paginate(20);

        
        
        $total = $this->getTotal($tables);
        $total_payments = $this->getTotalPayments($tables);
        $quota = $this->getQuota($tables,$total,$total_payments); 
        $money_count = $this->getMoneyCount($tables);
        $debit_count = $this->getDebitCount($tables);
        $credit = $this->getCreditCount($tables);
        $pix_count =$this->getPixCount($tables);
        $daily = $this->getDaily($request);

        
        $start_of_day = Carbon::now()->startOfDay();
       
            
        return view('report.index', [ 
            'tables' => $tables,
            'total' => $total,
            'quota' => $quota,
            'money_count' => $money_count,
            'debit_count' => $debit_count, 
            'credit' => $credit, 
            'pix_count' => $pix_count,
            'daily' => $daily,
            'start_of_day' => $start_of_day,
        ]);
        
    }

    private function getTotal($tables){

        $total = [];

        foreach($tables as $table){

            $total[$table->id] = $table->products->sum('price');
        }

        return $total;
    }

    private function getTotalPayments($tables){

        $total = [];

        foreach($tables as $table){

            $total[$table->id] = $table->payments->count();
        }

        return $total;
    }

    private function getQuota($tables, $total,$payments_count){

        $quota = [];

        foreach($tables as $table){

            $quota[$table->id] = 0;

            if($payments_count[$table->id] != 0){

                $quota[$table->id] = $total[$table->id]/$payments_count[$table->id];
            }
        }

        return $quota;
    }

    private function getMoneyCount($tables){

        $total = [];

        foreach($tables as $table){

            $total[$table->id] = $table->payments
                ->where('method', 'money')
                ->count();
                
        }

        return $total;
    }

    private function getDebitCount($tables){

        $total = [];

        foreach($tables as $table){

            $total[$table->id] = $table->payments
                ->where('method', 'debit')
                ->count();
        }

        return $total;
    }

    private function getCreditCount($tables){

        $total = [];

        foreach($tables as $table){

            $total[$table->id] = $table->payments
                ->where('method', 'credit')
                ->count();
        }

        return $total;
    }

    private function getPixCount($tables){

        $total = [];

        foreach($tables as $table){

            $total[$table->id] = $table->payments
                ->where('method', 'pix')
                ->count();
        }

        return $total;
    }

    private function getDaily(Request $request){

        $daily = [];
    
        $start_hour = Carbon::now()->startOfDay();

        $daily['total_money'] = Payment::where('method', '=', 'money')
            ->where('created_at', '>', $start_hour )
            ->sum('quota');

        $daily['total_debit'] = Payment::where('method', '=', 'debit')
            ->where('created_at', '>', $start_hour )
            ->sum('quota');

        $daily['total_credit'] = Payment::where('method', '=', 'credit')
            ->where('created_at', '>', $start_hour )    
            ->sum('quota');

        $daily['total_pix'] = Payment::where('method', '=', 'pix')
            ->where('created_at', '>', $start_hour )
            ->sum('quota');

        return $daily;
    }

    public function show($table_id, Request $request){

        try{

            $table = Table::findOrFail($table_id);

            $products = $table->products()
                ->withPivot('cteated_at');
                
            
            $total = $this->getTotal([$table]);
            $total_payments = $this->getTotalPayments([$table]);
            $quota = $this->getQuota([$table],$total,$total_payments); 
            $money_count = $this->getMoneyCount([$table]);
            $debit_count = $this->getDebitCount([$table]);
            $credit = $this->getCreditCount([$table]);
            $pix_count =$this->getPixCount([$table]);
                
            return view('report.show', [ 
                'table' => $table,
                'total' => $total,
                'quota' => $quota,
                'money_count' => $money_count,
                'debit_count' => $debit_count, 
                'credit' => $credit, 
                'pix_count' => $pix_count,
            ]);

        }catch(Throwable $th){

            dd($th);

            $request->session()->flash('error', 'Erro ao consultar consumo.');

            return redirect()
                ->route('report.index');

        }
    }
}
