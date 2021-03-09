<?php

namespace Database\Seeders;

use App\Models\AnswerChoices;
use App\Models\mst_question;
use App\Models\Task;
use Database\Factories\MstQuestionFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        mst_question::factory(100)->create();
    }
}
