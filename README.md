# Information
```
Name: CatC Wrapper
Author: Rishabh Jain
Website: https://www.hsrtech.net
Stable Version: 1.0
Minimum Requirement: PHP 5.6 with cURL extenssion
```
# Short Description
PHP wrapper for the cloudatcost's API by HSR TECH

# References
[Could at Cost API](https://github.com/cloudatcost/api)

[VPS-HOSTING.CA API](https://panel.vps-hosting.ca/api-details.php)

# Usage

### Basic Usage
The following example will show the basic
```php
$api = new \hsrtech\catc\Wrapper(
    [
        'email' => 'Registered Email',
        'api_key' => 'YourLoginEmail'
    ]
);
```
### Advance Usage
There is the ability to use this on the other website having same kind of panel with adding some other parameters.
```php
$api = new \hsrtech\catc\Wrapper(
    [
        'email' => 'Registered Email',
        'api_key' => 'YourLoginEmail'
    ],
    [
        'link' => 'The Base link for the api', // Default:  https://panel.cloudatcost.com/api
        'api_version' => 'the version of API to use', // Default = 'v1'
    ]
);

```
# Actions
### List servers
```php
$api->getServers();
```

### List templates
```php
$api->getTemplates();
```

### List tasks
```php
$api->getTasks();
```

### Power ON server
```php
$api->powerOnServer($Server_ID);
```

### Power OFF server
```php
$api->powerOffServer($Server_ID);
```

### Reboot server
```php
$api->rebootServer($Server_ID);
```

### Get Console url
```php
$api->getConsole($Server_ID);
```

### Rename server
```php
$api->renameServer($Server_ID, $Name);
```

### Modify reverse DNS
```php
$api->setRDNS($Server_ID, $rdns);
```

### Run Mode
```php
$api->runMode($Server_ID, $runmode);
```
##
## Cloud Pro Features

### Build Server
```php
$api->buildServer(
    [
        'cpu' => 'Amount of CPU cores for server',
        'ram' => 'Amount of Ram for the server',
        'storage' => 'Storage space alloted to the server',
        'os' => 'Valid Operating System ID',
    ]
);
```
### Delete Server
```php
$api->deleteServer($Server_ID);
```

### Resources
```php
$api->getResources();
```

##Extra Features
You can also return the result of last call using following function.
```php
$api->results();
```
## Credits
- [Rishabh Jain](https://www.fb.com/jrishbah55)
- [HSR Tech](https://github.com/hsrtech)

## License

  Copyright 2016 [HSR-TECH](https://www.hsrtech.net)

   Licensed under the Apache License, Version 2.0 (the "License");
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at
     http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.