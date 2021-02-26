<?php


namespace App\Rules;


class TarkovKeysRules implements Rules
{
    /**
     * @return array[]|mixed
     */
    public static function get()
    {
        return [
            'name' => ['required' => true, 'max' => 100, 'type' => 'string'],
            'location' => ['required' => true, 'max' => 100, 'type' => 'string'],
            'description' => ['required' => true, 'max' => 10000, 'type' => 'string'],
            'quest' => ['required' => false, 'max' => 30000, 'type' => 'numeric'],
        ];
    }
}