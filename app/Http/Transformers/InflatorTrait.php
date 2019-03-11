<?php

namespace App\Http\Transformers;

/**
 * Trait to add inflator helper methods to any transformer
 */
trait InflatorTrait
{
    /**
     * Check if the named inflator is present in the first and second level of nested elements using the 'inflators' key.
     *
     * @param array  $options     List of options
     * @param string $inflator    Name of the inflator
     * @return boolean
     */
    public static function hasInflator(array $options, string $inflator) : bool
    {
        return array_key_exists('inflators', $options) ? in_array($inflator, $options['inflators']) : in_array($inflator, $options);
    }

    /**
     * Exclude the given relation to avoid loops
     *
     * @param string $inflator    Name of the inflator/relation
     * @return boolean
     */
    public static function isExcluded(array $options, string $relation) : bool
    {
        return array_key_exists('exclude', $options) ? in_array($relation, $options['exclude']) : in_array($relation, $options);
    }
}