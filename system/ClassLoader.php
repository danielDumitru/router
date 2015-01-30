<?php
/**
 * File: ClassLoader.php
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
defined('BASE_PATH') || (header("HTTP/1.1 403 Forbidden") & die('403 - Acces direct interzis.'));
final class ClassLoader{
    private static $instance = null;
    private $directories     = [];

    public static function init(array $paths){
        is_null(self::$instance) ? self::$instance = new self($paths) : false;
        return self::$instance;
    }

    private function __construct($paths){
        $this->addPaths($paths);
        spl_autoload_register([$this, 'load']);
    }

    private function addPaths($paths){
        foreach($paths as $key => $path){
            $this->addDir($path);
            foreach(new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS), RecursiveIteratorIterator::SELF_FIRST) as $key => $path){
                if($path->isDir())
                    $this->addDir($path);
            }
        }
    }

    private function addDir($dir){
        if(!in_array($dir, $this->directories))
            $this->directories[] = $temp = rtrim($dir, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR;
    }

    private function load($class){
        $flag = false;
        foreach($this->directories as $key => $path){
            if(is_readable($file = $path.$class.'.php')){
                include_once $file; $flag = true; break;
            }
        }
        if(!$flag)
            throw new RuntimeException("Class $class cannot be loaded!!!");
    }
}