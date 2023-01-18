<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.1/css/pro.min.css">
        <link rel="stylesheet" href="{{publicPath()}}/assets/css/dashboard.css">
        <link rel="stylesheet" href="{{publicPath()}}/assets/css/layout.css">
        <link rel="stylesheet" href="{{publicPath()}}/assets/css/all.css" />
        <link rel="stylesheet" href="{{publicPath()}}/assets/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" />
        <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" />
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/metismenu/dist/metisMenu.min.css"
        />

        <link id="skin-default" rel="stylesheet" href="{{asset('backend/assets/toaste/notification.css')}}">


      
    </head>
    <body>
        <div class="wrapper">
          
          {{ $slot }}

    
        </div>
        
    
        <script
          src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
          integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
          crossorigin="anonymous"
          referrerpolicy="no-referrer"
        ></script>
        <script
          src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
          integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p"
          crossorigin="anonymous"
        ></script>
        <script src="{{publicPath()}}/assets/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        <script src="https://unpkg.com/@sidsbrmnn/scrollspy@1.0.4/dist/scrollspy.min.js"></script>
        <script src="https://unpkg.com/swiper/swiper-bundle.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
        {{-- <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script> --}}
        {{-- <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script> --}}
        <script src="{{publicPath()}}/assets/js/main.js"></script>
        <script src="{{publicPath()}}/assets/js/all.js"></script>
        <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>
        <script>
          tinymce.init({
            selector: '#mytextarea',
            plugins: [
              'a11ychecker','advlist','advcode','advtable','autolink','checklist','export',
              'lists','link','image','charmap','preview','anchor','searchreplace','visualblocks',
              'powerpaste','fullscreen','formatpainter','insertdatetime','media','table','help','wordcount'
            ],
            toolbar: 'undo redo | formatpainter casechange blocks | bold italic backcolor | ' +
              'alignleft aligncenter alignright alignjustify | ' +
              'bullist numlist checklist outdent indent | removeformat | a11ycheck code table help'
          });
        </script>
         <script src="{{asset('backend/assets/toaste/notification.js')}}"></script>
         <x-alert/>

        @yield('script')
    </body>
</html>
