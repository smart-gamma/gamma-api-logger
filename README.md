# SmartGamma API Logger Bundle

##About

SmartGamma Symfony2 REST API Logger bundle enables detailed logging (possible to separate log) for incomming calls for your API and tracks the duration, requests and responses body. 

##Installation¶

1. Using Composer
To install GammaApiLoggerBundle with Composer just add the following to your composer.json file:

```
// composer.json
{
    // ...
    require: {
        // ...
        "gamma/api-logger-bundle": "dev-master"
    }
}
```

Then, you can install the new dependencies by running Composer’s update command from the directory where your composer.json file is located:

```
php composer.phar update gamma/api-logger-bundle
```

Now, Composer will automatically download all required files, and install them for you. All that is left to do is to update your AppKernel.php file, and register the new bundle:

```php
<?php

// in AppKernel::registerBundles()
$bundles = array(
    // ...
    new Gamma\GammaApiLoggerBundle\GammaApiLoggerBundle(),
    // ...
);
```
