<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/1/21
 * Time: 22:26
 */

namespace FM\PlatformBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use FM\PlatformBundle\Entity\Resource;
use Oro\Bundle\EntityConfigBundle\Migration\UpdateEntityConfigEntityValueQuery;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class FMPlatformBundle implements Installation
{
    /**
     * {@inheritdoc}
     */
    public function getMigrationVersion()
    {
        return 'v1_0';
    }

    /**
     * {@inheritdoc}
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createFmChannelTable($schema);
        $this->createFmContractTable($schema);
        $this->createFmContractHasProjectsTable($schema);
        $this->createFmPlatformTable($schema);
        $this->createFmProjectTable($schema);
        $this->createFmProjectHasResourcesTable($schema);
        $this->createFmResourceTable($schema);
        $this->createFmResourceResultTable($schema);

        /** Foreign keys generation **/
        $this->addFmContractForeignKeys($schema);
        $this->addFmContractHasProjectsForeignKeys($schema);
        $this->addFmProjectForeignKeys($schema);
        $this->addFmProjectHasResourcesForeignKeys($schema);
        $this->addFmResourceForeignKeys($schema);
        $this->addFmResourceResultForeignKeys($schema);

        $queries->addQuery(
            new UpdateEntityConfigEntityValueQuery(
                Resource::class,
                'security',
                'field_acl_supported',
                true
            )
        );
    }

    /**
     * Create fm_channel table
     *
     * @param Schema $schema
     */
    protected function createFmChannelTable(Schema $schema)
    {
        try {
            $table = $schema->getTable(Table::CHANNEL);
        } catch (SchemaException $e) {
            $table = $schema->createTable(Table::CHANNEL);
        }
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('is_person', 'boolean', ['default' => true]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['name'], 'UNIQ_21CCCAE15E237E06');
    }

    /**
     * Create fm_contract table
     *
     * @param Schema $schema
     */
    protected function createFmContractTable(Schema $schema)
    {
        try {
            $table = $schema->getTable(Table::CONTRACT);
        } catch (SchemaException $e) {
            $table = $schema->createTable(Table::CONTRACT);
        }
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('assigned_to_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('updated_by_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
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
        $table->addIndex(['business_unit_owner_id'], 'IDX_D6B91BC059294170', []);
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
        try {
            $schema->getTable('fm_contract_has_projects');
        } catch (SchemaException $e) {
            $table = $schema->createTable('fm_contract_has_projects');
            $table->addColumn('contract_id', 'integer', []);
            $table->addColumn('project_id', 'integer', []);
            $table->setPrimaryKey(['contract_id', 'project_id']);
            $table->addIndex(['contract_id'], 'IDX_10A697F2576E0FD', []);
            $table->addIndex(['project_id'], 'IDX_10A697F166D1F9C', []);
        }
    }

    /**
     * Create fm_platform table
     *
     * @param Schema $schema
     */
    protected function createFmPlatformTable(Schema $schema)
    {
        try {
            $schema->getTable(Table::PLATFORM);
        } catch (SchemaException $e) {
            $table = $schema->createTable(Table::PLATFORM);
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('name', 'string', ['length' => 255]);
            $table->addColumn('match_rule', 'string', ['length' => 255]);
            $table->addColumn('created_at', 'datetime', []);
            $table->addColumn('updated_at', 'datetime', []);
            $table->setPrimaryKey(['id']);
        }
    }

    /**
     * Create fm_project table
     *
     * @param Schema $schema
     */
    protected function createFmProjectTable(Schema $schema)
    {
        try {
            $schema->getTable(Table::PROJECT);
        } catch (SchemaException $e) {
            $table = $schema->createTable(Table::PROJECT);
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('assigned_to_user_id', 'integer', ['notnull' => false]);
            $table->addColumn('updated_by_user_id', 'integer', ['notnull' => false]);
            $table->addColumn('organization_id', 'integer', ['notnull' => false]);
            $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
            $table->addColumn('created_by_user_id', 'integer', ['notnull' => false]);
            $table->addColumn('name', 'string', ['length' => 255]);
            $table->addColumn('description', 'text', ['notnull' => false]);
            $table->addColumn('status', 'string', ['length' => 15]);
            $table->addColumn('quote', 'decimal', ['scale' => 2]);
            $table->addColumn('budget', 'decimal', ['scale' => 2]);
            $table->addColumn('profit_rate', 'decimal', ['precision' => 6, 'scale' => 2]);
            $table->addColumn('launched_at', 'datetime', []);
            $table->addColumn('expired_at', 'datetime', ['notnull' => false]);
            $table->addColumn('created_at', 'datetime', []);
            $table->addColumn('updated_at', 'datetime', []);
            $table->setPrimaryKey(['id']);
            $table->addIndex(['assigned_to_user_id'], 'IDX_AC86944811578D11', []);
            $table->addIndex(['organization_id'], 'IDX_AC86944832C8A3DE', []);
            $table->addIndex(['business_unit_owner_id'], 'IDX_AC86944859294170', []);
            $table->addIndex(['created_by_user_id'], 'IDX_AC8694487D182D95', []);
            $table->addIndex(['updated_by_user_id'], 'IDX_AC8694482793CC5E', []);
        }
    }

    /**
     * Create fm_project_has_resources table
     *
     * @param Schema $schema
     */
    protected function createFmProjectHasResourcesTable(Schema $schema)
    {
        try {
            $schema->getTable('fm_project_has_resources');
        } catch (SchemaException $e) {
            $table = $schema->createTable('fm_project_has_resources');
            $table->addColumn('project_id', 'integer', []);
            $table->addColumn('resource_id', 'integer', []);
            $table->setPrimaryKey(['project_id', 'resource_id']);
            $table->addIndex(['project_id'], 'IDX_B33ADBDC166D1F9C', []);
            $table->addIndex(['resource_id'], 'IDX_B33ADBDC89329D25', []);
        }
    }

    /**
     * Create fm_resource table
     *
     * @param Schema $schema
     */
    protected function createFmResourceTable(Schema $schema)
    {
        try {
            $schema->getTable(Table::RESOURCE);
        } catch (SchemaException $e) {
            $table = $schema->createTable(Table::RESOURCE);
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('updated_by_user_id', 'integer', ['notnull' => false]);
            $table->addColumn('organization_id', 'integer', ['notnull' => false]);
            $table->addColumn('business_unit_owner_id', 'integer', ['notnull' => false]);
            $table->addColumn('channel_id', 'integer', ['notnull' => false]);
            $table->addColumn('created_by_user_id', 'integer', ['notnull' => false]);
            $table->addColumn('platform_id', 'integer', ['notnull' => false]);
            $table->addColumn('name', 'string', ['length' => 255]);
            $table->addColumn('channel_name', 'string', ['length' => 255, 'default' => '']);
            $table->addColumn('nickname', 'string', ['notnull' => false, 'length' => 255]);
            $table->addColumn('status', 'string', ['length' => 15]);
            $table->addColumn('link', 'string', ['length' => 1024]);
            $table->addColumn('link_hash', 'string', ['length' => 32]);
            $table->addColumn('is_person', 'boolean', ['default' => true]);
            $table->addColumn('score', 'decimal', ['scale' => 2]);
            $table->addColumn('quote_direct', 'decimal', ['scale' => 2]);
            $table->addColumn('quote_repost', 'decimal', ['scale' => 2]);
            $table->addColumn('cost_direct', 'decimal', ['scale' => 2]);
            $table->addColumn('cost_repost', 'decimal', ['scale' => 2]);
            $table->addColumn('discount', 'decimal', ['scale' => 2, 'default' => 1.0]);
            $table->addColumn('follower', 'decimal', ['scale' => 2, 'default' => 0, 'nullable' => true]);
            $table->addColumn('memo', 'string', ['notnull' => false, 'length' => 1024]);
            $table->addColumn('created_at', 'datetime', []);
            $table->addColumn('updated_at', 'datetime', []);
            $table->setPrimaryKey(['id']);
            $table->addUniqueIndex(['link_hash'], 'UNIQ_83A7C78F60FFF011');
            $table->addIndex(['platform_id'], 'IDX_83A7C78FFFE6496F', []);
            $table->addIndex(['channel_id'], 'IDX_83A7C78F72F5A1AA', []);
            $table->addIndex(['organization_id'], 'IDX_83A7C78F32C8A3DE', []);
            $table->addIndex(['business_unit_owner_id'], 'IDX_83A7C78F59294170', []);
            $table->addIndex(['created_by_user_id'], 'IDX_83A7C78F7D182D95', []);
            $table->addIndex(['updated_by_user_id'], 'IDX_83A7C78F2793CC5E', []);
        }
    }

    /**
     * Create fm_resource_result table
     *
     * @param Schema $schema
     */
    protected function createFmResourceResultTable(Schema $schema)
    {
        try {
            $schema->getTable(Table::RESULT);
        } catch (SchemaException $e) {
            $table = $schema->createTable(Table::RESULT);
            $table->addColumn('id', 'integer', ['autoincrement' => true]);
            $table->addColumn('resource_id', 'integer', ['notnull' => false]);
            $table->addColumn('link', 'string', ['length' => 1024]);
            $table->addColumn('price', 'decimal', ['scale' => 2]);
            $table->addColumn('created_at', 'datetime', []);
            $table->addColumn('updated_at', 'datetime', []);
            $table->setPrimaryKey(['id']);
//            $table->addUniqueIndex(['link'], 'UNIQ_A501C8D436AC99F1');
            $table->addIndex(['resource_id'], 'IDX_A501C8D489329D25', []);
        }
    }

    /**
     * Add fm_contract foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmContractForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(Table::CONTRACT);
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
                $schema->getTable('oro_business_unit'),
                ['business_unit_owner_id'],
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
                $schema->getTable(Table::PROJECT),
                ['project_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(Table::CONTRACT),
                ['contract_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }

    /**
     * Add fm_project foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmProjectForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(Table::PROJECT);
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
                $schema->getTable('oro_business_unit'),
                ['business_unit_owner_id'],
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
     * Add fm_project_has_resources foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmProjectHasResourcesForeignKeys(Schema $schema)
    {
        $table = $schema->getTable('fm_project_has_resources');
        try {
            $table->addForeignKeyConstraint(
                $schema->getTable(Table::PROJECT),
                ['project_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(Table::RESOURCE),
                ['resource_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }

    /**
     * Add fm_resource foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmResourceForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(Table::RESOURCE);
        try {
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
                $schema->getTable('oro_business_unit'),
                ['business_unit_owner_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(Table::CHANNEL),
                ['channel_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable('oro_user'),
                ['created_by_user_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(Table::PLATFORM),
                ['platform_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }

    /**
     * Add fm_resource_result foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmResourceResultForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(Table::RESULT);
        try {
            $table->addForeignKeyConstraint(
                $schema->getTable(Table::RESOURCE),
                ['resource_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }
}
