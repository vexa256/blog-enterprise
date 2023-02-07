@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message', get_buzzy_config('Siteactivenote', __('Be right back.')) )
