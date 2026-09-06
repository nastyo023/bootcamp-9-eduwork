<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContohController extends Controller
{
    public function index()
    {
        $name = 'Aji';
        $html = '<h1>Nama saya adalah ' . $name . '</h1>';
        $fruits = ['apel', 'jeruk', 'mangga', 'pisang'];
        return view('contoh', compact('name', 'html', 'fruits'));
    }
}