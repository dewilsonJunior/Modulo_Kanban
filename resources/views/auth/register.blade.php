<x-guest-layout>
    <h1 class="h4 mb-3">Criar conta</h1>

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

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div class="mb-3">
            <label for="name" class="form-label">Nome</label>
            <input
                id="name"
                type="text"
                name="name"
                class="form-control"
                value="{{ old('name') }}"
                required
                autofocus
                autocomplete="name"
            >
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input
                id="email"
                type="email"
                name="email"
                class="form-control"
                value="{{ old('email') }}"
                required
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
                autocomplete="new-password"
            >
            <div class="form-text">Use uma senha forte.</div>
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar senha</label>
            <input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                class="form-control"
                required
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn btn-primary w-100">
            Registrar
        </button>

        <div class="text-center mt-3">
            <span class="text-muted">Já tem conta?</span>
            <a href="{{ route('login') }}" class="text-decoration-none">Entrar</a>
        </div>
    </form>
</x-guest-layout>