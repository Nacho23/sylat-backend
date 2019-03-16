<?php

namespace App\Enum;

/**
 * Contract to define type of book
 */
interface TypeQuestion
{
    const BRIEF = 'brief';
    const PARAGRAPH = 'paragraph';
    const MULTIPLE_CHOICE = 'multiple_choice';
    const CHECKBOX = 'checkbox';
    const SCALE = 'scale';
    const ALLOWED = [self::BRIEF, self::PARAGRAPH, self::MULTIPLE_CHOICE, self::CHECKBOX, self::SCALE];
}