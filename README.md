# WordPress Google Analytics Library

#### Version: 1.0.0

[![Packagist](https://badgen.net/packagist/v/ideasonpurpose/wp-google-analytics)](https://packagist.org/packages/ideasonpurpose/wp-google-analytics)
[![codecov](https://codecov.io/gh/ideasonpurpose/wp-google-analytics/branch/master/graph/badge.svg)](https://codecov.io/gh/ideasonpurpose/wp-google-analytics)
[![Coverage Status](https://coveralls.io/repos/github/ideasonpurpose/wp-google-analytics/badge.svg)](https://coveralls.io/github/ideasonpurpose/wp-google-analytics)
[![Code Climate maintainability](https://img.shields.io/codeclimate/maintainability/ideasonpurpose/wp-google-analytics)](https://codeclimate.com/github/ideasonpurpose/wp-google-analytics)
[![styled with prettier](https://img.shields.io/badge/styled_with-prettier-ff69b4.svg)](https://github.com/prettier/prettier)

This package adds Google Tag Manager to WordPress sites. The goal of the project is to help remove development noise from collected stats. Tracking snippets are only injected when no users are logged in, for development tasks where `WP_DEBUG` set to true, a fallback `UA-xxxx` tracking ID will be used.

Google Tag Manager code will only be injected when `is_user_logged_in()` is false. We want to collect traffic from visitors, not authors or developers. For sites with lower traffic, this can make a real difference.

When `is_user_logged_in()` is false, tracking code will be injected with either the primary or fallback tracking ID. This package assumes that when `WP_DEBUG` is true, the site is in development and should use a fallback tracking ID. Otherwise, with no one logged in and `WP_DEBUG` unset or false, the primary tracking id will be served.

## Usage

This library is available on [Packagist](https://packagist.org/packages/ideasonpurpose/wp-google-analytics), just require it in **composer.json** to add it to the project or tell Composer to load the package:

```
$ composer require ideasonpurpose/wp-google-analytics
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
