<?php

namespace FM\PlatformBundle\Migrations\Schema\v1_6;

use Doctrine\DBAL\Schema\Schema;

use Doctrine\DBAL\Schema\SchemaException;
use FM\PlatformBundle\Migrations\Schema\Table;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class OtherChange implements Migration
{
    /**
     * {@inheritdoc}
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable(Table::RESOURCE);
        $table->addColumn('quote_direct', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('quote_repost', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('cost_direct', 'decimal', ['precision' => 10, 'scale' => 2]);
        $table->addColumn('cost_repost', 'decimal', ['precision' => 10, 'scale' => 2]);
    }
}
