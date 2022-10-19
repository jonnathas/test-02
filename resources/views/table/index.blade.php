@extends('layout.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between"> 
            @for ($i = 0; $i < 5; $i++)
            
            @php
                
                $table = $tables->where('number', $i+1);
                $table = $table->mapWithKeys(function($value, $key){
                    return [ 0 => $value ];
                });

                
                @endphp

<div class="card col-md-2 m-2">
    
    <h4 class="card-title text-center">Mesa {{$i + 1}}</h4>
    
    @if( count($table) > 0)
    
    @php 
        $table_id = $table[0]['id'];
    @endphp           
                    <p><strong>Subtotal: </strong>{{$subtotal[$table_id]}}</p>

                    @foreach ($products as $product)
                        <form action="{{ route('table.add-product',[$table_id, $product->id]) }}"  method="POST">
                            @csrf
                            <input type="submit" class="btn btn-success form-control mb-2 " value="{{$product->name}}"/>
                        </form>
                    @endforeach

                    <a href="{{ route('table.show',[$table_id]) }}" class="btn btn-warning form-control mb-2">Visualizar</a>
    
                @else
                    
                    <form action="{{ route('table.store',[$i + 1]) }}" method="POST">
                        @csrf
                        <button class="btn btn-warning form-control mb-2 mt-2">Abrir</button>
                    </form>

                @endif


                {{-- <p><strong>Subtotal: </strong></p> --}}
            </div>
            
            @endfor
        </div>
    </div>
@endsection