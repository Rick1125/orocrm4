<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/1/21
 * Time: 22:26
 */

namespace FM\Bundle\ProjectBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use FM\Bundle\ProjectBundle\Entity\Project;
use FM\Bundle\ResourceBundle\Migrations\Schema\FMResourceBundle;
use Oro\Bundle\EntityConfigBundle\Migration\UpdateEntityConfigEntityValueQuery;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class FMProjectBundle implements Installation
{
    const TABLE = 'fm_project';
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
        $this->createFmProjectTable($schema);
        $this->createFmProjectHasResourcesTable($schema);

        /** Foreign keys generation **/
        $this->addFmProjectForeignKeys($schema);
        $this->addFmProjectHasResourcesForeignKeys($schema);

        $queries->addQuery(
            new UpdateEntityConfigEntityValueQuery(
                Project::class,
                'security',
                'field_acl_supported',
                true
            )
        );
    }

    /**
     * Create fm_project table
     *
     * @param Schema $schema
     */
    protected function createFmProjectTable(Schema $schema)
    {
        if ($schema->hasTable(self::TABLE)) {
            return;
        }
        $table = $schema->createTable(self::TABLE);
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

    /**
     * Create fm_project_has_resources table
     *
     * @param Schema $schema
     */
    protected function createFmProjectHasResourcesTable(Schema $schema)
    {
        if ($schema->hasTable('fm_project_has_resources')) {
            return;
        }
        $table = $schema->createTable('fm_project_has_resources');
        $table->addColumn('project_id', 'integer', []);
        $table->addColumn('resource_id', 'integer', []);
        $table->setPrimaryKey(['project_id', 'resource_id']);
        $table->addIndex(['project_id'], 'IDX_B33ADBDC166D1F9C', []);
        $table->addIndex(['resource_id'], 'IDX_B33ADBDC89329D25', []);
    }

    /**
     * Add fm_project foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmProjectForeignKeys(Schema $schema)
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
                $schema->getTable(self::TABLE),
                ['project_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(FMResourceBundle::TABLE_RESOURCE),
                ['resource_id'],
                ['id'],
                ['onDelete' => 'CASCADE', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }
}
