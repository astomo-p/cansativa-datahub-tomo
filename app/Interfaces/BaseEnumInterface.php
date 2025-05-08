<?php

namespace App\Interfaces;

/**
 * Interface to fix of coding style for Enumeration Class
 *
 * @package laravel-10-template
 * @since 1.0.0
 * @auhtor cakadi190 <cakadi190@gmail.com>
 */
interface BaseEnumInterface
{
    /**
     * Give the label for case
     *
     * @return string
     */
    public function label(): string;

    /**
     * Give the color label for case
     *
     * @return string
     */
    public function color(): string;

    /**
     * Give the value for case
     *
     * @return string
     */
    public static function values(): array;
}
