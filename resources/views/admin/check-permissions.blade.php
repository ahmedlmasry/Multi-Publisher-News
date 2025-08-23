<a href="{{ route('admin.permissions.check') }}" class="nav-link {{ request()->routeIs('admin.permissions.check') ? 'active' : '' }}"></a>@extends('layouts.dashboard.app')
@section('title')
    Check Permissions
@endsection

@section('body')
    <div class="container-fluid">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Your Permissions</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @php
                        $admin = auth('admin')->user();
                        $permissions = $admin->authorization ? $admin->authorization->permissions : [];

                        // Ensure permissions is an array
                        if (!is_array($permissions)) {
                            $permissions = json_decode(json_encode($permissions), true) ?: [];
                        }
                    @endphp

                    @if(count($permissions) > 0)
                        @foreach($permissions as $permission)
                            <div class="col-md-4 mb-3">
                                <div class="card border-left-success shadow h-100 py-2">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                    Permission</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ config('authorization.permissions.'.$permission) ?? $permission }}</div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-warning">You don't have any permissions assigned.</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
