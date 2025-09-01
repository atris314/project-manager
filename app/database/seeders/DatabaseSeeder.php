<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $users = User::factory(10)->create();

        $users->each(function ($user) {
            $projects = Project::factory(5)->create([
                'owner_id' => $user->id,
            ]);

            $projects->each(function ($project) {
                Task::factory(10)->create([
                    'project_id' => $project->id,
                    'assigned_to' => \App\Models\User::inRandomOrder()->first()->id,
                ]);
            });
        });
    }
}
