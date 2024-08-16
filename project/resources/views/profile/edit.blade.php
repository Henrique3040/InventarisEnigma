@extends('layouts.header')

@section('content')
 
<div class="container profile-container">
    <div class="profile-section">
        <!-- Update Profile Information -->
        <div class="profile-card">
            <h2>Profile Information</h2>
            <p>Update your account's profile information and email address.</p>
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')
                <div class="form-group">
                    <label for="name">Name</label>
                    <input input id="name" name="name" type="text" class="mt-1 block w-full" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name" />
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" name="email" type="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

        <!-- Update Password -->
        <div class="profile-card">
            <h2>Update Password</h2>
            <p>Ensure your account is using a long, random password to stay secure.</p>
            <form method="post" action="{{ route('password.update') }}">
                @csrf
                @method('put')
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input id="current_password" name="current_password" type="password" required autocomplete="current-password" />
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input id="password" name="password" type="password" required autocomplete="new-password" />
                </div>

                <div class="form-group">
                    <label for="password_confirmation">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>

        <!-- Delete Account -->
        <div class="profile-card">
            <h2>Delete Account</h2>
            <p>Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.</p>
            <form method="post" action="{{ route('profile.destroy') }}">
                @csrf
                @method('delete')
                <div class="form-group">
                    <label for="password">Password</label>
                    <input id="password" name="password" type="password" required placeholder="Password" />
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
</div>

    
@endsection