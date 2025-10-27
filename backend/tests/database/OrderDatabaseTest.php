<?php

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Test\DatabaseTestTrait;
use App\Models\OrderModel;

/**
 * @internal
 */
final class OrderDatabaseTest extends CIUnitTestCase
{
    use DatabaseTestTrait;

    protected $migrate     = true;
    protected $migrateOnce = true;
    protected $refresh     = true;
    protected $namespace   = null; // use App migrations

    public function testCreateAndProgressOrder(): void
    {
        $model = new OrderModel();
        $id = $model->insert([
            'customer_name' => 'Test Customer',
            'items' => '2x Milk Tea',
            'status' => 'pending',
            'total' => '199.00',
        ], true);

        $this->assertNotFalse($id, 'Insert should succeed');
        $order = $model->find($model->getInsertID());
        $this->assertSame('pending', $order['status']);

        $this->assertTrue($model->update($order['id'], ['status' => 'brewing']));
        $order = $model->find($order['id']);
        $this->assertSame('brewing', $order['status']);
    }
}
