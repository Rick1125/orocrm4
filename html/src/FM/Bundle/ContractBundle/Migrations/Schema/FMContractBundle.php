<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/1/21
 * Time: 22:26
 */

namespace FM\Bundle\ContractBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use FM\Bundle\ContractBundle\Entity\Contract;
use FM\Bundle\ProjectBundle\Migrations\Schema\FMProjectBundle;
use Oro\Bundle\EntityConfigBundle\Migration\UpdateEntityConfigEntityValueQuery;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class FMContractBundle implements Installation, OrderedMigrationInterface
{
    const TABLE = 'fm_contract';
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * @inheritdoc
     */
    public function getOrder()
    {
        return 20;
    }

    /**
     * {@inheritdoc}
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $this->createFmContractTable($schema);
        $this->createFmContractHasProjectsTable($schema);

        $this->addFmContractForeignKeys($schema);
        $this->addFmContractHasProjectsForeignKeys($schema);

        $queries->addQuery(
            new UpdateEntityConfigEntityValueQuery(
                Contract::class,
                'security',
                'field_acl_supported',
                true
            )
        );
    }

    /**
     * Create fm_contract table
     *
     * @param Schema $schema
     */
    protected function createFmContractTable(Schema $schema)
    {
        if ($schema->hastable(self::TABLE)) {
            return;
        }
        $table = $schema->createTable(self::TABLE);
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('assigned_to_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('status', 'string', ['length' => 15]);
        $table->addColumn('description', 'text', []);
        $table->addColumn('amount', 'decimal', ['scale' => 2]);
        $table->addColumn('launched_at', 'datetime', []);
        $table->addColumn('expired_at', 'datetime', []);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addIndex(['assigned_to_user_id'], 'IDX_D6B91BC011578D11', []);
        $table->addIndex(['organization_id'], 'IDX_D6B91BC032C8A3DE', []);
        $table->addIndex(['user_owner_id'], 'IDX_D6B91BC059294170', []);
        $table->addIndex(['created_by_user_id'], 'IDX_D6B91BC07D182D95', []);
        $table->addIndex(['updated_by_user_id'], 'IDX_D6B91BC02793CC5E', []);
    }

    /**
     * Create fm_contract_has_projects table
     *
     * @param Schema $schema
     */
    protected function createFmContractHasProjectsTable(Schema $schema)
    {
        if ($schema->hasTable('fm_contract_has_projects')) {
            return;
        }
        $table = $schema->createTable('fm_contract_has_projects');
        $table->addColumn('contract_id', 'integer', []);
        $table->addColumn('project_id', 'integer', []);
        $table->setPrimaryKey(['contract_id', 'project_id']);
        $table->addIndex(['contract_id'], 'IDX_10A697F2576E0FD', []);
        $table->addIndex(['project_id'], 'IDX_10A697F166D1F9C', []);
    }

    /**
     * Add fm_contract foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmContractForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::TABLE);
        try {
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_user'),
                ['assigned_to_user_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_user'),
                ['updated_by_user_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_organization'),
                ['organization_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_user'),
                ['user_owner_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_user'),
                ['created_by_user_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }

    /**
     * Add fm_contract_has_projects foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmContractHasProjectsForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('fm_contract_has_projects');
        try {
            $table->addForeignKeyConstraint(
                $schema->getTable(FMProjectBundle::TABLE),
                ['project_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(self::TABLE),
                ['contract_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }
}
