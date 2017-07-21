<?php

namespace ideasonpurpose;

use TestCase;
use Mockery;
use Brain\Monkey\Functions;
use Brain\Monkey\Actions;

class GoogleAnalyticsGeneralTest extends TestCase
{

    protected function setUp()
    {
        // $user = (object) ['user_login' => 'bobby'];  // doesn't work with hhvm?
        $user = new \stdClass();
        $user->user_login = 'bobby';
        Functions\when('is_user_logged_in')->justReturn(false);
        Functions\when('wp_get_current_user')->justReturn($user);
        parent::setUp();
    }

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
        Functions\when('is_user_logged_in')->justReturn(true);
        $this->assertTrue(is_user_logged_in());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testMockUserIsLoggedOut()
    {
        $this->assertFalse(is_user_logged_in());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testInjectGA()
    {
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $ga->injectGoogleAnalytics();
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
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/UA-fallback/');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testInjectGAPrimary()
    {
        define('WP_DEBUG', false);
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/UA-primary/');
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testNoInject()
    {
        define('WP_DEBUG', false);
        Functions\when('is_user_logged_in')->justReturn(true);
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/<!-- User .* suppressed. -->/');
    }
}
