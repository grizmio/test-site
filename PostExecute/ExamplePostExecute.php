<?php

namespace PostExecute;

class ExamplePostExecute {
    public function __invoke(){
        debug('Soy ejemplo de ejecutar al final de action() y antes de render, clase: '.self::class);
    }
}
