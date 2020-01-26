<?php

namespace AltezzaTravelBundle\Exception;

class HotelSeasonByDateNotExistException extends \Exception
{
    protected $message = 'Required hotel season not exists';
}
