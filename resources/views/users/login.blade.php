@extends('layouts.master-layout')
@section('content')
    <form class="mt-5" id="login-form">
        <!-- Email input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="email">Email address</label>
            <input type="email" id="email" class="form-control" />
        </div>

        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" id="password" class="form-control" />
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
                    localStorage.setItem("user-token", token.token);
                    // console.log(localStorage.getItem('user-token'))
                    window.location = "/api/post-list"

                }).fail(function(err) {
                    console.log(err.responseJSON.errors);
                })
            });

            $(document).on('click', '.reset-password', function() {
                $('#forget-modal').modal('show');
                $("#forget-form").on('submit', function(e) {
                    e.preventDefault();
                $.ajax({
                    url:"http://localhost:8000/api/forgot",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    data:{
                        forgetemail:$('#forgetemail').val()
                    },
                    success:function(data){
                        alert(data.message);
                        window.location = "/api/login-page/"
                    },
                    error:function(){
                        console.log("error")
                    }
                })
            })
            })
        });
    </script>
@endsection
