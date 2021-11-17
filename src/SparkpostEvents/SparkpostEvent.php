<?php

namespace Kameli\MailcoachSparkpostFeedback\SparkpostEvents;

use Carbon\Carbon;
use DateTimeInterface;
use Illuminate\Support\Arr;
use Spatie\Mailcoach\Domain\Shared\Models\Send;

abstract class SparkpostEvent
{
    protected array $payload;

    protected string $event;

    public function __construct(array $payload)
    {
        $this->payload = $payload;

        $this->event = Arr::get($payload, 'msys.message_event.type');
    }

    abstract public function canHandlePayload(): bool;

    abstract public function handle(Send $send);

    public function getTimestamp(): ?DateTimeInterface
    {
        $timestamp = Arr::get($this->payload, 'msys.message_event.timestamp');;

        return $timestamp ? Carbon::createFromTimestamp($timestamp)->setTimezone(config('app.timezone')) : null;
    }
}
