<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function() use($router){
    $router->get('akun', 'AdminController@akun');
    $router->post('register', 'AdminController@daftar');
    $router->post('login', 'AdminController@login');
    $router->get('aktif', 'AdminController@aktif');
    $router->post('logout', 'AdminController@logout');
    $router->get('home', 'HomeController@index');

    //Karyawan
    $router->get('karyawan', 'KaryawanController@index');
    $router->post('karyawan', 'KaryawanController@store');
    $router->put('karyawan/{id}', 'KaryawanController@update');
    $router->delete('karyawan/{id}', 'KaryawanController@destroy');

    //Proyek
    $router->get('proyek', 'ProyekController@index');
    $router->post('proyek', 'ProyekController@store');
    $router->put('proyek/{id}', 'ProyekController@update');
    $router->delete('proyek/{id}', 'ProyekController@destroy');

    //Milestone
    $router->get('milestone', 'MilestoneController@index');
    $router->post('milestone', 'MilestoneController@store');
    $router->put('milestone/{id}', 'MilestoneController@update');
    $router->delete('milestone/{id}', 'MilestoneController@destroy');

    //Jabatan, Status, Kategori
    $router->get('jabatan', 'JabatanController@index');
    $router->get('status', 'StatusController@index');
    $router->get('kategori', 'KategoriController@index');

    //Berkas
    $router->get('berkas', 'BerkasController@index');
    $router->post('berkas', 'BerkasController@store');
    $router->put('berkas/{id}', 'BerkasController@update');
    $router->delete('berkas/{id}', 'BerkasController@destroy');

    //Tugas
    $router->get('tugas', 'TugasController@index');
    $router->post('tugas', 'TugasController@store');
    $router->put('tugas/{id}', 'TugasController@update');
    $router->delete('tugas/{id}', 'TugasController@destroy');
});