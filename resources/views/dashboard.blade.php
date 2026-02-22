<x-app-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/dashboard.js', 'resources/css/dashboard.css'])

    <div class="m-4">
        <button class="btn btn-light border" id="addCategoria">Adicionar Categoria +</button>
    </div>

    <div class="dashboard-cards d-flex gap-4 m-4 py-2" id="dashboard-cards">

        @if($categorias->count() > 0)
            @foreach($categorias as $categoria)
            <div class="card task-boards" style="min-width: 18rem;">
                <div class="card-body">

                    <h5 class="card-title fw-semibold py-2"
                        data-categoria-id="{{ $categoria->id }}" data-categoria-pos="{{ $categoria->position }}">
                        {{ $categoria->name }}
                    </h5>

                    <div class="task-list">

                        @if($categoria->tarefas->count() > 0)
                            @foreach($categoria->tarefas as $tarefa)
                                <div class="task w-full mb-2 p-2 rounded border"
                                    data-tarefa-id="{{ $tarefa->id }}" data-tarefa-pos="{{ $tarefa->position }}">
                                    {{ $tarefa->name }}
                                </div>
                            @endforeach
                        @else 
                            <div class="task-list">
                                <div class="task w-full mb-2 p-2 rounded border" data-tarefa-id="" data-tarefa-pos="1">
                                    Digite uma Tarefa...
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="d-flex justify-content-center mt-2">
                        <button class="btn btn-secondary btn-add-tarefa">
                            Adicionar Tarefa +
                        </button>
                    </div>

                </div>
            </div>
            @endforeach
        @else
            <div class="card task-boards" style="min-width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title fw-semibold py-2" data-categoria-id="" data-categoria-pos="1">Digite um Título...</h5>

                    <div class="task-list">
                        <div class="task w-full mb-2 p-2 rounded border" data-tarefa-id="" data-tarefa-pos="1">
                            Digite uma Tarefa...
                        </div>
                    </div>
                    <div class="d-flex justify-content-center mt-2">
                        <button class="btn btn-secondary btn-add-tarefa">Adicionar Tarefa +</button>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <div class="m-4">
        <button class="btn btn-light border" id="saveKanban">Salvar Kanban</button>
    </div>

    <div id="loading-overlay" class="loading-overlay d-none">
        <div class="loading-box">
            <div class="spinner-border text-primary" role="status"></div>
            <div class="mt-3 fw-semibold">Salvando alterações...</div>
        </div>
    </div>
</x-app-layout>