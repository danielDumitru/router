<?php
/**
 * File: Request.php
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
final class Request{
    /**
     * metode http acceptate
     */
    const HTTP_VERBS = 'GET|POST|PUT|DELETE';

    /**
     * Verificam daca requestul este ajax
     * @return bool
     */
    public function isAjax(){
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest' ? true : false;
    }

    /**
     * Requestul http raw
     * @return mixed
     */
    public function rawUri(){
        return $_SERVER['REQUEST_URI'];
    }

    /**
     * Requestul http curatat(permite doar numere, litere, / si -)
     * @return mixed
     */
    public function cleanUri(){
        return preg_replace('/[^\da-z\-\/\_]/i', '', filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));
    }

    /**
     * Aflare metoda http(verb) folosita
     * @return string
     * @throws HttpRequestMethodException
     */
    public function getRequestMethod(){
        //incercam sa determinam metoda(verbul) http folosit, momentan doar get si post
        $method = isset($_SERVER['REQUEST_METHOD']) && !empty($_SERVER['REQUEST_METHOD']) && preg_match('/'.self::HTTP_VERBS.'/', $_SERVER['REQUEST_METHOD']) ? strtoupper($_SERVER['REQUEST_METHOD']) : 'GET';
        //http permite doar get si post, pt a mima put si delete folosim un request post in care definim un input _method cu valoare put sau delete
        if($method == 'POST' && isset($_POST['_method']) && !empty($_POST['_method'])){
            if($method = $_POST['_method'] == 'PUT' || $method == 'DELETE'){
                return $method;
            }
            throw new HttpRequestMethodException("Invalid Http request method.");
        }
        return $method;
    }

    /**
     * Nu are nevoie de descriere
     * @return mixed
     */
    public function getIp(){
        if(function_exists('apache_request_headers'))
            $headers = apache_request_headers();
        else
            $headers = $_SERVER;
        if(array_key_exists('X-Forwarded-For', $headers) && filter_var($headers['X-Forwarded-For'], FILTER_VALIDATE_IP))
            $the_ip = $headers['X-Forwarded-For'];
        elseif(array_key_exists('HTTP_X_FORWARDED_FOR', $headers) && filter_var($headers['HTTP_X_FORWARDED_FOR'], FILTER_VALIDATE_IP))
            $the_ip = $headers['HTTP_X_FORWARDED_FOR'];
        else
            $the_ip = filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP);
        return $the_ip;
    }
}