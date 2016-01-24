<?php
namespace PhinxFix\Db\Adapter;

use Phinx\Db\Adapter\PostgresAdapter;

class PdoPostgresAdapter extends PostgresAdapter
{

    /**
     * {@inheritdoc}
     */
    public function connect()
    {
        parent::connect();
        $this->fetchAll(sprintf('SET search_path TO %s', $this->getOption('schema')));
    }
}