<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>सामुदायिक वन व्यवस्थापन सूचना प्रणाली</title>
    @include('includes.styles')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper" id="app">
    <router-view/>
</div>
@include('includes.scripts')
<script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
</body>

</html>
