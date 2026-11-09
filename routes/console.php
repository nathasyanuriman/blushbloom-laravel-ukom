<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('about-project', function () {
    $this->comment('Blush & Bloom - Sistem Manajemen MUA');
})->purpose('Menampilkan informasi singkat project');