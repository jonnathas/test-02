@extends('layout.app')

@section('content')

    <div class="container">

        <div class="card col-md-4">
            <div class="card-header">
                <h4>Mesa {{$table->number}}</h4>
                <p><strong>Total: </strong>{{$total}}</p>
            </div>
            <form action="{{route('table.close',[$table->id])}}" method="POST">
                @csrf
                <input type="hidden" name="_method" value="DELETE"/>
                
                <select class="form-control mb-2" name="method_1">
                    <option value="0">Selecione o método de pagamento da pessoa 1</option>
                    <option value="money">Dinheiro</option>
                    <option value="debit">Débito</option>
                    <option value="credit">Crédito</option>
                    <option value="pix">Pix</option>
                </select>

                <select class="form-control mb-2" name="method_2">
                    <option value="0">Selecione o método de pagamento da pessoa 2</option>
                    <option value="money">Dinheiro</option>
                    <option value="debit">Débito</option>
                    <option value="credit">Crédito</option>
                    <option value="pix">Pix</option>
                </select>

                <select class="form-control mb-2" name="method_3">
                    <option value="0">Selecione o método de pagamento da pessoa 3</option>
                    <option value="money">Dinheiro</option>
                    <option value="debit">Débito</option>
                    <option value="credit">Crédito</option>
                    <option value="pix">Pix</option>
                </select>

                <select class="form-control mb-2" name="method_4">
                    <option value="0">Selecione o método de pagamento da pessoa 4</option>
                    <option value="money">Dinheiro</option>
                    <option value="debit">Débito</option>
                    <option value="credit">Crédito</option>
                    <option value="pix">Pix</option>
                </select>
                
                <input type="submit" value="Fechar" class="btn btn-warning form-control"/>
            </form>
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