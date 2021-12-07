<?php

namespace IdeasOnPurpose\WP;

class GoogleAnalytics
{
    /**
     * A placeholder for WP_DEBUG which can be mocked in tests
     */
    public $is_debug = false;

    /**
     * Add action to wp_head which injects the Google analytics code snippet
     * @param string $ga_ua       The Google Analytics tracking ID
     * @param string $fallback_ua A placeholder ID for use in development (UA-2565788-3 is IOP's testing ID)
     */
    public function __construct($ga_ua, $fallback_ua = 'UA-2565788-3')
    {
        $this->is_debug = defined('WP_DEBUG') && WP_DEBUG;
        $this->ga_ua = $ga_ua;
        $this->fallback_ua = $fallback_ua;

        add_action('wp_head', [$this, 'injectGoogleAnalytics']);
    }

    public function injectGoogleAnalytics()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user()->user_login;
            $snippet = "<!-- User '$user' is logged in. Google Analytics snippet suppressed. -->\n";
        } else {
            $ua = $this->is_debug ? $this->fallback_ua : $this->ga_ua;
            $snippet = str_replace('UA_PLACEHOLDER', $ua, file_get_contents(__DIR__ . '/snippet.html'));
        }
        echo "\n{$snippet}\n";
    }
}
