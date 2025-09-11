<?php

namespace App\Traits;

trait TransmutationTrait
{
    protected static $transmutationTable = [
            ['min' => 100.00, 'max' => 100.00, 'transmuted' => 100, 'letter' => 'A+', 'performance' => 'Excellent'],
            ['min' => 98.40, 'max' => 99.99, 'transmuted' => 99, 'letter' => 'A', 'performance' => 'Excellent'],
            ['min' => 96.80, 'max' => 98.39, 'transmuted' => 98, 'letter' => 'A', 'performance' => 'Excellent'],
            ['min' => 95.20, 'max' => 96.79, 'transmuted' => 97, 'letter' => 'A-', 'performance' => 'Excellent'],
            ['min' => 93.60, 'max' => 95.19, 'transmuted' => 96, 'letter' => 'A-', 'performance' => 'Excellent'],
            ['min' => 92.00, 'max' => 93.59, 'transmuted' => 95, 'letter' => 'B+', 'performance' => 'Very Good'],
            ['min' => 90.40, 'max' => 91.99, 'transmuted' => 94, 'letter' => 'B+', 'performance' => 'Very Good'],
            ['min' => 88.80, 'max' => 90.39, 'transmuted' => 93, 'letter' => 'B', 'performance' => 'Very Good'],
            ['min' => 87.20, 'max' => 88.79, 'transmuted' => 92, 'letter' => 'B', 'performance' => 'Very Good'],
            ['min' => 85.60, 'max' => 87.19, 'transmuted' => 91, 'letter' => 'B-', 'performance' => 'Good'],
            ['min' => 84.00, 'max' => 85.59, 'transmuted' => 90, 'letter' => 'B-', 'performance' => 'Good'],
            ['min' => 82.40, 'max' => 83.99, 'transmuted' => 89, 'letter' => 'C+', 'performance' => 'Good'],
            ['min' => 80.80, 'max' => 82.39, 'transmuted' => 88, 'letter' => 'C+', 'performance' => 'Good'],
            ['min' => 79.20, 'max' => 80.79, 'transmuted' => 87, 'letter' => 'C', 'performance' => 'Fair'],
            ['min' => 77.60, 'max' => 79.19, 'transmuted' => 86, 'letter' => 'C', 'performance' => 'Fair'],
            ['min' => 76.00, 'max' => 77.59, 'transmuted' => 85, 'letter' => 'C-', 'performance' => 'Fair'],
            ['min' => 74.40, 'max' => 75.99, 'transmuted' => 84, 'letter' => 'C-', 'performance' => 'Fair'],
            ['min' => 72.80, 'max' => 74.39, 'transmuted' => 83, 'letter' => 'D+', 'performance' => 'Passed'],
            ['min' => 71.20, 'max' => 72.79, 'transmuted' => 82, 'letter' => 'D+', 'performance' => 'Passed'],
            ['min' => 69.60, 'max' => 71.19, 'transmuted' => 81, 'letter' => 'D', 'performance' => 'Passed'],
            ['min' => 68.00, 'max' => 69.59, 'transmuted' => 80, 'letter' => 'D', 'performance' => 'Passed'],
            ['min' => 66.40, 'max' => 67.99, 'transmuted' => 79, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 64.80, 'max' => 66.39, 'transmuted' => 78, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 63.20, 'max' => 64.79, 'transmuted' => 77, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 61.60, 'max' => 63.19, 'transmuted' => 76, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 60.00, 'max' => 61.59, 'transmuted' => 75, 'letter' => 'D-', 'performance' => 'Passed'],
            ['min' => 56.00, 'max' => 59.99, 'transmuted' => 74, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 52.00, 'max' => 55.99, 'transmuted' => 73, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 48.00, 'max' => 51.99, 'transmuted' => 72, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 44.00, 'max' => 47.99, 'transmuted' => 71, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 40.00, 'max' => 43.99, 'transmuted' => 70, 'letter' => 'E', 'performance' => 'Failed'],
            ['min' => 36.00, 'max' => 39.99, 'transmuted' => 69, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 32.00, 'max' => 35.99, 'transmuted' => 68, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 28.00, 'max' => 31.99, 'transmuted' => 67, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 24.00, 'max' => 27.99, 'transmuted' => 66, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 20.00, 'max' => 23.99, 'transmuted' => 65, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 16.00, 'max' => 19.99, 'transmuted' => 64, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 12.00, 'max' => 15.99, 'transmuted' => 63, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 8.00, 'max' => 11.99, 'transmuted' => 62, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 4.00, 'max' => 7.99, 'transmuted' => 61, 'letter' => 'F', 'performance' => 'Failed'],
            ['min' => 0.00, 'max' => 3.99, 'transmuted' => 60, 'letter' => 'F', 'performance' => 'Failed'],
    ];

    public static function getTransmutationTable()
    {
        return self::$transmutationTable;
    }

    public static function getTransmutedGrade($percentage)
    {
        foreach (self::$transmutationTable as $row) {
            if ($percentage >= $row['min'] && $percentage <= $row['max']) {
                return [
                    'grade'       => $row['transmuted'],
                    'letter'      => $row['letter'],
                    'performance' => $row['performance'],
                ];
            }
        }

        return [
            'grade'       => round($percentage),
            'letter'      => 'N/A',
            'performance' => 'Undefined',
        ];
    }
}
