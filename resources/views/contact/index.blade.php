@extends('layouts.master')

@section('css')
@endsection

@section('mainTitle')
    {{ trans('contact/contact.title') }}
@endsection

@section('pageTitle1')
    <a href="{{ route('contact') }}">{{ trans('contact/contact.pageTitle1') }}</a>
@endsection

@section('pageTitle2')
    <a href="{{ route('contact') }}">{{ trans('contact/contact.pageTitle1') }}</a>
@endsection

@section('subTitle')
    {{ trans('contact/contact.subTitle') }}
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12 mb-30">
            <div class="card card-statistics h-100">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12 mb-30">
                            <div class="card">
                                <div class="card-body">
                                    <div class="user-bg" style="background: url({{ URL::asset('assets/images/user-bg.jpg') }});">
                                        <div class="user-info">
                                            <div class="row">
                                                <div class="col-lg-6 align-self-center">
                                                    <div class="user-dp"><img src="{{ URL::asset('assets/images/11.jpg') }}" alt=""></div>
                                                    <div class="user-detail">
                                                    <h2 class="name">{{ trans('contact/contact.name') }}</h2>
                                                    <p class="designation mb-0">- Back end web developer</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card mb-30 about-me">
                                <div class="card-body">
                                    <h5 class="card-title"> {{ trans('contact/contact.about') }}</h5>
                                    <p>{{ trans('contact/contact.about_p1') }}</p>
                                    <br>
                                    <p>{{ trans('contact/contact.about_p2') }}</p>
                                    <ul class="list-unstyled ">
                                        <li class="list-item"><span class="text-info ti-email"></span>+201098617164</li>
                                        <li class="list-item"><span class="text-warning ti-direction-alt"></span>bwazik@outlook.com</li>
                                        <li class="list-item"><span class="text-danger ti-linkedin"></span><a href="https://www.linkedin.com/in/bazoka">bazoka</a></li>
                                        <li class="list-item"><span class="text-success ti-instagram"></span>/bwazik</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')

@endsection
