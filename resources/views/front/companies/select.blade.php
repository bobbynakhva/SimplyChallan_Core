@extends('layout.app')

@section('title', 'Create Company')

@section('content')
    <section class="contact__form">
        <div class="contact__bg"><img src="{{ asset('assets/images/yellow-sp.png') }}" alt="img"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="hero__wrap__users" data-aos="fade-up-left" data-aos-delay="200"
                        data-aos-duration="1200">
                        <div class="hero__wrap__users__img">
                            <span><img src="{{ asset('assets/images/hero/user-1.jpg') }}" alt="img"></span>
                            <span><img src="{{ asset('assets/images/hero/user-2.jpg') }}" alt="img"></span>
                            <span><img src="{{ asset('assets/images/hero/user-3.jpg') }}" alt="img"></span>
                            <span><img src="{{ asset('assets/images/hero/user-4.jpg') }}" alt="img"></span>
                        </div>
                        <div class="hero__wrap__users__title">
                            <span>DELIVERY CHALLAN</span>
                        </div>  
                    </div>
                    <div class="contact__form__title" data-aos="zoom-in-up" data-aos-delay="400"
                        data-aos-duration="1400">
                        <h2>Select Company & Financial Year
                            <span> ! 
                                @if (session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif
                            </span>
                        </h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact__form__main">
                        <form action="{{ route('company.select') }}" method="POST">
                            @csrf
                            <div class="row g-5">
                                <div class="col-lg-6 col-md-6">
                                    <div class="contact__form__main__single">
                                        <label for="is_hidden" class="form-label form--label">Select Company</label>
                                        <select name="is_hidden" id="is_hidden" class="form-control form--control @error('is_hidden') is-invalid @enderror">

                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>

                                <div class="col-lg-6 col-md-6">
                                    <div class="contact__form__main__single">
                                        <label for="years" class="form-label form--label">Select Financial Year</label>
                                        <select name="years" id="years" class="form-control form--control @error('years') is-invalid @enderror">
                                            @foreach ($years as $year)
                                                <option value="{{ $year->id }}">{{ $year->year }}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                                <div class="col-lg-12">
                                    <div class="contact__form__main__single">
                                        <button type="submit" class="common__btn"><span>Submit Now</span><span><i
                                                    class="fa-solid fa-arrow-right"></i></span></button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection