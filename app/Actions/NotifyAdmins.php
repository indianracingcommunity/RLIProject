<?php

namespace App\Actions;

use App\Services\DiscordService;

class NotifyAdmins
{
    private $messageBody;
    private $discordChannel;
    protected $discordService;

    public function __construct(string $messageBody)
    {
        $this->messageBody = $messageBody;
        $this->discordChannel = config('services.discord.admins_notification_channel');
        $this->discordService = app()->make(DiscordService::class);
    }

    public function __invoke()
    {
        return $this->discordService
                    ->setChannel($this->discordChannel)
                    ->setMessageBody($this->messageBody)
                    ->createMessage();
    }
}
