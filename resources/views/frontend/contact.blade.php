@extends('layouts.frontend.app',['active' => 'contact'])
@section('title')
    Contact-Us
@endsection
@section('body')
    <!-- Contact Start -->
    <div class="contact">
        <div class="container">
            <h1>Contact Us</h1><br>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row align-items-center">
                <div class="col-md-8">
                    <div class="contact-form">
                        <form action="{{ route('frontend.contact.store') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <input name="name" type="text" class="form-control" placeholder="Your Name"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="email" type="email" class="form-control" placeholder="Your Email"/>
                                </div>
                                <div class="form-group col-md-4">
                                    <input name="phone" type="text" class="form-control" placeholder="Your phone"/>
                                </div>
                            </div>
                            <div class="form-group">
                                <input name="title" type="text" class="form-control" placeholder="Subject"/>
                            </div>
                            <div class="form-group">
                                <textarea name="body" class="form-control" rows="5" placeholder="Message"></textarea>
                            </div>
                            <div>
                                <button class="btn" type="submit">Send Message</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact-info">
                        <h3>Get in Touch</h3>
                        <p class="mb-4">
                            The contact form is currently inactive. Get a functional and
                            working contact form with Ajax & PHP in a few minutes. Just copy
                            and paste the files, add a little code and you're done.
                        </p>
                        <h4><i class="fa fa-map-marker"></i>{{$setting->street }},{{ $setting->city }} ,
                            {{ $setting->country }}</h4>
                        <h4><i class="fa fa-envelope"></i>{{ $setting->email }}</h4>
                        <h4><i class="fa fa-phone"></i>+{{ $setting->phone }}</h4>
                        <div class="social">
                            <a href="{{ $setting->twitter }}"><i class="fab fa-twitter"></i></a>
                            <a href="{{ $setting->facebook }}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{ $setting->insatgram }}"><i class="fab fa-instagram"></i></a>
                            <a href="{{ $setting->youtube}}"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
