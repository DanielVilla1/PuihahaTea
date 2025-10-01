<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\FeatureTestTrait;

/**
 * @internal
 */
final class ServicesPageTest extends CIUnitTestCase
{
    use FeatureTestTrait;

    public function testServicesPageRendersGallery(): void
    {
        $result = $this->get('/services');
        $result->assertStatus(200);
        $result->assertSee('Our Services');
        $result->assertSee('Product Gallery');
        $result->assertSee('Mango Breeze Oolong');
    }
}
