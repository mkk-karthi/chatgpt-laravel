<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}">

    <title>{{ env('APP_NAME') }}</title>

    <!-- Icon -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    {{-- jquery --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <style>
        @media (min-width: 576px) {
            .offcanvas {
                --bs-offcanvas-width: 100%;
            }
        }

        @media (min-width: 768px) {
            .offcanvas {
                --bs-offcanvas-width: 30%;
            }
        }

        @media (min-width: 1200px) {
            .offcanvas {
                --bs-offcanvas-width: 20%;
            }
        }

        .fixed-bottom {
            z-index: 1000 !important;
        }

        .chat-group {
            cursor: pointer;
        }

        .chat-group-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 75%;
        }

        textarea {
            border: none !important;
        }

        textarea:focus {
            box-shadow: none !important;
            border: none !important;
        }
    </style>
</head>

<body>
    <div id="notify-messages" class="position-fixed" style="z-index: 1000; top:66px; right: 20px;">
    </div>

    @yield('content')
</body>

</html>
