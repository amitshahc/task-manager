@extends('tasks::layouts.master')

@section('content')

@include('tasks::message')

@include('tasks::projects')

<ul id="dragList" class="drag-list">
    <li class="drag-item" draggable="true">
        <h2>Mobile</h2>
        <p>
            Descrption
        </p>
    </li>
    <li class="drag-item" draggable="true">Laptop</li>
    <li class="drag-item" draggable="true">Desktop</li>
    <li class="drag-item" draggable="true">Television</li>
    <li class="drag-item" draggable="true">Radio</li>
  </ul>

  <style>
    .drag-list {
      list-style: none;
      padding: 0;
    }

    .drag-item > h2 {
      background-color:rgba(86, 103, 255, 0.81);
      padding: 10px;
      margin-bottom: 5px;
      cursor: move;
    }
  </style>
@endsection
