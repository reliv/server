Reliv Server
============

Server Environment detection based on config array-file 

##### Usage #####
In your bootstrap file (usually index.php)

```php

    // First Auto-loader or include file
    // Include the environment specific config file
    \Reliv\Server\Environment::setLocalEnvironment(__DIR__ . '/../config/env.php');
    
```

Config file format:
```php

    <?php
    return [
        'RelivServerEnvironment' => [
            'name' => 'local',
            'isProduction' => false,
            'initSet' => [
                // EXAMPLE:
                'xdebug.max_nesting_level' => 200,
            ],
        ],
    ];
    
```


##### Project homepage: #####
https://github.com/reliv

##### Project author: #####
James Jervis

##### Project author email: #####
jjervis@relivinc.com

##### Project author homepage: #####
https://github.com/reliv/server
