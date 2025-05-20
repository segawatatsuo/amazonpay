@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Amazon Pay サンドボックス決済テスト</h2>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form method="GET" action="{{ route('amazonpay.checkout') }}">
        <button type="submit" class="btn btn-primary">
            Amazon Pay で支払う（テスト）
        </button>
    </form>
</div>
@endsection
