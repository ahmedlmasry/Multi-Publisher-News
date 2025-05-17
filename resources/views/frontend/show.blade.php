@extends('layouts.frontend.app')
@section('title')
    Show {{ $mainPost->title }}
@endsection
@push('header')
    <link rel="canonical" href="{{ url()->full() }}"/>
@endpush
@section('meta_desc')
    {{ $mainPost->small_desc }}
@endsection

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item "><a href="{{route('frontend.index')}}">Home</a></li>
    <li class="breadcrumb-item active">{{ $mainPost->title }}</li>
@endsection

@section('body')

    <!-- Single News Start-->
    <div class="single-news">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <!-- Carousel -->
                    <div id="newsCarousel" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#newsCarousel" data-slide-to="0" class="active"></li>
                            <li data-target="#newsCarousel" data-slide-to="1"></li>
                            <li data-target="#newsCarousel" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach($mainPost->images as $image)
                                <div class="carousel-item @if($loop->index == 0) active @endif">
                                    <img src="{{asset($image->path)}}" class="d-block w-100" alt="First Slide">
                                    <div class="carousel-caption d-none d-md-block">
                                        <h5>{{$mainPost->title}}</h5>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#newsCarousel" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#newsCarousel" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <div class="sn-content">
                        {!!$mainPost->desc!!}
                    </div>
                    <!-- Comment Section -->
                    <div class="comment-section">
                        <div class="alert alert-danger" style="display:none"></div>
                        <!-- Comment Input -->
                        @auth()
                            @if ($mainPost->comment_able == 1)
                                <form action="{{route('frontend.comment.store',$mainPost->slug)}}" method="POST" class="comment-input">
                                    @csrf
                                    <input name="comment" type="text" placeholder="Add a comment..." id="commentBox"/>
                                    <input name="user_id" value="{{auth()->user()->id}}" type="hidden">
                                    <input name="post_id" value="{{$mainPost->id}}" type="hidden">
                                    <button id="addCommentBtn" type="submit">Add</button>
                                </form>
                            @else
                                <div class="alert alert-info">
                                    Unable To Comment
                                </div>
                            @endif
                        @endauth
                        <!-- Display Comments -->
                        <div class="comments">
                            @foreach($mainPost->comments as $comment)
                                <div class="comment">
                                    <img src="{{ $comment->user->image }}" alt="User Image" class="comment-img"/>
                                    <div class="comment-content">
                                        <div class="comment-header" style="display: flex; justify-content: space-between; align-items: center;">
                                            <span class="username">{{ $comment->user->name }}</span>
                                            <small class="comment-time" style="font-size: 12px; color: #999;">
                                                {{ $comment->created_at->diffForHumans() }}
                                            </small>
                                        </div>
                                        <p class="comment-text">{{ $comment->comment }}</p>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <!-- Show More Button -->
                        @if ($mainPost->comments->count() > 2)
                            <button id="showMoreBtn" class="show-more-btn">Show more</button>
                        @endif
                    </div>

                    <!-- Related News -->
                    <div class="sn-related">
                        <h2>Related News</h2>
                        <div class="row sn-slider">
                            @foreach($posts as $post)
                                <div class="col-md-4">
                                    <div class="sn-img">
                                        <img src="{{asset($post->images->first()->path)}}" class="img-fluid"
                                             alt="Related News 1"/>
                                        <div class="sn-title">
                                            <a href="{{route('frontend.post.show',$post->slug)}}">{{$post->title}}</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="sidebar">
                        <div class="sidebar-widget">
                            <h2 class="sw-title">In This Category</h2>
                            <div class="news-list">
                                @foreach($posts as $post)
                                    <div class="nl-item">
                                        <div class="nl-img">
                                            <img src="{{asset($post->images->first()->path)}}" alt="{{$post->title}}"/>
                                        </div>
                                        <div class="nl-title">
                                            <a href="{{route('frontend.post.show',$post->slug)}}">{{$post->title}}</a>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <div class="tab-news">
                                <ul class="nav nav-pills nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#popular">Popular</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#latest">Latest</a>
                                    </li>
                                </ul>

                                <div class="tab-content">
                                    <div id="popular" class="container tab-pane active">
                                        @foreach($popular_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{asset($post->images->first()->path)}}"
                                                         alt="{{$post->title}}"/>
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{route('frontend.post.show',$post->slug)}}">{{$post->title}}</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                    <div id="latest" class="container tab-pane fade">
                                        @foreach($latest_posts as $post)
                                            <div class="tn-news">
                                                <div class="tn-img">
                                                    <img src="{{asset($post->images->first()->path)}}"
                                                         alt="{{$post->title}}"/>
                                                </div>
                                                <div class="tn-title">
                                                    <a href="{{route('frontend.post.show',$post->slug)}}"
                                                    >{{$post->title}}</a>
                                                </div>
                                            </div>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-widget">
                            <h2 class="sw-title">News Category</h2>
                            <div class="category">
                                <ul>
                                    @foreach($categories as $cat)
                                        <li><a href="">{{$cat->name}}</a><span>({{count($cat->posts)}})</span></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single News End-->
@endsection

@push('js')
    <script>
        $('.show-more-btn').on('click', function (e) {
            e.preventDefault();
            $.ajax({
                url: '{{route('frontend.post.comment',$mainPost->slug)}}',
                method: 'get',
                success: function (data) {
                    $('.comments').empty();
                    $.each(data, function (key, value) {
                        $('.comments').append(`<div class="comment">
                                <img src="${value.user.image}" alt="User Image" class="comment-img"/>
                                <div class="comment-content">
                                       <div class="comment-header" style="display: flex; justify-content: space-between; align-items: center;">
                                         <span class="username">${value.user.name}</span>
                                            <small class="comment-time" style="font-size: 12px; color: #999;">
                                               ${moment(value.created_at).fromNow()}
                                            </small>
                                         </div>
                                    <p class="comment-text">${value.comment}</p>
                                </div>
                            </div>`)
                    });
                    $('.show-more-btn').remove();
                }
            });
        });
    </script>
    <script>
        $('.comment-input').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData($(this)[0]);
            $('#commentBox').val('');
            $.ajax({
                url: "{{route('frontend.comment.store')}}",
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                success: function (data) {
                    $('.comments').prepend(`<div class="comment">
                            <img src="${data.comment.user.image}" alt="User Image" class="comment-img"/>
                            <div class="comment-content">
                                <div class="comment-header" style="display: flex; justify-content: space-between; align-items: center;">
                                    <span class="username">${data.comment.user.name}</span>
                                    <small class="comment-time" style="font-size: 12px; color: #999;">
                                               ${moment(data.comment.created_at).fromNow()}
                                    </small>
                                </div>
                                    <p class="comment-text">${data.comment.comment}</p>
                                                </div>
                                            </div>`);
                },
                error: function (xhr) {
                    var response = $.parseJSON(xhr.responseText);
                    $('.alert-danger').text(response.errors.comment).show();
                }
            });
        });
    </script>
@endpush

