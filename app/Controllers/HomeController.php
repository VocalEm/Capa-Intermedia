<?php

namespace App\Controllers;

class HomeController
{
    public function index()
    {
        $title = 'BUYLY';
        require_once '../app/views/home.php';
    }
}
