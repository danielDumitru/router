<?php
/**
 * File: Route.php
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
final class Route{
    private $callback, $regex, $args;
    private $patterns = [
        ':string' => '([a-z\-]+)',
        ':numeric' => '(\d+)',
        ':alfanumeric' => '(\w+)'
    ];

    public function __construct($callback, $regex){
        $this->callback($callback);
        $this->compileRegex($regex);
    }

    /**
     * Construim regex-ul pt ruta si setam propietatea $regex
     * @param $regex
     */
    private function compileRegex($regex){
        $regex = "/^".str_replace("/", "\/", $regex)."$/i";
        $this->regex = str_replace(array_keys($this->patterns), array_values($this->patterns), $regex);
    }

    /**
     * Setam callback
     * clasa@metoda => array['clasa', 'metoda']
     * functie => string 'functie'
     * @param $callback
     */
    private function callback($callback){
        if(strpos($callback, '@') !== false){
            $this->callback = explode('@', $callback);
        }else{
            $this->callback = $callback;
        }
    }

    /**
     * Verificam daca $input(requestul http) corespunde cu regex-ul instantei
     * @param $input
     * @return bool
     */
    public function match($input){
        if(preg_match($this->regex, $input, $out)){
            $this->args = $out;
            return true;
        }
        return false;
    }

    /**
     * Getter pt callback
     * @return mixed
     */
    public function getCallback(){
        return $this->callback;
    }

    /**
     * Getter argumente pt metoda/functie
     * @return bool
     */
    public function getArgs(){
        return $this->args;
    }
}