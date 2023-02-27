@extends('layouts.student-app')

@section('title',  __('text.advance_collection'))

@section('content')
   @component('components.advance-collection-list',['students'=>$students , 'classes' => $classes, 'searchData' => $searchData])@endcomponent
@endsection
