@extends('layout.app')

@section('title', 'Main Interface')

@section('content')
<div class="container text-center">
    <h2>Main Interface</h2>
    <div class="d-flex justify-content-center gap-3 mt-4">
        <a href="{{ route('challans.create') }}" class="btn btn-primary btn-lg">New Challan</a>
        <a href="{{ route('challans.edit') }}" class="btn btn-warning btn-lg">Edit Challan</a>
        <a href="{{ route('challans.inward') }}" class="btn btn-info btn-lg">Inward Challan</a>
        <a href="{{ route('challans.reports') }}" class="btn btn-success btn-lg">Reports of Challans</a>
    </div>
</div>
@endsection
