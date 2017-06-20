<?php

namespace ideasonpurpose;

class GoogleAnalytics
{
    /**
     * Add action to wp_head which injects the Google analytics code snippet
     * @param string $ga_ua       The Google Analytics tracking ID
     * @param string $fallback_ua A placeholder ID for use in development
     */
    public function __construct($ga_ua, $fallback_ua = 'UA-000000-2')
    {
        $this->ua = (is_user_logged_in()) ? false : $ga_ua;
        $this->ua = (defined('WP_DEBUG') && WP_DEBUG) ? $fallback_ua : $this->ua;
        if ($this->ua) {
            add_action('wp_head', [$this, 'injectGoogleAnalytics']);
        }
    }

    public function injectGoogleAnalytics()
    {
    ?>

<script>/* eslint-disable */
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', '<?= $this->ua ?>', 'auto');
  ga('send', 'pageview');

</script>

    <?php
    }
}
