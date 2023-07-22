<?php

namespace IdeasOnPurpose\WP;

use PHPUnit\Framework\TestCase;
use IdeasOnPurpose\WP\Test;

Test\Stubs::init();

/**
 * @covers \IdeasOnPurpose\WP\GoogleAnalytics
 */
class GoogleAnalyticsTest extends TestCase
{
    public $primary = 'UA-123456';
    public $primaryGA4 = 'G-456XYZ';

    public $fallback = 'UA-987654';
    public $fallbackGA4 = 'G-789JKL';

    public $primaryIDs;
    public $fallbackIDs;

    public function setUp(): void
    {
        $this->primaryIDs = [$this->primary, $this->primaryGA4];
        $this->fallbackIDs = [$this->fallback, $this->fallbackGA4];
    }

    public function testInjectGAPrimary()
    {
        global $is_user_logged_in;
        $is_user_logged_in = false;
        $ga = new GoogleAnalytics($this->primary, $this->fallback);
        $ga->is_debug = false;
        ob_start();
        $ga->injectGoogleAnalytics();
        $actual = ob_get_clean();
        $this->assertStringContainsString('gtag.js', $actual);
        $this->assertStringContainsString($this->primary, $actual);
    }

    public function testInjectGAFallback()
    {
        $ga = new GoogleAnalytics($this->primary, $this->fallback);
        $ga->is_debug = true;
        ob_start();
        $ga->injectGoogleAnalytics();
        $actual = ob_get_clean();
        $this->assertStringContainsString('gtag.js', $actual);
        $this->assertStringContainsString($this->fallback, $actual);
    }

    public function testNoInject()
    {
        global $is_user_logged_in;
        $is_user_logged_in = true;
        $ga = new GoogleAnalytics($this->primary, $this->fallback);
        ob_start();
        $ga->injectGoogleAnalytics();
        $actual = ob_get_clean();
        $this->assertMatchesRegularExpression('/<!-- User .* suppressed. -->/', $actual);
        $this->assertStringNotContainsString('gtag.js', $actual);
    }

    public function testArrayOfIDs()
    {
        global $is_user_logged_in;
        $is_user_logged_in = false;
        $ga = new GoogleAnalytics($this->primaryIDs, $this->fallback);
        $ga->is_debug = false;
        ob_start();
        $ga->injectGoogleAnalytics();
        $actual = ob_get_clean();
        $this->assertStringContainsString('gtag.js', $actual);
        $this->assertStringContainsString($this->primary, $actual);
        $this->assertStringContainsString($this->primaryGA4, $actual);
    }

    public function testFallbackArrayOfIDs()
    {
        global $is_user_logged_in;
        $is_user_logged_in = false;
        $ga = new GoogleAnalytics($this->primary, $this->fallbackIDs);
        $ga->is_debug = true;
        ob_start();
        $ga->injectGoogleAnalytics();
        $actual = ob_get_clean();
        $this->assertStringContainsString('gtag.js', $actual);
        $this->assertStringContainsString($this->fallback, $actual);
        $this->assertStringContainsString($this->fallbackGA4, $actual);
    }
}
