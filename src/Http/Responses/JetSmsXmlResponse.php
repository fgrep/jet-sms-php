<?php

namespace Erdemkeren\JetSms\Http\Responses;

use BadMethodCallException;

/**
 * Class JetSmsXmlResponse.
 */
class JetSmsXmlResponse implements JetSmsResponseInterface
{
    /**
     * The predefined status codes of the JetSms Xml api.
     *
     * @var array
     */
    protected static $statuses = [
        'OK'   => 'Mensagem aceita para transmissão',
        'NOK'  => 'Mensagem não aceita para transmissão ou pendências financeiras',
        'Erro' => 'Erro',
        'NA'   => 'Sistema não disponível',
    ];

    /**
     * The JetSms Http status code.
     *
     * @var string
     */
    protected $statusCode;

    /**
     * The message of the response if any.
     *
     * @var string|null
     */
    protected $message;

    /**
     * The group identifier.
     *
     * @var string|null
     */
    protected $groupId;

    /**
     * XmlJetSmsHttpResponse constructor.
     *
     * @param  string $data
     */
    public function __construct($data)
    {
        $this->statusCode = $data->EnviaSMSResult;
        $this->message = self::$statuses[$this->statusCode];
    }

    /**
     * Determine if the operation was successful or not.
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->statusCode === 'OK';
    }

    /**
     * Get the message of the response.
     *
     * @return null|string
     */
    public function message()
    {
        return trim($this->message) ?: null;
    }

    /**
     * Get the group identifier from the response.
     *
     * @return string
     */
    public function groupId()
    {
        return $this->groupId;
    }

    /**
     * Get the message report identifiers for the messages sent.
     * Message report id returns -1 if invalid Msisdns, -2 if invalid message text.
     */
    public function messageReportIdentifiers()
    {
        throw new BadMethodCallException(
            "JetSms XML API responses do not return message identifiers. Use groupId instead."
        );
    }

    /**
     * Get the status code.
     *
     * @return string
     */
    public function statusCode()
    {
        return $this->statusCode;
    }

    /**
     * Get the string representation of the status.
     *
     * @return string
     */
    public function status()
    {
        return array_key_exists($this->statusCode(), self::$statuses)
            ? self::$statuses[$this->statusCode()]
            : 'Unknown';
    }
}
