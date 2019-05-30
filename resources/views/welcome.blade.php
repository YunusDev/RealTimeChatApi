<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            p{

                font-weight: bold;
            }

            code{

                padding-left: 10px;
                color: red;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="container mt-20 mb-50">


                <h3 class="mb-3">Test User - Login Details</h3>
                <p>Email: <code>ade@gmail.com</code>, password: <code>ade123</code></p>

                <h3 class="mb-3">End Points</h3>

                <p>Create a Token to authenticate user<code>http://real-time-chat-api-1.herokuapp.com/api/oauth/token</code></p>
                <p>Get authenticated User<code>http://real-time-chat-api-1.herokuapp.com/api/user</code></p>
                <p>Get all User<code>http://real-time-chat-api-1.herokuapp.com/api/users</code></p>
                <p>Create a User<code>http://real-time-chat-api-1.herokuapp.com/api/users</code></p>
                <p>Edit a User<code>http://real-time-chat-api-1.herokuapp.com/api/users/{user}</code></p>
                <p>Delete a User<code>http://real-time-chat-api-1.herokuapp.com/api/users/{user}</code></p>

                <p>Post Talk and attach users<code>http://real-time-chat-api-1.herokuapp.com/api/talk/{user}/user</code></p>
                <p>Get a  Talk<code>http://real-time-chat-api-1.herokuapp.com/api/talk/{slug}</code></p>
                <p>Get All Associated Users for Talk<code>http://real-time-chat-api-1.herokuapp.com/api/talk/{talk}/users</code></p>

                <p>Post Message to a Talk<code>http://real-time-chat-api-1.herokuapp.com/api/messages/{user}/user/{talk}/talk</code></p>
                <p>Get All Messages<code>http://real-time-chat-api-1.herokuapp.com/api/all_messages</code></p>
                <p>Get Messages for a talk<code>http://real-time-chat-api-1.herokuapp.com/api/messages/{talk}/talk</code></p>







            </div>
        </div>
    </body>
</html>
