@extends('layout.app')

@section('content')
    <div class="container">
        <div class="card col-md-4 p-2 mb-3">
            <h4>Mesa {{$table->number}}</h4>
            <p><strong>Total: </strong>R$ {{$total[$table->id]}}</p>
            <p><strong>Valor da cota: </strong>R$ {{$quota[$table->id]}}</p>
            <p><strong>Cotas pagas em dinheiro: </strong>{{$money_count[$table->id]}}</p>
            <p><strong>Cotas pagas em debito: </strong>{{$debit_count[$table->id]}}</p>
            <p><strong>Cotas pagas no crédito: </strong>{{$credit[$table->id]}}</p>
            <p><strong>Cotas pagas no pix: </strong>{{$pix_count[$table->id]}}</td>
            <p><strong>Hora do fechamento: </strong>
                @if ($table->closed_at)
                    {{dateTimeFormate($table->closed_at)}}
                @else
                    Mesa ainda aberta 
                @endif
            </p>

            @if (!$table->closed_at)
                <a class="btn btn-dark form-control" href="{{route('table.show',[$table->id])}}">Fechar</a>
            @endif
        </div>
        
        <table class="table">
            <thead>
                <tr> 
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Adicionado</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($table->products as $product)
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{dateTimeFormate($product->created_at)}}</td>
                </tr>
                @empty
                
                @endforelse
            </tbody>
        </table>
    </div>
   
@endsection