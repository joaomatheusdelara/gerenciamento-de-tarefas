<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/tarefas.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.0/font/bootstrap-icons.min.css">
</head>
<body>
    <div class="app-header">
        <div class="title-container">
            <h1 class="mt-4">Lista de Tarefas</h1>
        </div>
        <div class="switch-container">
            <label for="toggleNightMode" class="form-label">Modo Noturno:</label>
            <label class="switch">
                <input type="checkbox" id="toggleNightMode">
                <span class="slider"></span>
            </label>
        </div>
    </div>
    <div class="container">

        <button id="novaTarefa" class="btn btn-primary mb-3" data-bs-toggle="collapse" data-bs-target="#formNovaTarefa">Nova Tarefa</button>


        <div id="formNovaTarefa" class="collapse">
            <form id="formTarefa">
                @csrf
                <div class="form-group">
                    <label for="nome">Título</label>
                    <input type="text" name="nome" id="nome" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="descricao">Descrição</label>
                    <textarea name="descricao" id="descricao" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Salvar</button>
            </form>
        </div>

        @if($tarefas->isEmpty())
            <div class="alert alert-info">
                Não há tarefas registradas.
            </div>
        @else
            <table class="table table-striped" id="tabelaTarefas">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome da Tarefa</th>
                        <th>Descrição</th>
                        <th>Data de Criação</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($tarefas as $tarefa)
                    <tr id="tarefa-{{ $tarefa->id }}">
                        <td>{{ $tarefa->id }}</td>
                        <td>{{ $tarefa->nome }}</td>
                        <td>{{ $tarefa->descricao }}</td>
                        <td>{{ $tarefa->created_at->format('d/m/Y H:i') }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btn-editar" data-id="{{ $tarefa->id }}">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button class="btn btn-danger btn-sm btn-excluir" data-id="{{ $tarefa->id }}">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

<div class="modal fade" id="modalEditarTarefa" tabindex="-1" aria-labelledby="modalEditarTarefaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditarTarefaLabel">Editar Tarefa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formEditarTarefa">
                    @csrf
                    <input type="hidden" name="id" id="editarId">
                    <div class="form-group">
                        <label for="editarNome">Título</label>
                        <input type="text" name="nome" id="editarNome" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editarDescricao">Descrição</label>
                        <textarea name="descricao" id="editarDescricao" class="form-control" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary mt-3">
                        <i class="bi bi-save"></i> Salvar
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
<footer class="footer mt-5 p-3 text-center">
    <p>&copy; {{ date('Y') }} Feito por João Matheus Lima de Lara</p>
</footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/tarefas.js') }}"></script>
</body>
</html>
