<!-- Top Bar Start -->
<div class="top-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="tb-contact">
                    <p><i class="fas fa-envelope"></i>{{$setting->email}}</p>
                    <p><i class="fas fa-phone-alt"></i>{{$setting->phone}}</p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="tb-menu text-right">
                    @guest
                        <a href="{{ route('register') }}">Register</a>
                        <a href="{{ route('login') }}">Login</a>
                    @endguest
                    @auth
                        <a href="{{route('frontend.dashboard.profile')}}">{{auth()->user()->name}}</a>
                        <!-- Logout Button -->
                        <a href="javascript:void(0)" onclick="showLogoutModal()">Logout</a>
                        <!-- Hidden Logout Form -->
                        <form id="formLogout" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <!-- Logout Confirmation Modal -->
                        <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel"
                             aria-hidden="true">
                            <div class="modal-dialog modal-dialog-scrollable modal-dialog-top"> <!-- position top -->
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h5 class="modal-title" id="logoutModalLabel">Confirm Logout</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                                onclick="cancelLogout()">Cancel
                                        </button>
                                        <button type="button" class="btn btn-danger" onclick="submitLogout()">Logout
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Top Bar Start -->

<!-- Brand Start -->
<div class="brand">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-4">
                <div class="b-logo">
                    <a href="/">
                        <img src="{{asset($setting->logo)}}" alt="Logo"/>
                    </a>
                </div>
            </div>
            <div class="col-lg-6 col-md-4">
            </div>
            <div class="col-lg-3 col-md-4">
                <form action="{{ route('frontend.search') }}" method="post">
                    @csrf
                    <div class="b-search">
                        <input name="search" type="text" placeholder="Search"/>
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Brand End -->

<!-- Nav Bar Start -->
<div class="nav-bar">
    <div class="container">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button
                type="button"
                class="navbar-toggler"
                data-toggle="collapse"
                data-target="#navbarCollapse"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto">
                    <a href="{{ route('frontend.index') }}"
                       class="nav-item nav-link {{ ($active ?? '') === 'home' ? 'active' : '' }}">Home</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Categories</a>
                        <div class="dropdown-menu">
                            @foreach ($categories as $category)
                                <a href="{{ route('frontend.category.posts', $category->slug) }}"
                                   class="dropdown-item" title="{{ $category->name }}">{{ $category->name }}</a>
                            @endforeach
                        </div>
                    </div>
                    <a href="{{ route('frontend.contact.index') }}"
                       class="nav-item nav-link {{ ($active ?? '') === 'contact' ? 'active' : '' }}">Contact Us</a>
                    <a href="{{ route('frontend.dashboard.profile') }}"
                       class="nav-item nav-link {{ ($active ?? '') === 'account' ? 'active' : '' }}">Account</a>
                </div>
                <!-- Social Links and Notification Dropdown -->
                <div class="social ml-auto">
                    <!-- Notification Dropdown -->
                    @auth('web')
                        <a href="#" class="nav-link dropdown-toggle" id="notificationDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-bell"></i>
                            <span id="count-notification"
                                  class="badge badge-danger">{{ auth()->user()->unreadNotifications->count() }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown"
                             style="width: 300px;">
                            <h5>Notifications</h5>
                            <a href="{{ route('frontend.dashboard.notifications.readAll') }}"
                               class="dropdown-menu">Read All</a>
                            @forelse (auth()->user()->unreadNotifications()->take(5)->get()  as $notify)
                                <div id="push-notification">
                                    <div
                                        class="dropdown-item d-flex justify-content-between align-items-center push-notification">
                                        <span> Post Comment : {{ substr($notify->data['post_title'], 0, 9) }}...</span>
                                        <a href="{{ route('frontend.post.show', $notify->data['post_slug']) }}?notify={{ $notify->id }}"><i
                                                class="fa fa-eye"></i></a>
                                    </div>
                                </div>
                            @empty
                                <div class="dropdown-item text-center no-notification">No notifications</div>
                            @endforelse
                        </div>
                    @endauth
                    <a href="{{$setting->twitter}}" title="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="{{$setting->facebook}}" title="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="{{$setting->instagram}}" title="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="{{$setting->youtube}}" title="youtube"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
        </nav>
    </div>
</div>
<!-- Nav Bar End -->

<!-- Breadcrumb Start -->
<div class="breadcrumb-wrap">
    <div class="container">
        <ul class="breadcrumb">
            @section('breadcrumb')
            @show
        </ul>
    </div>
</div>
<!-- Breadcrumb End -->

@push('js')
    <script>
        function showLogoutModal() {
            const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
            modal.show();
        }
        function submitLogout() {
            document.getElementById('formLogout').submit();
        }
        function cancelLogout() {
            const modal = new bootstrap.Modal(document.getElementById('logoutModal'));
            modal.hide();
        }
    </script>
@endpush
