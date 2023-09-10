<?php

// Check if user is in IRC or not
namespace App\Services;

use App\User;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use InvalidArgumentException;
use Spatie\Activitylog\Traits\LogsActivity;

class DiscordService
{
    use LogsActivity;

    protected static $logName = 'discord';      // Name for the log
    protected static $logAttributes = ['*'];    // Log All fields in the table
    protected static $logOnlyDirty = true;      // Only log the fields that have been updated

    protected $headers;
    protected $botToken;
    protected $ircGuild;
    protected $applicantRole;
    protected $requestOptions;
    protected $profilesChannel;
    protected $notificationChannel;

    // https://discord.com/developers/docs/resources/channel#channel-object-channel-types
    private const PRIVATE_THREAD = 12;
    private const BASE_URL = "https://discord.com/api";

    // Builder set variables
    private $channel;
    private $messageBody;
    private $messageEmbed;
    private $messageId;
    private $userId;
    private $isJob;
    private $role;
    private $name;

    public function __construct()
    {
        $this->botToken = config('services.discord.bot');
        $this->requestOptions = [

        ];

        $this->headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bot ' . $this->botToken
        ];

        $this->ircGuild = (int)config('services.discord.ircGuild');
        $this->applicantRole = (int)config('services.discord.applicant_role');
        $this->profilesChannel = (int)config('services.discord.profiles_channel');
        $this->notificationChannel = (int)config('services.discord.notification_channel');
        $this->isJob = true;
    }

    public function setChannel(string $channel)
    {
        $this->channel = $channel;
        return $this;
    }
    public function setMessageBody(string $messageBody)
    {
        $this->messageBody = $messageBody;
        return $this;
    }
    public function setMessageEmbed(string $messageEmbed)
    {
        $this->messageEmbed = $messageEmbed;
        return $this;
    }
    public function setMessageId(string $messageId)
    {
        $this->messageId = $messageId;
        return $this;
    }
    public function setUserId(string $userId)
    {
        $this->userId = $userId;
        return $this;
    }
    public function isJob(bool $jobStatus = true)
    {
        $this->isJob = $jobStatus;
        return $this;
    }
    public function setRole(string $role)
    {
        $this->role = $role;
        return $this;
    }
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    protected function checkSetValues(array $mandatoryValues)
    {
        if (in_array('channel', $mandatoryValues) && !isset($this->channel)) {
            throw new InvalidArgumentException("Channel needs to be set for the called method", 400);
        } elseif (in_array('message', $mandatoryValues) && !(isset($this->messageBody) || isset($this->messageEmbed))) {
            throw new InvalidArgumentException("Message (body or embed) needs to be set for the called method", 400);
        } elseif (in_array('messageId', $mandatoryValues) && !isset($this->messageId)) {
            throw new InvalidArgumentException("Message ID needs to be set for the called method", 400);
        } elseif (in_array('userId', $mandatoryValues) && !isset($this->userId)) {
            throw new InvalidArgumentException("User Discord ID needs to be set for the called method", 400);
        } elseif (in_array('role', $mandatoryValues) && !isset($this->role)) {
            throw new InvalidArgumentException("Role ID needs to be set for the called method", 400);
        } elseif (in_array('name', $mandatoryValues) && !isset($this->name)) {
            throw new InvalidArgumentException("Name needs to be set for the called method", 400);
        }
    }

    private function httpClient()
    {
        return new HttpClient();
    }

    // API Reference: https://discord.com/developers/docs/resources/channel#create-message
    // Returns message ID
    public function createMessage(): string
    {
        $this->checkSetValues([ 'channel', 'message' ]);

        $url = self::BASE_URL . '/channels/' . $this->channel . '/messages';
        $body = [
            'content' => $this->messageBody,
            'embed' => $this->messageEmbed,
        ];
        $discordRequest = new Request('POST', $url, $this->headers, json_encode($body));

        // if ($this->isJob)
            // return dispatch(SendToDiscordJob::class, $discordRequest); // Pass job here

        $httpClient = $this->httpClient();
        $discordResponse = json_decode(
            $httpClient->send($discordRequest, $this->requestOptions)
                       ->getBody()->getContents()
        );

        return $discordResponse->id;
    }

    // API Reference: https://discord.com/developers/docs/resources/channel#edit-message
    public function editMessage(): void
    {
        $this->checkSetValues([ 'channel', 'message', 'messageId' ]);

        $url = self::BASE_URL . '/channels/' . $this->channel . '/messages/' . $this->messageId;
        $body = [
            'content' => $this->messageBody,
            'embed' => $this->messageEmbed,
        ];
        $discordRequest = new Request('PATCH', $url, $this->headers, json_encode($body));

        // if ($this->isJob)
            // return dispatch(SendToDiscordJob::class, $discordRequest); // Pass job here

        $httpClient = $this->httpClient();
        $discordResponse = $httpClient->send($discordRequest, $this->requestOptions);

        // Error response format
        // {"message": "Cannot edit a message authored by another user", "code": 50005}
    }

    // API Reference: https://discord.com/developers/docs/resources/channel#delete-message
    public function deleteMessage(): void
    {
        $this->checkSetValues([ 'channel', 'messageId' ]);

        $url = self::BASE_URL . '/channels/' . $this->channel . '/messages/' . $this->messageId;
        $discordRequest = new Request('DELETE', $url, $this->headers);

        // if ($this->isJob)
            // return dispatch(SendToDiscordJob::class, $discordRequest); // Pass job here

        $httpClient = $this->httpClient();
        $discordResponse = $httpClient->send($discordRequest, $this->requestOptions);
    }

    // API Reference: https://discord.com/developers/docs/resources/guild#remove-guild-member-role
    public function deleteRole()
    {
        $this->checkSetValues([ 'userId', 'role' ]);

        $url = self::BASE_URL . '/guilds/' . $this->ircGuild . '/members/' . $this->userId . '/roles/' . $this->role;
        $discordRequest = new Request('DELETE', $url, $this->headers);

        // if ($this->isJob)
            // return dispatch(SendToDiscordJob::class, $discordRequest); // Pass job here

        $httpClient = $this->httpClient();
        $discordResponse = $httpClient->send($discordRequest, $this->requestOptions);
    }

    // API Reference: https://discord.com/developers/docs/resources/channel#start-thread-without-message
    // Returns channel ID
    public function createPrivateThread(): string
    {
        $this->checkSetValues([ 'channel', 'name' ]);

        $url = self::BASE_URL . '/channels/' . $this->channel . '/threads';
        $body = [
            'name' => $this->name,
            'type' => self::PRIVATE_THREAD,
            'invitable' => true
        ];
        $discordRequest = new Request('POST', $url, $this->headers, json_encode($body));

        // if ($this->isJob)
            // return dispatch(SendToDiscordJob::class, $discordRequest); // Pass job here

        $httpClient = $this->httpClient();
        $discordResponse = json_decode(
            $httpClient->send($discordRequest, $this->requestOptions)
                       ->getBody()->getContents()
        );

        echo $discordResponse->id . "\n";
        return $discordResponse->id;
    }

    // API Reference: https://discord.com/developers/docs/resources/channel#add-thread-member
    public function addMemberToThread(): void
    {
        $this->checkSetValues([ 'channel', 'userId' ]);

        $url = self::BASE_URL . '/channels/' . $this->channel . '/thread-members/' . $this->userId;
        $discordRequest = new Request('PUT', $url, $this->headers);

        // if ($this->isJob)
            // return dispatch(SendToDiscordJob::class, $discordRequest); // Pass job here

        $httpClient = $this->httpClient();
        $discordResponse = $httpClient->send($discordRequest, $this->requestOptions);
    }
}
