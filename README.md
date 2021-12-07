# WordPress Google Analytics Library

#### Version: 0.4.1

[![Packagist](https://badgen.net/packagist/v/ideasonpurpose/wp-google-analytics)](https://packagist.org/packages/ideasonpurpose/wp-google-analytics)
[![codecov](https://codecov.io/gh/ideasonpurpose/wp-google-analytics/branch/master/graph/badge.svg)](https://codecov.io/gh/ideasonpurpose/wp-google-analytics)
[![Coveralls github](https://img.shields.io/coveralls/github/ideasonpurpose/wp-google-analytics?label=Coveralls)](https://coveralls.io/github/ideasonpurpose/wp-google-analytics)
[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/ideasonpurpose/wp-google-analytics)](https://codeclimate.com/github/ideasonpurpose/wp-google-analytics)
[![Travis Build Status](https://img.shields.io/travis/ideasonpurpose/wp-google-analytics?logo=travis)](https://travis-ci.org/ideasonpurpose/wp-google-analytics)
[![styled with prettier](https://img.shields.io/badge/styled_with-prettier-ff69b4.svg)](https://github.com/prettier/prettier)

The goal of this package is to help remove development noise from collected stats by only injecting Google Analytics when no users are logged in. For development tasks where `WP_DEBUG` set to true, tracking code will be injected using a fallback `UA-xxxx` tracking ID.

Analytics code is only injected when `is_user_logged_in` is false. We're interested in visitor traffic, not author or developer traffic. For sites with lower traffic, this can make a real difference.

When `is_user_logged_in()` is false, tracking code will be injected with either the primary or fallback tracking ID. This package assumes that when `WP_DEBUG` is true, the site is in development and should use a fallback tracking ID. Otherwise, with no one logged in and `WP_DEBUG` unset or false, the primary tracking id will be served.

## Usage

This library is available on Packagist, just require it in **composer.json** to add it to the project or tell Composer to load the package:

```
$ composer require ideasonpurpose/wp-gooogle-analytics
```

Then initialize the code with a primary and fallback tracking ID:

```php
use IdeasOnPurpose\WP\GoogleAnalytics;

new GoogleAnalytics("UA-000000-1", "UA-000000-2");
```

For the sake of future maintenance, it's a good idea to store tracking IDs in descriptive variables:

```php
$client_prod_id = "UA-000000-1";
$local_dev_id = "UA-000000-2";
new GoogleAnalytics($client_prod_id, $local_dev_id);
```
