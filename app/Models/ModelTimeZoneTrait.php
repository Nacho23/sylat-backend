<?php

namespace App\Models;

use DateTime;
use DateTimeZone;

trait ModelTimeZoneTrait
{
    /**
     * Check if the given field is a column based name as created_at or created_dt
     *
     * @param string $columnName
     * @return boolean
     */
    public function isDatetimeColumn(string $columnName) : bool
    {
        return strpos($name, '_at') > 0 || strpos($name, '_dt') > 0;
    }

    /**
     * Check if the given value is ok
     *
     * @param mixed $value
     * @return boolean
     */
    public function hasValue($value) : bool
    {
        return $value !== null && $value !== '';
    }

    /**
     * Set the global timezone to every '_at' field. We use as convention that every field of type date use that name type
     *
     * @param string $timezone  Global timezone
     * @return void
     */
    public function setTimeZone(string $timezone = null)
    {
        $timezone = is_null($timezone) ? config('app.timezone') : $timezone;
        $timezone = is_null($timezone) ? 'America/Santiago' : $timezone;
        $utcTimeZone = new DateTimeZone('UTC');
        $globalTimeZone = new DateTimeZone($timezone);

        foreach ($this->getAttributes() as $name => $value)
        {
            if ($this->isDatetimeColumn($name) && $this->hasValue($value))
            {
                $dt = new DateTime($this->$name, $utcTimeZone);
                $dt->setTimezone($globalTimeZone);
                $this->$name = $dt->format('Y-m-d H:i:s');
            }
        }

        return $this;
    }
}