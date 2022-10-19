@extends('layout.app')

@section('content')
    <div class="container">
        <form action="{{route('report.index')}}" class="d-flex justify-content-end">
            
            <label for="chackbox_daily" class="m-2"> Apenas do dia
                <input id="chackbox_daily" type="checkbox" value="{{$start_of_day}}" name="after">
            </label>
            <label for="table_1" class="m-2"> Mesa 1
                <input type="radio" name="number" id="table_1" value="1">
            </label>
            <label for="table_2" class="m-2"> Mesa 2
                <input type="radio" name="number" id="table_2" value="2">
            </label>
            <label for="table_3" class="m-2"> Mesa 3
                <input type="radio" name="number" id="table_3" value="3">
            </label>
            <label for="table_4" class="m-2"> Mesa 4
                <input type="radio" name="number" id="table_4" value="4">
            </label>
            <label for="table_5" class="m-2"> Mesa 5
                <input type="radio" name="number" id="table_5" value="5">
            </label>

            <input type="submit" value="Visualizar relatorio" class="btn btn-dark d-inline ms-2"/>
        </form>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th scope="col"></th>
                <th scope="col">Mesa</th>
                <th scope="col">Total</th>
                <th scope="col">Valor da cota</th>
                <th scope="col">Dinheiro</th>
                <th scope="col">Débito</th>
                <th scope="col">Crédito</th>
                <th scope="col">Pix</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($tables as $table)
                <tr>
                    <td></td>
                    <td>{{$table->number}}</td>
                    <td>R$ {{$total[$table->id]}}</td>
                    <td>R$ {{$quota[$table->id]}}</td>
                    <td>{{$money_count[$table->id]}}</td>
                    <td>{{$debit_count[$table->id]}}</td>
                    <td>{{$credit[$table->id]}}</td>
                    <td>{{$pix_count[$table->id]}}</td>
                    <td><a class="btn btn-dark" href="{{route('report.show',[$table->id])}}">Visualizar consumo</a></td>
                </tr>
            @empty

                <tr>
                   <td class="text-center" colspan="8">Nenhum resultado encontrado.</td> 
                </tr>
            
            @endforelse
        </tbody>

        {{ $tables->links()}}
    </table>

    <div class="border border-ligth rounded col-md-4 m-auto">
        <h4 class="text-center">Total recebido</h4>
        <span class="m-2 pb-2 pt-2"><strong>Dinheiro:</strong> R$ {{$daily['total_money']}} </span>
        <span class="m-2 pb-2 pt-2"><strong>Débito:</strong> R$ {{$daily['total_debit']}} </span>
        <span class="m-2 pb-2 pt-2"><strong>Crédito:</strong> R$ {{$daily['total_credit']}} </span>
        <span class="m-2 pb-2 pt-2"><strong>Pix:</strong> R$ {{$daily['total_pix']}} </span>
    </div>
@endsection