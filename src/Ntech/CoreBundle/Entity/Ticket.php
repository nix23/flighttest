<?php

namespace Ntech\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ntech\CoreBundle\Helpers\Str;

class Ticket
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var DateTime
     */
    private $departureTime;

    /**
     * @var string
     */
    private $sourceAirport;

    /**
     * @var string
     */
    private $destAirport;

    /**
     * @var integer
     */
    private $seat;

    /**
     * @var string
     */
    private $passportId;

    public function __construct()
    {

    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setDepartureTime($departureTime)
    {
        $this->departureTime = $departureTime;
        return $this;
    }

    public function getDepartureTime()
    {
        return $this->departureTime;
    }

    public function setSourceAirport($sourceAirport)
    {
        $this->sourceAirport = $sourceAirport;
        return $this;
    }

    public function getSourceAirport()
    {
        return $this->sourceAirport;
    }

    public function setDestAirport($destAirport)
    {
        $this->destAirport = $destAirport;
        return $this;
    }

    public function getDestAirport()
    {
        return $this->destAirport;
    }

    public function setSeat($seat)
    {
        $this->seat = $seat;
        return $this;
    }

    public function getSeat()
    {
        return $this->seat;
    }

    public function setPassportId($passportId)
    {
        $this->passportId = $passportId;
        return $this;
    }

    public function getPassportId()
    {
        return $this->passportId;
    }
}
