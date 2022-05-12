@extends('layouts.master-layout')

@section('content')
    <div class="mb-3 mt-2 mt-0 float-end" style="clear: both;display: block;content: '';">
        <button class="btn btn-primary show-form-modal"> <i class="fa fa-plus"></i> Add
            Post</button>
    </div>

    <form id="logout-form">
        <div class="mb-3 mt-2 mt-0 float-end" style="clear: both;display: block;content: '';">
            <button class="btn btn-primary logout"> Logout </button>
        </div>
    </form>

    <div class="mb-3 mt-2 mt-0 float-end" style="clear: both;display: block;content: '';">
        <button class="btn btn-success import-csv"> <i class="fa fa-plus"></i> Import
            CSV</button>
    </div>
    <div class="mt-2">
        <a href="" class="text-decoration-none"><button class="btn btn-info"><span
                    id="user_profile_name"></span></button></a>
    </div>
    <table class="table mt-3 table-striped">
        <form id="search-form">
            @csrf
            <input type="text" id="searchData" class="form-control" placeholder="Search">
            <button class="btn btn-sm btn-success float-end mt-2 mb-2" id="search-btn">Search</button>
        </form>
        <thead>
            <tr class="text-center">
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody class="postTBody">
        </tbody>
        <tbody class="searchTbody">

        </tbody>
    </table>
    @include('posts.form-modal')
    @include('posts.edit-form-modal')
    @include('posts.delete-modal')
    @include('posts.import-form-modal')
    <script>
        $(document).ready(function() {
            let token = localStorage.getItem('user-token');
            init();

            function init() {
                getPosts();
            }

            function getPosts() {
                $.ajax({
                    url: "http://localhost:8000/api/posts",
                    method: "GET",
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    dataType: "json",
                    success: function(posts) {
                        // console.log(posts)
                        posts = posts.data;
                        posts.forEach(post => {
                            $(".postTBody").append(`
        <tr class="text-center">
        <td>${post.id}</td>
          <td>${post.title}</td>
          <td>${post.description}</td>
          <td class="text-center"><button class="edit btn btn-sm text-primary" data-id="${post.id}"><i class="fas fa-edit text-primary"></i></button></td>
          <td class="text-center"><button type="submit" class="delete btn btn-sm text-danger" data-id="${post.id}"><i class="fas fa-trash-alt text-danger"></i></button></td>
        </tr>
      `);
                        })
                    }

                });
            }
            $("#search-form").on('submit', function(e) {
                e.preventDefault();
                var text = $('#searchData').val();
                $.ajax({
                    url: "http://localhost:8000/api/search",
                    method: "GET",
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    data: {
                        text: text,
                    },
                    success: function(posts) {
                        $(".postTBody").hide();
                        console.log(posts)
                        posts = posts.data;
                        $('.searchTbody').empty();
                        posts.forEach(post => {
                            $(".searchTbody").append(`
        <tr class="text-center">
        <td>${post.id}</td>
          <td>${post.title}</td>
          <td>${post.description}</td>
          <td class="text-center"><button class="edit btn btn-sm text-primary" ><i class="fas fa-edit text-primary"></i></button></td>
          <td class="text-center"><button type="submit" class="delete btn btn-sm text-danger"><i class="fas fa-trash-alt text-danger"></i></button></td>
        </tr>
      `);
                        })
                    },
                    error: function(err) {
                        console.log("hello error");
                    }

                });
            })


            $(document).on('click', '.show-form-modal', function() {
                $("#formModal").modal('show');

                $("#form").on('submit', function(e) {
                    $('#title-error').html("");
                    $('#description-error').html("");
                    e.preventDefault();
                    $.ajax({
                        url: "/api/posts",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': 'Bearer ' + token
                        },
                        data: {
                            title: $("#title").val(),
                            description: $("#description").val(),
                        },
                        success: function(data) {
                            console.log(data.error)
                            if (data.error) {

                                $('#title-error').html(data.error.title[0]);
                                $('#description-error').html(data.error.description[0]);
                            }
                            if (data.success) {
                                window.location = "/api/post-list"
                            }
                        }
                    })
                })
            });

            $(document).on('click', '.edit', function() {
                let id = $(this).data("id");
                $.ajax({
                    url: `/api/posts/${id}`,
                    type: "GET",
                    dataType: "json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                }).done(function(post) {
                    $('#editFormModal').modal("show");
                    var post = post.data;
                    $("#edit-title").val(post.title);
                    $("#edit-description").val(post.description);
                })

                $("#edit-form").on("submit", function(e) {
                    e.preventDefault(e);
                    $.ajax({
                        url: `/api/posts/${id}`,
                        method: "PUT",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': 'Bearer ' + token
                        },
                        data: {
                            title: $("#edit-title").val(),
                            description: $("#edit-description").val(),
                        }
                    }).done(function() {
                        window.location = '/api/post-list';
                    })
                });
            })


            $(document).on('click', '.delete', function() {
                let id = $(this).data("id");
                $("#deleteModal").modal("show");
                $("#delete-confirm").data("id", id);
            });

            $("#delete-confirm").on("click", function(e) {
                e.preventDefault();
                let id = $(this).data("id");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    url: `/api/posts/${id}`,
                    method: "DELETE",
                }).done(function() {
                    window.location = '/api/post-list';
                    alert("Delete Successfully!")
                })
            })

            $(document).on('click', '.import-csv', function() {
                $('#import-modal').modal('show');
                $("#import-form").on('submit', function(e) {
                    e.preventDefault();
                    var formData = new FormData(this);
                    $.ajax({
                        url: "http://localhost:8000/api/import",
                        method: "POST",
                        cache: false,
                        contentType: false,
                        processData: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            'Authorization': 'Bearer ' + token
                        },
                        data: formData,
                        enctype: 'multipart/form-data',
                        success: function(data) {
                            alert(data.message)
                            window.location = "/api/post-list"
                        },
                        error: function() {
                            console.log("error");
                        }
                    })
                })
            });

            $("#logout-form").on('submit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: "http://localhost:8000/api/logout",
                        method: "POST",
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                            // 'Authorization': 'Bearer ' + token
                        },
                        success: function(data) {
                            window.localStorage.removeItem("user-token");
                            alert(data.message);
                            window.location = "/api/login-page"
                        },
                        error: function() {
                            console.log("error");
                        }
                    })
                })
        });
    </script>
@endsection
