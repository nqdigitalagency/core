<?php

/*
 * This file is part of Flarum.
 *
 * (c) Toby Zerner <toby.zerner@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Flarum\Tests\unit\Install;

use Flarum\Install\BaseUrl;
use Flarum\Tests\unit\TestCase;
use Zend\Diactoros\Uri;

class BaseUrlTest extends TestCase
{
    /**
     * @dataProvider urlProvider
     */
    public function test_base_url_simulating_cli_installer($uri, $expected)
    {
        $this->assertEquals($expected, BaseUrl::fromString($uri));
    }

    /**
     * @dataProvider urlProvider
     */
    public function test_base_url_simulating_web_installer($uri, $expected)
    {
        $uri = new Uri($uri);

        $this->assertEquals($expected, BaseUrl::fromUri($uri));
    }

    /**
     * @dataProvider emailProvider
     */
    public function test_default_email_generation($uri, $expected)
    {
        $this->assertEquals(
            $expected,
            BaseUrl::fromString($uri)->toEmail('noreply')
        );
    }

    public function urlProvider()
    {
        return [
            ['',                                    ''],
            ['flarum.org',                          'http://flarum.org'],
            ['flarum.org/',                         'http://flarum.org'],
            ['http://flarum.org',                   'http://flarum.org'],
            ['http://flarum.org/',                  'http://flarum.org'],
            ['https://flarum.org',                  'https://flarum.org'],
            ['http://flarum.org/index.php',         'http://flarum.org'],
            ['http://flarum.org/index.php/',        'http://flarum.org'],
            ['http://flarum.org/flarum',            'http://flarum.org/flarum'],
            ['http://flarum.org/flarum/index.php',  'http://flarum.org/flarum'],
            ['http://flarum.org/flarum/index.php/', 'http://flarum.org/flarum'],
            ['sub.flarum.org',                      'http://sub.flarum.org'],
            ['http://sub.flarum.org',               'http://sub.flarum.org'],
        ];
    }

    public function emailProvider()
    {
        return [
            ['flarum.org',                          'noreply@flarum.org'],
            ['flarum.org/',                         'noreply@flarum.org'],
            ['http://flarum.org',                   'noreply@flarum.org'],
            ['http://flarum.org/',                  'noreply@flarum.org'],
            ['https://flarum.org',                  'noreply@flarum.org'],
            ['http://flarum.org/index.php',         'noreply@flarum.org'],
            ['http://flarum.org/index.php/',        'noreply@flarum.org'],
            ['http://flarum.org/flarum',            'noreply@flarum.org'],
            ['http://flarum.org/flarum/index.php',  'noreply@flarum.org'],
            ['http://flarum.org/flarum/index.php/', 'noreply@flarum.org'],
            ['sub.flarum.org',                      'noreply@sub.flarum.org'],
            ['http://sub.flarum.org',               'noreply@sub.flarum.org'],
        ];
    }
}
