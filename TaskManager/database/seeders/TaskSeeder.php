<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $task =  new Task();
        // $task->title = "Tarea1";
        // $task->description = "Decripcion de la tarea";
        // $task->user_id = 2;
        // $task->save();
        Task::factory(10)->create();
    }
}
