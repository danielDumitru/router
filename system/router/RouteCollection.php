<?php
/**
 * File: RouteCollection.php
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
final class RouteCollection implements IteratorAggregate, Countable{
    private $collection = [];

    /**
     * Metoda ceruta de interfata IteratorAggregate pt a face obiectul iterabil
     * @return ArrayIterator
     */
    public function getIterator(){
        return new ArrayIterator($this->collection);
    }

    /**
     * Metoda ceruta de interfata Countable pt a afla numarul de elemente din vector
     * @return int
     */
    public function count(){
        return sizeof($this->collection);
    }

    /**
     * Seter pt lista, necesita ca parametrul sa fie o instanta a clasei Route
     * @param Route $route
     */
    public function addElement(Route $route){
        $this->collection[] = $route;
    }
}