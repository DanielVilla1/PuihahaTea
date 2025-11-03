<?php

namespace App\Commands;

use App\Models\CustomerModel;
use CodeIgniter\CLI\CLI;
use CodeIgniter\CLI\BaseCommand;

class CleanPendingCustomers extends BaseCommand
{
    protected $group       = 'Maintenance';
    protected $name        = 'customers:clean-pending';
    protected $description = 'Delete pending (unverified) customer accounts older than the configured number of days.';

    public function run(array $params)
    {
        $days = (int) (getenv('CUSTOMERS_PENDING_EXPIRY_DAYS') ?: 7);
        if ($days < 1) {
            $days = 7;
        }

        $threshold = date('Y-m-d H:i:s', strtotime('-' . $days . ' days'));

        $model = new CustomerModel();
        $builder = $model->where('verified_at', null)
            ->where('token_sent_at <', $threshold);

        // Count first for reporting
        $count = (int) $builder->countAllResults(false); // keep builder state

        $ok = $builder->delete(null, false); // no soft deletes

        if ($ok) {
            CLI::write("Removed {$count} pending customer(s) older than {$days} day(s).", 'green');
        } else {
            CLI::write('No pending customers removed or operation failed.', 'yellow');
        }
    }
}
