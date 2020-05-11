<?php

use Illuminate\Database\Seeder;
use App\Feedback;

class FeedbackSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Feedback::class, 15)->create();
    }
}
