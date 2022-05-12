<html>

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>POST</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 mx-auto">
                @yield("content")
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            let url = window.location.href;
            if (!url.includes("login") && !url.includes("register")) {

                let token = localStorage.getItem("user-token");
                $.ajax({
                    url: "http://localhost:8000/api/get-user",
                    contentType: "application/json",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        'Authorization': 'Bearer ' + token
                    },
                    success: function({
                        user
                    }) {
                        $("#user_profile_name").text(user.name);
                    },
                    error: function({
                        status
                    }) {
                        if (status === 401) {
                            localStorage.removeItem("user-token");
                            window.location.href = "/api/login-page";
                        }
                    }
                })
            }
        })
    </script>
</body>

</html>
