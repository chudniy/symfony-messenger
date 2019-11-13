<?php

namespace App\Messenger;

use App\Message\Command\LogEmoji;
use Exception;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\BusNameStamp;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

class ExternalJsonMessengerSerializer implements SerializerInterface
{

    /**
     * Decodes an envelope and its message from an encoded-form.
     *
     * The `$encodedEnvelope` parameter is a key-value array that
     * describes the envelope and its content, that will be used by the different transports.
     *
     * The most common keys are:
     * - `body` (string) - the message body
     * - `headers` (string<string>) - a key/value pair of headers
     *
     * @throws MessageDecodingFailedException
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];
        $data = json_decode($body, true);

        if (null === $data) {
            throw new MessageDecodingFailedException('Invalid JSON');
        }

        if (!isset($headers['type'])) {
            throw new MessageDecodingFailedException('Missing "type" header');
        }
        switch ($headers['type']) {
            case 'emoji':
                $envelope = $this->createLogEmojiEnvelope($data);
                break;
            default:
                throw new MessageDecodingFailedException(sprintf('Invalid type "%s"', $headers['type']));
        }

        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            $stamps = unserialize($headers['stamps']);
        }

        $envelope = $envelope->with(... $stamps);

        return $envelope;
    }

    /**
     * Encodes an envelope content (message & stamps) to a common format understandable by transports.
     * The encoded array should only contain scalars and arrays.
     *
     * Stamps that implement NonSendableStampInterface should
     * not be encoded.
     *
     * The most common keys of the encoded array are:
     * - `body` (string) - the message body
     * - `headers` (string<string>) - a key/value pair of headers
     */
    public function encode(Envelope $envelope): array
    {
        // this is called if a message is redelivered for "retry"
        $message = $envelope->getMessage();
        // expand this logic later if you handle more than
        // just one message class
        if ($message instanceof LogEmoji) {
            // recreate what the data originally looked like
            $data = ['emoji' => $message->getEmojiIndex()];
            $type = 'emoji';
        } else {
            throw new Exception('Unsupported message class');
        }
        $allStamps = [];
        foreach ($envelope->all() as $stamps) {
            $allStamps = array_merge($allStamps, $stamps);
        }
        return [
            'body' => json_encode($data),
            'headers' => [
                // store stamps as a header - to be read in decode()
                'stamps' => serialize($allStamps),
                'type' => $type,
            ],
        ];
    }

    /**
     * @param $data
     * @param array $stamps
     * @return Envelope
     */
    private function createLogEmojiEnvelope($data): Envelope
    {
        if (!isset($data['emoji'])) {
            throw new MessageDecodingFailedException('Missing the emoji key!');
        }

        $message = new LogEmoji($data['emoji']);

        $envelope = new Envelope($message);

        // needed only if you need this to be sent through the non-default bus
        $envelope = $envelope->with(new BusNameStamp('command.bus'));

        return $envelope;
    }
}