<?php

if (!function_exists('getGradeConfig')) {
    function getGradeConfig($average) {
        return \App\Helpers\GradeHelper::getGradeConfig($average);
    }
}

if (!function_exists('getProgressWidth')) {
    function getProgressWidth($average, $min = 60, $max = 100) {
        return \App\Helpers\GradeHelper::getProgressWidth($average, $min, $max);
    }
}