@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Amazon Pay からの戻り</h2>
    <p>以下はAmazon Payから戻ってきたパラメータです。</p>

    <pre>{{ print_r($params, true) }}</pre>

    <a href="{{ url('/') }}" class="btn btn-secondary">ホームへ戻る</a>
</div>
@endsection
