Rest Logger

Adds ability to log REST API calls. Some routes can be ignored to focus on desired informations. Note that authorization 
request will be logged without body as to avoid security breach.

## Setup

### Get the package

**Composer Package:**


```
composer require blackbird/rest-logger
```

**Zip Package:**

Unzip the package in app/code/Blackbird/RestLogger, from the root of your Magento instance.


### Install the module

Go to your Magento root directory and run the following magento command:

```
php bin/magento setup:upgrade
```

**If you are in production mode, do not forget to recompile and redeploy the static resources, or use the `--keep-generated` option.**
