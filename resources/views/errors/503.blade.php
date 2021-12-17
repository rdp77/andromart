@extends('layouts.errors')

@section('title', __(''))
@section('code', '503')
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))
