<?php

namespace ui;

use ui\Support\{BladeDirectives, ComponentResolver};

 class ui
 {

     public function component(string $name): string
     {
         return (new static)->components()->resolve($name);
     }

     public function components(): ComponentResolver
     {
         return new ComponentResolver();
     }

     public function directives(): BladeDirectives
     {
         return new BladeDirectives();
     }
 }