<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Predict air pollution with k-Nearest Neighbors based on Spatiotemporal Big data and machine learning</title>

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
          
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md" style="font-size: 35px">
                    Predict air pollution with k-Nearest Neighbors based on Spatiotemporal Big data and machine learning
                </div>

                <p>Route List</p>

<pre>
Route::get('/data/feed', 'PredictionController@getData')->name('getData');
Route::get('/test', 'PredictionController@predict')->name('predict');
Route::get('/predict/more', 'PredictionController@predictMore')->name('predictMore');
Route::get('/prepare/data', 'PredictionController@prepare')->name('prepare');
Route::get('/chart/generate', 'PredictionController@chart')->name('chart');
</pre>

                <p>* Please pull this project into localhost environment and try above end points. Export lists are saving into storage directory and refer to python script in the public folder to generate charts</p>
                
                <p>Sample Prediction Result</p>

                <img src="{{asset('final result 2.jpg')}}" alt="" width="100%">



            </div>
        </div>
    </body>
</html>
