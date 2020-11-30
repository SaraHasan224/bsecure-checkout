<?php

namespace Tests\Unit;

use bSecure\UniversalCheckout\SSOServiceProvider;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [SSOServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
          'BsecureSSO' => 'bSecure\UniversalCheckout\SSOFacade'
        ];
    }

    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
