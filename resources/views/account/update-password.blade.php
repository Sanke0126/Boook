@extends('layout.app')
@section('title')
    {{ 'Update Password' }}
@endsection

@section('content')
    <div class="container">
        <div class="row my-5">
            <div class="col-md-3">
                @include('layout.sidebar')
            </div>
            <div class="col-md-9">
                @include('layout.message')
                <div class="card border-0 shadow">
                    <div class="card-header  text-white">
                        Change Password
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('account.passwordUpdate') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="current_password" class="form-label">Old Password</label>
                                <input type="password" class="form-control" placeholder="Old Password"
                                    name="current_password" id="current_password" />
                            </div>
                            <div class="mb-3">
                                <label for="new_password" class="form-label">New Password</label>
                                <input type="password" class="form-control" placeholder="New Password" name="password"
                                    id="password" />
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" placeholder="Confirm Password"
                                    name="password_confirmation" id="password_confirmation" />
                            </div>
                            <button class="btn btn-primary mt-2">Update</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
