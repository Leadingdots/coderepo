<!DOCTYPE html>
    <html lang="en">
    <head>
          <meta charset="UTF-8">
          <meta name="viewport" content="width=device-width, initial-scale=1.0">
          <meta name="csrf-token" content="{{ csrf_token() }}">
          @stack('meta')
          <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
          <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
          <link rel="stylesheet" type="text/css"
		    href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
            @stack('stylesheets')
            <style>
            .help-block {
                color: red;
            }
            </style>
	
            <script>
                window.Laravel = {!!json_encode(["siteUrl" => url("/"), 'csrfToken' => csrf_token()]) !!}
            </script>
    </head>
        <body>

          <div style="width: 500px; margin: 0 auto; margin-top: 90px;">
            
            @yield('content')
            <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
            <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/axios/0.16.2/axios.js"></script>
            <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
            <script type="text/javascript">
                axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content');
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
            </script>
            @stack('appendJs')
        </div>
    </body>
    </html>