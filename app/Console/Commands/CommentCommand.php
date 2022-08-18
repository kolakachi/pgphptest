<?php

namespace App\Console\Commands;

use Illuminate\Foundation\Inspiring;
use Illuminate\Console\Command;

use App\Models\User;
use Illuminate\Support\Facades\Validator;

class CommentCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:comment {user : The ID of the user} {comments : comment to append}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update user comments';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $userId = $this->argument('user');
        $comments = $this->argument('comments');
        $data = [ 
            'id' => $userId,
            "comments" => $comments
        ];
        $validator = Validator::make($data, [
            'comments' => 'required|string',
            'id' => 'required|integer|exists:users',
        ]);

        if ($validator->fails()) {
            $errors = $validator->errors()->getMessages();
            foreach($errors as $error){
                foreach($error as $message){
                    $this->comment($message);
                }
            }
        }else{
            $user = User::where('id', $userId)->first();
            $user->comments .= "\n".$comments;
            $user->save();
            $this->comment("OK");
        }        
    }
}
