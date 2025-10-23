<!DOCTYPE html>
<html class="loading" lang="{{App::getLocale() }}" dir="{{LaravelLocalization::getCurrentLocaleDirection() }}" data-textdirection="{{LaravelLocalization::getCurrentLocaleDirection() }}">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <meta name="description" content="Modern admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities with bitcoin dashboard.">
    <meta name="keywords" content="admin template, modern admin template, dashboard template, flat admin template, responsive admin template, web app, crypto dashboard, bitcoin dashboard">
    <meta name="author" content="PIXINVENT">
    <title>@yield("title", 'Survey')</title>
    <link rel="apple-touch-icon" href={{URL::asset("assets/images/ico/apple-icon-120.png")}}>
    <link rel="shortcut icon" type="image/x-icon" href={{URL::asset("assets/images/ico/favicon.ico")}}>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i%7CQuicksand:300,400,500,700" rel="stylesheet">

    @include('layout.style')

</head>
