# wp-googleanalytics

#### Version: 0.3.0

[![Build Status](https://travis-ci.org/ideasonpurpose/wp-googleanalytics.svg?branch=master)](https://travis-ci.org/ideasonpurpose/wp-googleanalytics) 
[![Coverage Status](https://coveralls.io/repos/github/ideasonpurpose/wp-googleanalytics/badge.svg?branch=master)](https://coveralls.io/github/ideasonpurpose/wp-googleanalytics?branch=master)

The goal of this package is to help remove development noise from collected stats by only injecting Google Analytics when no users are logged in. For development tasks where `WP_DEBUG` set to true, tracking code will be injected using a fallback `UA-xxxx` tracking ID. 

Analytics code is only injected when `is_user_logged_in` is false. We're interested in visitor traffic, not author or developer traffic. For sites with lower traffic, this can make a real difference.

When `is_user_logged_in()` is false, tracking code will be injected with either the primary or fallback tracking ID. This package assumes that when `WP_DEBUG` is true, the site is in development and should use a fallback tracking ID. Otherwise, with no one logged in and `WP_DEBUG` unset or false, the primary tracking id will be served. 

## Usage

This library is not on Packagist yet, so Composer needs to be told where to find it. Add this to the `composer.json` `repositories` key:

```json
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/ideasonpurpose/wp-googleanalytics"
    }
  ]
```

Then tell Composer to load the package:

```
$ composer require ideasonpurpose/wp-gooogleanalytics
```

Then initialize the code with a primary and fallback tracking ID:
```php
use ideasonpurpose/GoogleAnalytics;

new GoogleAnalytics('UA-000000-1', 'UA-000000-2');
```

For the sake of future maintenance, it's a not a bad idea to store tracking IDs in descriptive variables:
```php
$client_prod_id = 'UA-000000-1';
$local_dev_id = 'UA-000000-2';
new GoogleAnalytics($client_prod_id, $local_dev_id);
```

