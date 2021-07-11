<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailHomestayApprove extends Mailable
{
    use Queueable, SerializesModels;

    protected $approved;
    protected $homestay;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($approved, $homestay)
    {
        //
        $this->approved = $approved;
        $this->homestay = $homestay;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        if ($this->approved == 1) {
            $title = 'Nơi nghỉ dưỡng '. $this->homestay->name. ' đã được duyệt';
        } else {
            $title = 'Nơi nghỉ dưỡng '.$this->homestay->name. ' đã bị từ chối, vui lòng chỉnh sửa thông tin';
        }

        return $this->subject('Thông báo xét duyệt nơi nghỉ dưỡng')->view('mails.homestay_aprrove', [
           'title' => $title
        ]);
    }
}
