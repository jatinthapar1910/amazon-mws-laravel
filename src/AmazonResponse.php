<?php

namespace Sonnenglas\AmazonMws;

class AmazonResponse
{
    /** @var bool */
    protected $success;

    /** @var string|array */
    protected $error;

    /** @var string */
    protected $message;

    /**
     * AmazonResponse constructor.
     * @param array $response
     */
    public function __construct($response = null)
    {
        if(!is_null($response)) {
            if (!is_array($response) || !array_key_exists('code', $response)) {
                $this->error = 'No Response found';
                $this->success = false;
            } else if ($response['code'] == 200) {
                $xml = simplexml_load_string($response['body']);
                $this->message = json_decode(json_encode((array)$xml), TRUE);
                $this->success = true;
            } else {
                $xml = simplexml_load_string($response['body'])->Error;
                $this->error = json_decode(json_encode((array)$xml->Message), TRUE);
                $this->success = false;
            }
        }
    }

    /**
     * @param bool $success
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->success;
    }

    /**
     * @param array|string $error
     */
    public function setError($error)
    {
        $this->success = false;
        $this->error = $error;
    }

    /**
     * @return array|string|null
     */
    public function getError()
    {
        if (is_array($this->error)) {
            return implode("\n", $this->error);
        }
        return $this->error;
    }

    /**
     * @param string $message
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }

    /**
     * @return string | null
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'success' => $this->success,
            'message' => $this->message,
            'error' => $this->error,
        ];
    }
}