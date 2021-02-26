<?php


namespace App\Rules;


class AmmoRules implements Rules
{
    /**
     * @return array[]|mixed
     */
    public static function get()
    {
        return [
            'name' => ['required' => true, 'max' => 100, 'type' => 'string'],
            'caliber' => ['required' => true, 'min' => 0, 'max' => 30000, 'type' => 'numeric'],
            'bullets' => ['required' => true, 'min' => 0, 'max' => 255, 'type' => 'numeric'],
            'damage' => ['required' => true, 'min' => 0, 'max' => 30000, 'type' => 'numeric'],
            'penetration' => ['required' => true, 'min' => 0, 'max' => 255, 'type' => 'numeric'],
            'armor-damage' => ['required' => true, 'min' => 0, 'max' => 255, 'type' => 'numeric'],
            'accuracy' => ['required' => true, 'min' => -255, 'max' => 255, 'type' => 'numeric'],
            'recoil' => ['required' => true, 'min' => -255, 'max' => 255, 'type' => 'numeric'],
            'fragmentation' => ['required' => true, 'min' => 0, 'max' => 255, 'type' => 'numeric'],
        ];
    }
}