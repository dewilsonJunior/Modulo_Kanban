<x-guest-layout>
    <h1 class="h4 mb-3">Entrar</h1>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <div class="fw-semibold mb-1">Ops! Verifique os campos:</div>
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
                autofocus
                autocomplete="username"
            >
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Senha</label>
            <input
                id="password"
                type="password"
                name="password"
                class="form-control"
                required
                autocomplete="current-password"
            >
        </div>

        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                <label class="form-check-label" for="remember_me">Lembrar de mim</label>
            </div>

            @if (Route::has('password.request'))
                <a class="link-secondary text-decoration-none" href="{{ route('password.request') }}">
                    Esqueci a senha
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Entrar
        </button>

        <div class="text-center mt-3">
            <span class="text-muted">Não tem conta?</span>
            <a href="{{ route('register') }}" class="text-decoration-none">Criar conta</a>
        </div>
    </form>
</x-guest-layout>