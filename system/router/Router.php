<?php
/**
 * File: Router.php
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
final class Router{
    private static $instance = null;
    private $get, $post, $put, $delete, $request;

    /**
     * Singleton
     * @return null|Router
     */
    public static function init(){
        is_null(self::$instance) ? self::$instance = new self() : false;
        return self::$instance;
    }

    /**
     *
     */
    private function __construct(){
        $this->get     = new RouteCollection();
        $this->post    = new RouteCollection();
        $this->put     = new RouteCollection();
        $this->delete  = new RouteCollection();
        $this->request = new Request();
    }

    /**
     * Adaugare route, fiecare ruta e o instanta a clasei Route
     * @param $method verbul(metoda) http (get, post, put, delete)
     * @param $callback callback-ul in cazul in care avem un match(poate fi o metoda dintr-o clasa sau o functie
     * @param $regex regex-ul dupa care verificam requestul http
     */
    public function addRoute($method, $callback, $regex){
        $this->{strtolower($method)}->addElement(new Route($callback, $regex));
    }

    /**
     * @return bool
     * @throws HttpException
     */
    public function dispatch(){
        //aflam metoda http folosita get, post, delete, put
        $verb = strtolower($this->request->getRequestMethod());
        //verificam daca $this->{$verb} contine cel putin 1 ruta, daca nu, nu are rost sa iteram peste vector
        if(count($this->{$verb}) === 0){
            $this->error404();
        }
        //iteram peste vector, daca $verb este get iteram peste $this->get, daca $verb e post iteram peste $this->post etc
        foreach($this->{$verb} as $key => $value){
            //$value reprezinta o instanta a clasei Route salvata in vector(get, post, put sau delete)
            //verificam daca avem un match(potrivire) cu url-ul curatat din Request
            if($value->match($this->request->cleanUri())){
                //Daca avem mai mult de un argument inseamna ca avem argumente pt a pasa functiei si folosim call_user_func_array
                //placeholderele :string :numeric: alfanumeric creeaza capturing groups(primul match e tot stringul)
                if($value->getArgs() > 1){
                    call_user_func_array($value->getCallback(), $value->getArgs());
                }else{
                    call_user_func($value->getCallback());
                }
                //oprim executia functiei
                return true;
            }
        }
        //nu avem nici un match, aruncam o eroare 404
        $this->error404();
    }

    private function error404(){
        throw new HttpException('404');
    }
}