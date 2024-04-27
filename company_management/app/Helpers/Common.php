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

function checkStatusTask($status)
{
    $html = '';
    $arrayStatus = [1,2,3,4];
    $checkStatus = in_array($status, $arrayStatus);
    if ($checkStatus) {
        switch ($status) {
            case '1':
                $html = 'New';
                break;
            case '2':
                $html = 'In progress';
                break;
            case '3':
                $html = 'Resolved';
                break;
            case '4':
                $html = 'pause';
                break;
            default:
                break;
        }
    }
    return $html;
}

function checkPriorityTask($priority)
{
    $html = '';
    $arrayPriority = [1,2,3];
    $checkStatus = in_array($priority, $arrayPriority);
    if ($checkStatus) {
        switch ($priority) {
            case '1':
                $html = 'Hight';
                break;
            case '2':
                $html = 'Medium';
                break;
            case '3':
                $html = 'Low';
                break;
            default:
                break;
        }
    }
    return $html;
}
