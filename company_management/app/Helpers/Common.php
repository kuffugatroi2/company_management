<?php

use Illuminate\Support\Facades\Auth;

function getIdUser()
{
    return Auth::user()->id;
}

function checkPersonGender($gender)
{
    $html = '';
    $arrayGender = ['male', 'female', 'other'];
    $checkGender = in_array($gender, $arrayGender);

    if ($checkGender) {
        switch ($gender) {
            case 'male':
                $html = 'Nam';
                break;
            case 'female':
                $html = 'Nữ';
                break;
            case 'other':
                $html = 'Khác';
                break;
            default:
                break;
        }
    }
    return $html;
}

function getInfoUser()
{
    return Auth::user()->person->full_name;
}
