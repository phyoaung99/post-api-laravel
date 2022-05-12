@extends('layouts.master-layout')
@section('content')
    <form class="mt-5" id="reg-form">
      @csrf
        <div class="form-outline mb-4">
            <label class="form-label" for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control"/>
            <span class="text-danger">
                <strong id="name-error"></strong>
            </span>
        </div>

        <div class="form-outline mb-4">
            <label class="form-label" for="email">Email address</label>
            <input type="email" name="email" id="email" class="form-control"/>
            <span class="text-danger">
                <strong id="email-error"></strong>
            </span>
        </div>


        <!-- Password input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="password">Password</label>
            <input type="password" name="password" id="password" class="form-control"/>
            <span class="text-danger">
                <strong id="password-error"></strong>
            </span>
        </div>

        <button id="reg-btn" class="btn btn-primary mb-4 inline-block" style="width: 100%">Register</button>
    </form>
    <script>
    $(document).ready(function() {
            $("#reg-form").on('submit', function(e) {
                $( '#name-error' ).html( "" );
                $( '#email-error' ).html( "" );
                $( '#password-error' ).html( "" );
                e.preventDefault();
                $.ajax({
                    url: "http://localhost:8000/api/register",
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    data: {
                        name: $("#name").val(),
                        email: $("#email").val(),
                        password: $("#password").val(),
                    },
                success:function(data) {
                    window.location = '/api/login-page';
                   localStorage.setItem('user-token',data.token);
                },error:function(err) {
                    // console.log(err.responseJSON.errors);
                    if(err.status === 422){
                    if(err.responseJSON.errors){
                   $( '#name-error' ).html( err.responseJSON.errors.name[0] );
                   $( '#email-error' ).html( err.responseJSON.errors.email[0] );
                   $( '#password-error' ).html( err.responseJSON.errors.password[0] );
               }}
                }
            })
            })
        });
    </script>
@endsection
