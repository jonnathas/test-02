@extends('layout.app')

@section('content')
    
    <div class="container">
        <table class="table">
            <thead>
                <tr> 
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{$product->name}}</td>
                        <td>{{$product->price}}</td>
                        <td><a href="{{route('product.edit',[$product->id])}}">Editar</a></td>
                    </tr>
                @empty
                    
                @endforelse
            </tbody>
        </table>
    </div>

@endsection