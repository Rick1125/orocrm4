<?php

namespace FM\PlatformBundle\Migrations\Schema\v1_6;

use Doctrine\DBAL\Schema\Schema;

use Doctrine\DBAL\Schema\SchemaException;
use FM\PlatformBundle\Migrations\Schema\Table;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class AddFollowerToResource implements Migration
{
    /**
     * {@inheritdoc}
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable(Table::RESOURCE);
        $table->addColumn('follower', 'decimal', [
            'scale' => 2,
            'precision' => 7,
            'options' => ['default' => 0.0, 'nullable' => true]
        ]);
    }
}
