<?php

namespace FM\PlatformBundle\Migrations\Schema\v1_7;

use Doctrine\DBAL\Schema\Schema;

use Doctrine\DBAL\Schema\SchemaException;
use FM\PlatformBundle\Migrations\Schema\Table;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class RemovePriceOfResource implements Migration
{
    /**
     * {@inheritdoc}
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable(Table::RESOURCE);
        $table->dropColumn('price');
        $table->dropColumn('price_a');
        $table->dropColumn('price_b');
    }
}
