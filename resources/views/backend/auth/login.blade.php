@extends('backend.auth.auth_master')

@section('auth_title')
Login | Admin Panel
@endsection

@section('auth-content')
<!-- login area start -->
<div class="login-area d-flex align-items-center justify-content-center vh-100">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-header bg-primary text-white text-center">
                        <h4>Sign In</h4>
                        <p>Inventory Management System by KPN</p>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="{{ route('admin.login.submit') }}">
                            @csrf
                            @include('backend.layouts.partials.messages')
                            <div class="form-group">
                                <label for="exampleInputEmail1">Email address or Username</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-email"></i></span>
                                    </div>
                                    <input type="text" class="form-control @error('email') is-invalid @enderror"
                                        id="exampleInputEmail1" name="email" value="{{ old('email') }}" required>
                                    @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ti-lock"></i></span>
                                    </div>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror"
                                        id="exampleInputPassword1" name="password" required>
                                    @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="customControlAutosizing"
                                    name="remember">
                                <label class="form-check-label" for="customControlAutosizing">Remember Me</label>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-primary btn-block">Sign In <i
                                        class="ti-arrow-right"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- login area end -->
@endsection

@section('styles')
<style>
.login-area {
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}
</style>
@endsection