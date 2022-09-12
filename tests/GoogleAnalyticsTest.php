<?php

namespace IdeasOnPurpose\WP;

use PHPUnit\Framework\TestCase;
use IdeasOnPurpose\WP\Test;

Test\Stubs::init();

/**
 * @covers \IdeasOnPurpose\WP\GoogleAnalytics
 */
class GoogleAnalyticsGeneralTest extends TestCase
{
    public function setUp(): void
    {
        $this->primary = 'UA-123456';
        $this->primaryGA4 = 'G-456XYZ';
        $this->primaryIDs = [$this->primary, $this->primaryGA4];
        $this->fallback = 'UA-987654';
        $this->fallbackGA4 = 'G-789JKL';
        $this->fallbackIDs = [$this->fallback, $this->fallbackGA4];
    }

    public function testInjectGA()
    {
        $ga = new GoogleAnalytics('UA-primary', 'UA-fallback');
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/gtag.js/');
        $output = $this->getActualOutput();
        $this->assertStringContainsString('<!-- Google tag (gtag.js) -->', $output);
    }

    public function testInjectGAFallback()
    {
        $ga = new GoogleAnalytics($this->primary, $this->fallback);
        $ga->is_debug = true;
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/gtag.js/');
        $output = $this->getActualOutput();
        $this->assertStringContainsString($this->fallback, $output);
    }

    public function testInjectGAPrimary()
    {
        $ga = new GoogleAnalytics($this->primary, $this->fallback);
        $ga->is_debug = false;
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/gtag.js/');
        $output = $this->getActualOutput();
        $this->assertStringContainsString($this->primary, $output);
    }

    public function testNoInject()
    {
        global $is_user_logged_in;
        $is_user_logged_in = true;
        $ga = new GoogleAnalytics($this->primary, $this->fallback);
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/<!-- User .* suppressed. -->/');
    }

    public function testArrayOfIDs()
    {
        global $is_user_logged_in;
        $is_user_logged_in = false;
        $ga = new GoogleAnalytics($this->primaryIDs, $this->fallback);
        $ga->is_debug = false;
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/gtag.js/');
        $output = $this->getActualOutput();
        $this->assertStringContainsString($this->primary, $output);
        $this->assertStringContainsString($this->primaryGA4, $output);
    }

    public function testFallbackArrayOfIDs()
    {
        global $is_user_logged_in;
        $is_user_logged_in = false;
        $ga = new GoogleAnalytics($this->primary, $this->fallbackIDs);
        $ga->is_debug = true;
        $ga->injectGoogleAnalytics();
        $this->expectOutputRegex('/gtag.js/');
        $output = $this->getActualOutput();
        $this->assertStringContainsString($this->fallback, $output);
        $this->assertStringContainsString($this->fallbackGA4, $output);
    }

    public function testWithMock()
    {
        global $is_user_logged_in;

        /** @var \IdeasOnPurpose\WP\GoogleAnalytics $GA */
        $GA = $this->getMockBuilder('\IdeasOnPurpose\WP\GoogleAnalytics')
            ->disableOriginalConstructor()
            ->addMethods([])
            ->getMock();

        $is_user_logged_in = false;

        $GA->ga_ua = $this->primary;
        $GA->fallback_ua = $this->fallback;
        $GA->is_debug = false;
        $GA->injectGoogleAnalytics();

        $expected = $this->primary;
        $actual = $this->getActualOutput();
        $this->expectOutputRegex('/gtag.js/');

        $this->assertStringContainsString($expected, $actual);
    }
}
