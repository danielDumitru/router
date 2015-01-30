<?php
/**
 * File: index1.php
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
class index1{
    function start(){
        $params = func_get_args();
        echo "metoda start".$params[1];
    }
    function alta(){
        echo 'alta342423';
    }

    function de_forma(){
        $params = func_get_args();
        echo "metoda de_forma ".$params[1];
    }

    function complex(){
        $params = func_get_args();
        echo "metoda complex ".$params[1]."--".$params[2];
    }

    function index(){
        echo 'default';
    }
}