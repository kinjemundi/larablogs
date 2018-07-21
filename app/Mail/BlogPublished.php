<?php

namespace App\Mail;

use App\Blog;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class BlogPublished extends Mailable
{
    use Queueable, SerializesModels;
    protected $blog;
    protected $user;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Blog $blog,User $user)
    {
        $this->blog = $blog;
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // return $this->view('view.name');
        $this->from(env('MAIL_FROM_ADDRESS'),env('MAIL_FROM_NAME'))
        ->subject('A new blog is published')
        ->view('emails.newblog')
        ->with([
            'user' => $this->user,
            'blog' =>$this->blog
        ]);
        return $this;
    }
}
