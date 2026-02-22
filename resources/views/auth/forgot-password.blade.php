<x-guest-layout>
    <h1 class="h4 mb-3">Recuperar senha</h1>

    <p class="text-muted">
        Informe seu e-mail e enviaremos um link para redefinir sua senha.
    </p>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input id="email" type="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
        </div>

        <button type="submit" class="btn btn-primary w-100">Enviar link</button>

        <div class="text-center mt-3">
            <a href="{{ route('login') }}" class="text-decoration-none">Voltar ao login</a>
        </div>
    </form>
</x-guest-layout>