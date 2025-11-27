@extends('layouts.app')

@section('title', 'Home - Delivery Challan App')
@section('meta_description', 'Welcome to the best Delivery Challan Management Application.')
@section('meta_keywords', 'delivery challan, invoice, billing, logistics')
@section('og_title', 'Home - Delivery Challan App')
@section('og_description', 'Streamline your invoicing with our robust challan management system.')
@section('og_image', asset('images/home-banner.jpg'))
@section('twitter_title', 'Manage Your Challans Effortlessly')
@section('twitter_description', 'Create and manage your delivery challans with ease.')
@section('twitter_image', asset('images/home-banner.jpg'))
@section('robots', 'index, follow')

@section('content')
    <h1>Welcome to the Delivery Challan Application</h1>
    <p>Manage your invoices and delivery challans efficiently.</p>
    <a href="{{ route('challans.create') }}" class="btn">Create New Challan</a>
@endsection
