
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Task Manager</h1>
    <h6>Lista de Tareas de los Usuarios</h6>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Decripcion</th>
                    <th>Usuario</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
            @foreach ($tasks as $task)
                <tr>
                    <td>{{$task->id}}</td>
                    <td>{{$task->title}}</td>
                    <td>{{$task->description}}</td>
                    <td>{{$task->users->name}}</td>
                </tr>
            @endforeach
        </table>
    </div>
</div>    
@stop
