<?php /** @var App\Models\Correlation $correlation */ ?>
@extends('layouts.admin-lte-app', ['title' => null ])

@section('content')
   @include('model-header')
   <div class="content">
       @include('adminlte-templates::common.errors')
       <div class="box box-primary">
           <div class="box-body">
               <div class="row">
                   {!! Form::model($correlation, ['route' => ['datalab.correlations.update', $correlation->id], 'method' => 'patch']) !!}

                        @include('datalab.correlations.fields')

                   {!! Form::close() !!}
               </div>
           </div>
       </div>
   </div>
@endsection
