<?php

namespace App\Repository;

trait ValidateRutTrait
{
    /**
     * Verify the rut and return validate
     *
     * @param  int    $rut
     * @param  string $dv
     * @return bool
     */
    public static function validateRut(string $rut, string $dv = null) : bool
    {
        if ($dv != null)
        {
            $rut = preg_replace('/[^k0-9]/i', '', (string)$rut . $dv);
        }
        else
        {
            $rut = preg_replace('/[^k0-9]/i', '', (string)$rut);
        }

        $dv  = substr($rut, -1);
        $numero = substr($rut, 0, strlen($rut)-1);
        $i = 2;
        $suma = 0;

        foreach(array_reverse(str_split($numero)) as $v)
        {
            if($i==8)
                $i = 2;
            $suma += $v * $i;
            ++$i;
        }
        $dvr = 11 - ($suma % 11);

        if($dvr == 11)
        {
            $dvr = 0;
        }
        if($dvr == 10)
        {
            $dvr = 'K';
        }

        return $dvr == strtoupper($dv);
    }
}