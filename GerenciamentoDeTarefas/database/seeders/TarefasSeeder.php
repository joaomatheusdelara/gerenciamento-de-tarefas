<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tarefas;

class TarefasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tarefas::create([
            'nome' => 'Finalizar o projeto',
            'descricao' => 'Concluir o projeto de desenvolvimento de tarefas.',
        ]);

        Tarefas::create([
            'nome' => 'Reunião com a equipe',
            'descricao' => 'Realizar reunião de alinhamento com a equipe às 15h.',
        ]);

        Tarefas::create([
            'nome' => 'Enviar relatório',
            'descricao' => 'Enviar o relatório semanal para o gestor.',
        ]);
    }
}