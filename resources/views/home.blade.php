@extends('layouts.app')

@section('titulo')
    iGram
@endsection

@section('contenido')

    <x-listar-post :posts="$posts" />


@endsection
