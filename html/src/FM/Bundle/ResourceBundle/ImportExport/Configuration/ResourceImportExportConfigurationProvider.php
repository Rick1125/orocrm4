<?php

namespace FM\Bundle\ResourceBundle\ImportExport\Configuration;

use FM\Bundle\ResourceBundle\Entity\Resource;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfiguration;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfigurationInterface;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfigurationProviderInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class ResourceImportExportConfigurationProvider implements ImportExportConfigurationProviderInterface
{
    /**
     * {@inheritDoc}
     */
    public function get(): ImportExportConfigurationInterface
    {
        return new ImportExportConfiguration([
            ImportExportConfiguration::FIELD_ENTITY_CLASS => Resource::class,
            ImportExportConfiguration::FIELD_EXPORT_PROCESSOR_ALIAS => 'fm_resource',
            ImportExportConfiguration::FIELD_EXPORT_TEMPLATE_PROCESSOR_ALIAS => 'fm_resource',
            ImportExportConfiguration::FIELD_IMPORT_PROCESSOR_ALIAS => 'fm.resource.add_or_replace',
        ]);
    }
}
