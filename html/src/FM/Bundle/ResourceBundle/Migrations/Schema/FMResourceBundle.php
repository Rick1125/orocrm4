<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2018/1/21
 * Time: 22:26
 */

namespace FM\Bundle\ResourceBundle\Migrations\Schema;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\SchemaException;
use FM\Bundle\ResourceBundle\Entity\Resource;
use Oro\Bundle\EntityConfigBundle\Migration\UpdateEntityConfigEntityValueQuery;
use Oro\Bundle\MigrationBundle\Migration\Installation;
use Oro\Bundle\MigrationBundle\Migration\OrderedMigrationInterface;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

/**
 * @SuppressWarnings(PHPMD.TooManyMethods)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 */
class FMResourceBundle implements Installation, OrderedMigrationInterface
{
    const TABLE_RESOURCE = 'fm_resource';
    const TABLE_CHANNEL = 'fm_channel';
    const TABLE_PLATFORM = 'fm_platform';
    const TABLE_RESULT = 'fm_result';
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
        return 1;
    }

    /**
     * {@inheritdoc}
     * @throws SchemaException
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        /** Tables generation **/
        $this->createFmChannelTable($schema);
        $this->createFmPlatformTable($schema);
        $this->createFmResourceTable($schema);
        $this->createFmResourceResultTable($schema);

        /** Foreign keys generation **/
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
            $table = $schema->getTable(self::TABLE_CHANNEL);
        } catch (SchemaException $e) {
            $table = $schema->createTable(self::TABLE_CHANNEL);
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
     * Create fm_platform table
     *
     * @param Schema $schema
     */
    protected function createFmPlatformTable(Schema $schema)
    {
        if ($schema->hasTable(self::TABLE_PLATFORM)) {
            return;
        }
        $table = $schema->createTable(self::TABLE_PLATFORM);
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('match_rule', 'string', ['length' => 255]);
        $table->addColumn('created_at', 'datetime', []);
        $table->addColumn('updated_at', 'datetime', []);
        $table->setPrimaryKey(['id']);
    }

    /**
     * Create fm_resource table
     *
     * @param Schema $schema
     */
    protected function createFmResourceTable(Schema $schema)
    {
        if ($schema->hasTable(self::TABLE_RESOURCE)) {
            return;
        }
        $table = $schema->createTable(self::TABLE_RESOURCE);
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('updated_by_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('organization_id', 'integer', ['notnull' => false]);
        $table->addColumn('user_owner_id', 'integer', ['notnull' => false]);
        $table->addColumn('channel_id', 'integer', ['notnull' => false]);
        $table->addColumn('created_by_user_id', 'integer', ['notnull' => false]);
        $table->addColumn('platform_id', 'integer', ['notnull' => false]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('channel_name', 'string', ['length' => 255, 'default' => '']);
        $table->addColumn('contact_name', 'string', ['notnull' => false, 'length' => 255]);
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
        $table->addIndex(['user_owner_id'], 'IDX_83A7C78F59294170', []);
        $table->addIndex(['created_by_user_id'], 'IDX_83A7C78F7D182D95', []);
        $table->addIndex(['updated_by_user_id'], 'IDX_83A7C78F2793CC5E', []);
    }

    /**
     * Create fm_resource_result table
     *
     * @param Schema $schema
     */
    protected function createFmResourceResultTable(Schema $schema)
    {
        if ($schema->hasTable(self::TABLE_RESULT)) {
            return;
        }
        $table = $schema->createTable(self::TABLE_RESULT);
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

    /**
     * Add fm_resource foreign keys.
     *
     * @param Schema $schema
     * @throws SchemaException
     */
    protected function addFmResourceForeignKeys(Schema $schema)
    {
        $table = $schema->getTable(self::TABLE_RESOURCE);
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
                $schema->getTable('oro_user'),
                ['user_owner_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
            $table->addForeignKeyConstraint(
                $schema->getTable(self::TABLE_CHANNEL),
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
                $schema->getTable(self::TABLE_PLATFORM),
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
        $table = $schema->getTable(self::TABLE_RESULT);
        try {
            $table->addForeignKeyConstraint(
                $schema->getTable(self::TABLE_RESULT),
                ['resource_id'],
                ['id'],
                ['onDelete' => 'SET NULL', 'onUpdate' => null]
            );
        } catch (SchemaException $e) {/* do nothing */}
    }
}
