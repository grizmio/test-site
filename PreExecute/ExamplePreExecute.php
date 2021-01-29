<?php

namespace PreExecute;

class ExamplePreExecute {
    public function __invoke(?string $body, ?array $inUrlParameters, ?array $queryStringParams, ?string $queryString, ?array $headers) : bool {
        debug('Soy ejemplo de ejecutar al antes de action() y antes de render, clase: '.self::class);
        return true; // si es false, el controlador "return"ara la ejecucion, util para redirigir sin usar die
    }
}
