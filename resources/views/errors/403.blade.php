@extends('errors::minimal')

@section('title', 'Akses Dilarang')
@section('code', '403')
@section('message', __($exception->getMessage() ?: 'Anda tidak memiliki izin untuk mengakses halaman ini.'))
