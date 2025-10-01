<?php

use CodeIgniter\Test\FeatureTestTrait;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * @internal
 */
final class HomePageTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testHomeRendersPuihahaTeaBrand(): void
    {
        $result = $this->get('/');
        $result->assertStatus(200);
        $result->assertSee('PuihahaTea');
        $result->assertSee('Home');
        $result->assertSee('Services');
        $result->assertSee('About');
        $result->assertSee('Contact');
    }
}
