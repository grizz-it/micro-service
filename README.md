# GrizzIT - Micro Services

A minimalist service layer implementation for project that require a minimal 
implementation.

## Adding service definitions
To add a location where services need to be read from, add the following snippet:

```php
<?php

use GrizzIt\MicroService\Service\ServiceFactory;

ServiceFactory::loadServicesFrom('directory/with/services');
```

In that directory, services can be defined in JSON files called `services.json`.

## Defining services

Services can be defined by adding the following content to the `services.json` file:
```json
{
  "services": {
    "my_controller": {
      "class": "App\\Http\\Controller\\MyController",
      "params": ["$.my_database_connection"],
      "singleton": true
    }
  }
}
```
Inside the key `services`, the definitions can be defined.
The key of the object determines the service key, this can be referenced in
other `params` by prefixing it with `$.`, otherwise it is passed as is.
The `singleton` key can be used so only one instance is ever created during the
script run.

## Creating the service
Before a service can be created the service factory has to be initiated with a 
single line.

```php
<?php

use GrizzIt\MicroService\Service\ServiceFactory;

ServiceFactory::load();
```

Then the service can be created by running the following line:

```php
<?php

use GrizzIt\MicroService\Service\ServiceFactory;

ServiceFactory::create('my_controller');
```

This will return an instance of the defined service.

## MIT License

Copyright (c) GrizzIT

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.