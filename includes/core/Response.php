<?php


namespace Wp\Core;


class Response
{
 private static $instance=null;

 private function __construct()
 {
     return $this;
 }

 public static function getInstance()
 {
     if (null === self::$instance) self::$instance = new self();
     return self::$instance;
 }
}