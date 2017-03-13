# wp-google-analytics

#### Version: 0.1.0

The goal of this package is to help remove development noise from collected stats by only injecting Google Analytics when no users are logged in. For development tasks with `WP_DEBUG` set to true, tracking code is injected using a fallback UA-xxx tracking ID. 

Analytics code will only be injected when `is_user_logged_in` is false. We're interested in visitor traffic, not author or developer traffic. For sites with lower traffic, this can make a real difference.

When `is_user_logged_in` is false, tracking code will be injected with either the primary or fallback tracking ID. This package assumes that when `WP_DEBUG` is true, the site is in development and should use a fallback tracking ID. Otherwise, with no one logged in and `WP_DEBUG` is unset or false, the primary tracking id will be served. 

## Usage

```
$ composer require ideasonpurpose/wp-gooogle-analytics
```

Then initialize the code with a primary and fallback tracking ID:
```
use ideasonpurpose/wp-gooogle-analytics;

new wp-gooogle-analytics('UA-000000-1', 'UA-000000-2');
```

