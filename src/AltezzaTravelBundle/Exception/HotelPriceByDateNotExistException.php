<?php

namespace AltezzaTravelBundle\Exception;

class HotelPriceByDateNotExistException extends \Exception
{
    protected $message = 'Required hotel price not exists';
}
