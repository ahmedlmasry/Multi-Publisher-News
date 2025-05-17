@extends('layouts.frontend.app')
@section('title')
    Search News
@endsection
@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "><a href="{{route('frontend.index')}}">Home</a></li>
    <li class="breadcrumb-item active">News</li>
@endsection
@section('body')
    <!-- Main News Start-->
    <div class="main-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @forelse ($posts as $post)
                            <div class="col-md-4">
                                <div class="mn-img">
                                    <img src="{{ $post->images->first()->path }}" alt="{{$post->title}}"/>
                                    <div class="mn-title">
                                        <a href="{{ route('frontend.post.show' , $post->slug) }}">{{ $post->title }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="alert alert-info text-center my-4 py-4 rounded shadow-sm" >
                                <h5 class="mb-0"> No posts found! 📭</h5>
                            </div>
                        @endforelse
                    </div>
                </div>
                {{ $posts->links() }}
            </div>
        </div>
    </div>
    <!-- Main News End-->
@endsection
