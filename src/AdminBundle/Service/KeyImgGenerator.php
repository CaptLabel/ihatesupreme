<?php
namespace AdminBundle\Service;

class KeyImgGenerator
{
    public function getKeyImg($name)
    {
        $timestamp = 1234567890;
        $date_time = \Date('dmY', $timestamp);
        $k = $name . $date_time;
        $hash = hash('sha256', $k);

        return $hash;
    }
}