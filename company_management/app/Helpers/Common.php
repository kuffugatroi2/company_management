<?php

use Illuminate\Support\Facades\Auth;

function getIdUser()
{
    return Auth::user()->id;
}
