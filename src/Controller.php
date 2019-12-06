<?php


namespace App;


class Controller
{
    public function index()
    {
        return new View\View('index', ['title' => 'Index Page PHP']);
    }

    public function about()
    {
        return new View\View('about', ['title' => 'About Page']);
    }
}