<?php

namespace AdminBundle\Twig;

class AdminExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('json_decode', array($this, 'jsonDecodeFilter')),
        );
    }

    public function jsonDecodeFilter($str)
    {
        $ar = json_decode($str);
        return $ar;
    }

    public function getName()
    {
        return 'app_extension';
    }
}