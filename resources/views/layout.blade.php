<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>ToDo App</title>
  @yield('styles')
  @yield('css')
  {{-- <link rel="stylesheet" href="../../../public/css/styles.css"> --}}
</head>
<body>
  <header>
    <nav class="my-navbar">
      <a class="my-navbar-brand" href="/">ToDo App</a>
      <div class="my-navbar-control">
        {{-- ★checkメソッド：ログインしているかtrueかfalseで返す --}}
        {{-- guestメソッド：ログインしていないときにtrueを返す --}}
        @if(Auth::check())
          {{-- ★userメソッド：ログイン中のユーザーデータが連想配列で格納 --}}
          <span class="my-navbar-item">ようこそ, {{ Auth::user()->name }}さん</span>
          ｜
          <a href="#" id="logout" class="my-navbar-item">ログアウト</a>
          {{-- ログアウトのルーティング --}}
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form>
        @else
          <a class="my-navbar-item" href="{{ route('login') }}">ログイン</a>
          ｜
          <a class="my-navbar-item" href="{{ route('register') }}">会員登録</a>
        @endif
      </div>
    </nav>
  </header>
<main>
  @yield('content')
</main>
{{-- ★ログアウト処理 --}}
@if(Auth::check())
{{-- ログインしている場合のみ、ログアウト処理を実行 --}}
  <script>
    document.getElementById('logout').addEventListener('click', function(event) {
      event.preventDefault();
      document.getElementById('logout-form').submit();
    });
  </script>
@endif
@yield('scripts')
</body>
</html>