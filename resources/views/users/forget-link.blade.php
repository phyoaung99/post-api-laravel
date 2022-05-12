@extends('layouts.master-layout')
@section('content')
    <form class="mt-5" id="reset-form">
        <!-- hidden token -->
        <input type="hidden" name="token" id="token" value="{{ $token }}">
        {{-- password new --}}
        <div class="form-outline mb-4">
            <label class="form-label" for="resetemail">New Password</label>
            <input type="password" name="password" id="password" class="form-control" required />
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="resetpassword">Confirm Password</label>
            <input type="password" name="password_confirm" id="password_confirm" class="form-control" required />
        </div>
        <button id="reset-btn" class="btn btn-primary btn-block mb-4">Change Password</button>
    </form>

    <script>
        $(document).ready(function() {
            let token = localStorage.getItem('user-token');
            $("#reset-form").on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "http://localhost:8000/api/reset",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    data: {
                        token: $('input[name=token]').val(),
                        password: $('#password').val(),
                        password_confirm: $('#password_confirm').val(),
                    },
                    success: function(data) {
                        alert(data.message);
                        window.location = "/api/login-page/"
                    },
                    error: function() {
                        console.log("error");
                    }
                })
            })
        });
    </script>
@endsection
