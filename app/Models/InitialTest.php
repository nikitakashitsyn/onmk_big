<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class InitialTest extends Model
{
    public const CATEGORIES = [
        'Нарушения восприятия',
        'Нарушения внимания',
        'Нарушения памяти',
        'Нарушения мышления',
        'Двигательные нарушения',
        'Нарушения речи',
        'Блок без названия 1',
        'Блок без названия 2',
    ];

    public const LEVELS = [
        1 => 'легкая степень',
        2 => 'тяжелая степень',
    ];

    public static function getText(string $key)
    {
        if ($exploded = explode("_", $key)) {
            return sprintf('%s (%s)', self::CATEGORIES[$exploded[0]-1], self::LEVELS[$exploded[1]]);
        }
    }
}
