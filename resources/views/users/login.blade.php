@extends('layouts.master-layout')
@section('content')
    <form class="mt-5" id="login-form">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" class="form-control" />
            <span class="text-danger">
                <strong id="email-error"></strong>
            </span>
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control" />
            <span class="text-danger">
                <strong id="password-error"></strong>
            </span>
        </div>

        <!-- Submit button -->
        <button id="login-btn" class="btn btn-primary btn-block mb-4">Sign in</button>

        <!-- Register buttons -->
        <div class="text-center">
            <p>Not a member? <a href="{{ url('api/register-page/') }}">Register</a></p>
        </div>
    </form>

    <div class="form-group row">
        <div class="col-md-6 offset-md-4">
            <div class="checkbox">
                <label>
                    <button class="btn btn-primary reset-password">Reset Password</button>
                </label>
            </div>
        </div>
    </div>
    @include('users.forget-password')
    <script>
        $(document).ready(function() {
            let token = localStorage.getItem('user-token');
            $("#login-form").on('submit', function(e) {

                e.preventDefault();
                $.ajax({
                    url: "http://localhost:8000/api/login",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    data: {
                        email: $("#email").val(),
                        password: $("#password").val(),
                    },
                }).done(function(token) {
                    if (token.error) {
                        $('#email-error').html(token.error.email);
                        $('#password-error').html(token.error.password);
                    } else {
                        localStorage.setItem("user-token", token.token);
                        window.location = "/api/post-list"
                    }
                })
            });

            $(document).on('click', '.reset-password', function() {
                $('#forget-modal').modal('show');
                $("#forget-form").on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "http://localhost:8000/api/forgot",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': 'Bearer ' + token
                        },
                        data: {
                            forgetemail: $('#forgetemail').val()
                        },
                        success: function(data) {
                            alert(data.message);
                            window.location = "/api/login-page/"
                        },
                        error: function(err) {
                            console.log("error")
                        }
                    })

                });
            })
        })
    </script>
@endsection
