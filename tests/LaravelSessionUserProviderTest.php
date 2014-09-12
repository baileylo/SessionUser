<?php

namespace Portico\SessionUser\Test;

use Portico\SessionUser\LaravelSessionUserProvider;

class LaravelSessionUserProviderTest extends \PHPUnit_Framework_TestCase
{
    /** @var App */
    protected $app;

    /** @var LaravelSessionUserProvider */
    protected $provider;

    /** @var PHPUnit_Framework_MockObject_MockObject */
    protected $auth;

    public function setUp()
    {
        $this->app = new App;
        $this->auth = $this->getMock('stdClass', ['user']);

        $this->app->bind('auth', function(){
            return $this->auth;
        });

        $this->provider = new LaravelSessionUserProvider($this->app);
    }


    public function testProviderBindsInstanceOfSessionUser()
    {
        $this->provider->register();
        $this->assertTrue($this->app->has('Portico\SessionUser\SessionUser'));
    }

    /**
     * @expectedException \Portico\SessionUser\NoAuthenticatedSessionUserException
     */
    public function testNoAuthenticatedSessionUserExceptionIsThrownIfNoUserIsLoggedIn()
    {
        $this->auth->expects($this->once())
            ->method('user')
            ->willReturn(false);

        $this->provider->register();

        $this->app->make('Portico\SessionUser\SessionUser');
    }

    public function testResultFromAuthUserIsReturnedWhenUserIsLoggedIn()
    {
        $expected = new \stdClass();
        $this->auth->expects($this->exactly(2))
            ->method('user')
            ->willReturn($expected);

        $this->provider->register();

        $this->assertSame($expected, $this->app->make('Portico\SessionUser\SessionUser'));
    }

    public function testProviderIsDeferred()
    {
        $this->assertTrue($this->provider->isDeferred());
    }

    public function testProviderProvidesSessionUser()
    {
        $this->assertContains('Portico\SessionUser\SessionUser', $this->provider->provides());
    }
} 