# CfdiState

<p align="center">
<a href="https://travis-ci.org/IvanSotelo/CfdiState"><img src="https://travis-ci.org/IvanSotelo/CfdiState.svg?branch=master" alt="Build Status"></a>
<a href='https://coveralls.io/github/IvanSotelo/CfdiState?branch=master'><img src='https://coveralls.io/repos/github/IvanSotelo/CfdiState/badge.svg?branch=master' alt='Coverage Status' /></a>
<a href="https://packagist.org/packages/IvanSotelo/CfdiState"><img src="https://poser.pugx.org/IvanSotelo/CfdiState/d/total.svg" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/IvanSotelo/CfdiState"><img src="https://poser.pugx.org/IvanSotelo/CfdiState/v/stable.svg" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/IvanSotelo/CfdiState"><img src="https://poser.pugx.org/IvanSotelo/CfdiState/license.svg" alt="License"></a>
</p>

### Instalación

Ejecutar en la terminal:

```sh
composer require ivansotelo/cfdistate
```

Agregar el Service Provider en `config/app.php`

```php
'providers' => [
    ...
    IvanSotelo\CfdiState\CfdiStateServiceProvider::class,
];
```

### Configuración

```shell
php artisan vendor:publish --provider="IvanSotelo\CfdiState\CfdiStateServiceProvider
" --tag=config
```

En el archivo .env asignar el modo produccion.

```.env
CFDI_STATE_PRODUCTION_MODE=true
```

### Leer XML del CFDI

Podemos recuperar la información del XML con la ayuda de nuestra clase \IvanSotelo\CfdiState\CFDIState, con el que podras acceder a los nodos y atributos. ya sea con los nombres originales o con su traducción a ingles.

Ejemplo:

```php
use IvanSotelo\CfdiState\CFDIState;

...
$cfdi = new CFDIState('/path/to/CFDI.xml');
// Obtener información de un atributo (Con los nombres originales)
echo $cfdi->Emisor->Rfc;
// Ahora en ingles, minúsculas y en snake_case:
echo $cfdi->transmitter->rfc;
// Otras funciones:
echo $cfdi->toJson();
```


### Obtener estado del CFDI ante el SAT

El servicio entrega cuatro valores: estado de la consulta, estado del cfdi, estado de cancelabilidad y estado de cancelación.

Ejemplo:

```php
use IvanSotelo\CfdiState\CFDIState;

...
$cfdi = new CFDIState('/path/to/CFDI.xml');
// Obtener información de un atributo (Con los nombres originales)
echo $cfdi->getSatStatus();

```
