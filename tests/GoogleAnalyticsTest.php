<?php

namespace ideasonpurpose;

use PHPUnit\Framework\TestCase;

require_once(realpath(__DIR__ . '/../GoogleAnalytics.php'));
require_once('GoogleAnalyticsMocks.php');

// define('WP_DEBUG', true);

class GoogleAnalyticsGeneralTest extends TestCase
{
    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWP_DEBUGTrue()
    {
        define('WP_DEBUG', true);
        $this->assertTrue(WP_DEBUG);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testWP_DEBUGFalse()
    {
        define('WP_DEBUG', false);
        $this->assertFalse(WP_DEBUG);
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMockUserIsLoggedIn()
    {
        global $logged_in;

        $logged_in = true;
        $this->assertTrue(is_user_logged_in());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMockUserIsLoggedOut()
    {
        global $logged_in;

        $logged_in = false;
        $this->assertFalse(is_user_logged_in());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testInjectGA()
    {
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $this->expectOutputRegex('/function\(i,s,o,g,r,a,m\)\{i\[\'GoogleAnalyticsObject/');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testInjectGAFallback()
    {
        define('WP_DEBUG', true);
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $this->expectOutputRegex('/UA-fallback/');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testInjectGAPrimary()
    {
        global $logged_in;
        $logged_in = false;
        define('WP_DEBUG', false);
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $this->expectOutputRegex('/UA-primary/');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testNoInject()
    {
        global $logged_in;
        $logged_in = true;
        define('WP_DEBUG', false);
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $this->expectOutputString('');
    }
}

