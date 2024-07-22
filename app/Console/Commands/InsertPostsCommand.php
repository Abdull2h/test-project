<?php

namespace App\Console\Commands;

use App\Models\Post;
use Carbon\Carbon;
use Illuminate\Console\Command;

class InsertPostsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert-posts-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        Post::where('id',2)->update([
            'title' => Carbon::now()->format('Y-m-d H:i a')
        ]);

        error_log('done');

    }
}
