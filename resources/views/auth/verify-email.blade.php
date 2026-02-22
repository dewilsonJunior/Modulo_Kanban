<x-guest-layout>
    <h1 class="h4 mb-3">Verificar e-mail</h1>

    <p class="text-muted">
        Antes de continuar, verifique seu e-mail clicando no link de verificação que enviamos.
        Se não recebeu, podemos enviar novamente.
    </p>

    @if (session('status') == 'verification-link-sent')
        <div class="alert alert-success">
            Um novo link de verificação foi enviado para seu e-mail.
        </div>
    @endif

    <div class="d-grid gap-2">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="btn btn-primary w-100">Reenviar verificação</button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-secondary w-100">Sair</button>
        </form>
    </div>
</x-guest-layout>