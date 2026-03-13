<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    //send mail
    public function  send_mail()
    {
        $receiver = Administrator::find($this->receiver_id);
        if ($receiver == null) {
            $this->is_sent = 'Failed';
            $this->sent_failed_reason = 'Receiver not found.';
            $this->save();
            return;
        }
        if (!Utils::is_valid_email($receiver->email)) {
            $this->is_sent = 'Failed';
            $this->sent_failed_reason = 'Receiver email is not valid.';
            $this->save();
            return;
        }


        $data['email'] = $receiver->email;
        $data['name'] = $receiver->name;
        $data['subject'] = $this->controller;
        $data['body'] = $this->body;
        $data['view'] = 'mail';
        $data['data'] = $this->body;
        try {
            Utils::mail_sender($data);
            $this->is_sent = 'Sent';
            $this->save();
        } catch (\Throwable $th) {
            $this->is_sent = 'Failed';
            $this->sent_failed_reason = $th->getMessage();
            $this->save();
            return;
        }
    }
}
