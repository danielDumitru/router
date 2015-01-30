<?php
/**
 * File: index.php
 * Author: danutz0501 ©copyright 2015
 * This program is free software; you can redistribute it and/or modify it under the terms of
 * the GNU General Public License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY;
 * without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 * See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with this program;
 * if not, see <http://www.gnu.org/licenses/>.
 */
define("BASE_PATH"   , realpath(__DIR__).DIRECTORY_SEPARATOR);
define("SYSTEM_PATH" , BASE_PATH."system".DIRECTORY_SEPARATOR);
require_once SYSTEM_PATH."ClassLoader.php";
try{
    ClassLoader::init([SYSTEM_PATH]);
    $route = Router::init();
    // url(ruta) de genul /sites/Simple_router/acasa/test/112 sau /sites/Simple_router/acasa/test/48563
    //daca se potriveste url-ul acceseaza metoda start1 a clasei index1
    $route->addRoute('get', 'index1@start', '/sites/Simple_router/acasa/test/:numeric');
    // url(ruta) de genul /sites/Simple_router/acasa/
    //daca se potriveste url-ul acceseaza metoda alta a clasei index1
    $route->addRoute('get', 'index1@alta', '/sites/Simple_router/acasa');
    // url(ruta) de genul /sites/Simple_router/acasa/test/string sau /sites/Simple_router/acasa/test/string-cu-linii
    //daca se potriveste url-ul acceseaza metoda de_forma a clasei index1
    $route->addRoute('get', 'index1@de_forma', '/sites/Simple_router/acasa/:string');
    // url(ruta) de genul /sites/Simple_router/oriceString/test/534534 sau /sites/Simple_router/daniel/test/48563
    //daca se potriveste url-ul acceseaza metoda complex a clasei index1
    $route->addRoute('get', 'index1@complex', '/sites/Simple_router/:string/test/:numeric');
    // url(ruta) de genul /sites/Simple_router/test
    //daca se potriveste url-ul acceseaza functia test
    $route->addRoute('get', 'test', '/sites/Simple_router/test');
    $route->addRoute('get', 'index1@index', '/sites/Simple_router/');
    $route->dispatch();
}catch (Exception $e){
    print_r($e->getTrace());
    die($e->getMessage());
}
function test(){
    echo 'test din functie';
}