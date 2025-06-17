@extends('layouts.petugas')

@section('title', 'Import Data Siswa')

@section('content')
<div class="p-6">
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-4 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

<form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="file" name="file" required>
    <button type="submit">Import</button>
</form></div>
@endsection
