<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/3/2
 * Time: 01:14
 */
namespace FM\PlatformBundle\Migrations\Schema\v1_2;

use Doctrine\DBAL\Schema\Schema;
use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;
use FM\PlatformBundle\Migrations\Schema\Table;

class AddChannelToResource implements Migration
{
    /**
     * @param Schema $schema
     * @param QueryBag $queries
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $table = $schema->getTable(Table::RESOURCE);
        $table->addColumn('channel_name', 'string', ['length' => 255, 'options' => ['default' => '']]);
        $table->addColumn('is_person', 'boolean', ['options' => ['default' => true]]);
    }
}
