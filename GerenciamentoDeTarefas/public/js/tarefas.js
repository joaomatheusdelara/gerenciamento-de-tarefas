// deixarei comentado o que o js esta fazendo como as requesições e modo noturno

document.addEventListener('DOMContentLoaded', function() {
    const formTarefa = document.getElementById('formTarefa');
    const tarefasContainer = document.getElementById('tabelaTarefas').querySelector('tbody');
    const formEditarTarefa = document.getElementById('formEditarTarefa');
    const modalEditarTarefa = new bootstrap.Modal(document.getElementById('modalEditarTarefa'));

    document.getElementById('toggleNightMode').addEventListener('change', function() {
        document.body.classList.toggle('night-mode');
    });

    // Adicionar nova tarefa
    formTarefa.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(formTarefa);

        fetch('/tarefas', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            },
            body: formData,
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const novaTarefa = document.createElement('tr');
                novaTarefa.setAttribute('id', `tarefa-${data.tarefa.id}`);
                novaTarefa.innerHTML = `
                    <td>${data.tarefa.id}</td>
                    <td>${data.tarefa.nome}</td>
                    <td>${data.tarefa.descricao}</td>
                    <td>${new Date(data.tarefa.created_at).toLocaleString('pt-BR')}</td>
                    <td>
                        <button class="btn btn-warning btn-sm btn-editar" data-id="${data.tarefa.id}">
                            <i class="bi bi-pencil"></i>
                        </button>
                        <button class="btn btn-danger btn-sm btn-excluir" data-id="${data.tarefa.id}">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                `;
                tarefasContainer.appendChild(novaTarefa);
                formTarefa.reset();
            } else {
                alert('Erro ao adicionar tarefa');
            }
        })
        .catch(error => console.error('Erro:', error));
    });

    // Excluir tarefa
    tarefasContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('btn-excluir') || event.target.closest('.btn-excluir')) {
            const tarefaId = event.target.closest('.btn-excluir').getAttribute('data-id');

            fetch(`/tarefas/${tarefaId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const tarefaRow = document.getElementById(`tarefa-${tarefaId}`);
                    if (tarefaRow) {
                        tarefaRow.remove();
                    }
                } else {
                    alert('Erro ao excluir tarefa');
                }
            })
            .catch(error => console.error('Erro:', error));
        }

        // Editar tarefa
        if (event.target.classList.contains('btn-editar') || event.target.closest('.btn-editar')) {
            const tarefaId = event.target.closest('.btn-editar').getAttribute('data-id');

            fetch(`/tarefas/${tarefaId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('editarId').value = data.tarefa.id;
                    document.getElementById('editarNome').value = data.tarefa.nome;
                    document.getElementById('editarDescricao').value = data.tarefa.descricao;
                    modalEditarTarefa.show();
                } else {
                    alert('Erro ao carregar tarefa');
                }
            })
            .catch(error => console.error('Erro:', error));
        }
    });

    // Salvar edição da tarefa
    formEditarTarefa.addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(formEditarTarefa);
        const tarefaId = document.getElementById('editarId').value;

        fetch(`/tarefas/${tarefaId}`, {
            method: 'PUT',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nome: document.getElementById('editarNome').value,
                descricao: document.getElementById('editarDescricao').value
            }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const tarefaRow = document.getElementById(`tarefa-${tarefaId}`);
                tarefaRow.querySelector('td:nth-child(2)').textContent = data.tarefa.nome;
                tarefaRow.querySelector('td:nth-child(3)').textContent = data.tarefa.descricao;
                modalEditarTarefa.hide();
            } else {
                alert('Erro ao editar tarefa');
            }
        })
        .catch(error => console.error('Erro:', error));
    });
});
