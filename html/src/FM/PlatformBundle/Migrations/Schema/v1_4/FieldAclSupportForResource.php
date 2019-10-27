<?php

namespace FM\PlatformBundle\Migrations\Schema\v1_4;

use Doctrine\DBAL\Schema\Schema;

use FM\PlatformBundle\Entity\Resource;
use Oro\Bundle\EntityConfigBundle\Migration\UpdateEntityConfigEntityValueQuery;

use Oro\Bundle\MigrationBundle\Migration\Migration;
use Oro\Bundle\MigrationBundle\Migration\QueryBag;

class FieldAclSupportForResource implements Migration
{
    /**
     * {@inheritdoc}
     */
    public function up(Schema $schema, QueryBag $queries)
    {
        $queries->addQuery(
            new UpdateEntityConfigEntityValueQuery(
                Resource::class,
                'security',
                'field_acl_supported',
                true
            )
        );
    }
}