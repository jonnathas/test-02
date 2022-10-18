@extends('layout.app')

@section('content')

    <div class="container">
        <div class="col-md-3 card">

            <h4 class="card-title m-2 text-center">{{$product->name}}</h4>
            {!! Form::model($product,[ 
                'method' => 'PUT',
                'url' => route('product.update',[$product->id]),
                'class' => 'm-2'
                ]) !!}


            <label>Preço:</label>
            {!! Form::number('price',null,['class' =>'form-control mb-2']) !!}
            

            {!! Form::submit('Atualizar produto',['class' => 'btn btn-success form-control']) !!}

        </div>
    </div>
@endsection