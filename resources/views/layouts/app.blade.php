<?php

{{-- Laravel内ページでのみ表示（WordPress用JSは除外） --}}
@if (!request()->is('news/*'))
    {{-- WordPressのJSは読み込まない --}}
@else
    <script src="https://www.ccmedico.com/news/wp-content/themes/montblanc/js/header.js?ver=1.0"></script>
@endif