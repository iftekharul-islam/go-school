@extends('layouts.student-app')

@section('title',  __('text.advance_collection'))

@section('content')
<div>
    @component('components.advance-collection-list',['students'=>$students , 'classes' => $classes, 'searchData' => $searchData])@endcomponent
</div>
@endsection
