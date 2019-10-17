<?php

namespace ideasonpurpose;

class GoogleAnalytics
{
    /**
     * Add action to wp_head which injects the Google analytics code snippet
     * @param string $ga_ua       The Google Analytics tracking ID
     * @param string $fallback_ua A placeholder ID for use in development (UA-2565788-3 is IOP's testing ID)
     */
    public function __construct($ga_ua, $fallback_ua = 'UA-2565788-3')
    {
        $this->ua = (defined('WP_DEBUG') && WP_DEBUG) ? $fallback_ua : $ga_ua;
        add_action('wp_head', [$this, 'injectGoogleAnalytics']);
    }

    public function injectGoogleAnalytics()
    {
        if (is_user_logged_in()) {
            $user = wp_get_current_user()->user_login;
            $snippet = "<!-- User '$user' is logged in. Google Analytics snippet suppressed. -->\n";
        } else {
            $snippet = str_replace('UA_PLACEHOLDER', $this->ua, file_get_contents(__DIR__ . '/snippet.html'));
        }
        echo "\n$snippet\n";
    }
}
