<?php 
namespace App\Helpers;

class GradeHelper
{
    public static function getGradeConfig($average)
    {
        if ($average >= 96) {
            return [
                'badge' => 'bg-gradient-to-r from-purple-100 to-purple-200 text-purple-800 border border-purple-300',
                'progress' => 'bg-purple-500',
                'grade' => 'A+',
                'label' => 'Excellent'
            ];
        } elseif ($average >= 92) {
            return [
                'badge' => 'bg-gradient-to-r from-blue-100 to-blue-200 text-blue-800 border border-blue-300',
                'progress' => 'bg-blue-500',
                'grade' => 'A',
                'label' => 'Very Good'
            ];
        } elseif ($average >= 84) {
            return [
                'badge' => 'bg-gradient-to-r from-green-100 to-green-200 text-green-800 border border-green-300',
                'progress' => 'bg-green-500',
                'grade' => 'B',
                'label' => 'Good'
            ];
        } elseif ($average >= 75) {
            return [
                'badge' => 'bg-gradient-to-r from-yellow-100 to-yellow-200 text-yellow-800 border border-yellow-300',
                'progress' => 'bg-yellow-500',
                'grade' => 'C',
                'label' => 'Fair'
            ];
        } elseif ($average >= 60) {
            return [
                'badge' => 'bg-gradient-to-r from-orange-100 to-orange-200 text-orange-800 border border-orange-300',
                'progress' => 'bg-orange-500',
                'grade' => 'D',
                'label' => 'Needs Improvement'
            ];
        } else {
            return [
                'badge' => 'bg-gradient-to-r from-red-100 to-red-200 text-red-800 border border-red-300',
                'progress' => 'bg-red-500',
                'grade' => 'F',
                'label' => 'Failing'
            ];
        }
    }

    public static function getProgressWidth($average, $min = 60, $max = 100)
    {
        return min(100, max(0, ($average - $min) / ($max - $min) * 100));
    }
}