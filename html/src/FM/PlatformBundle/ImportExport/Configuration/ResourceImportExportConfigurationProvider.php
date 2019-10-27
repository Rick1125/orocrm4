<?php

namespace FM\PlatformBundle\ImportExport\Configuration;

use FM\PlatformBundle\Entity\Resource;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfiguration;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfigurationInterface;
use Oro\Bundle\ImportExportBundle\Configuration\ImportExportConfigurationProviderInterface;
use Symfony\Component\Translation\TranslatorInterface;

class ResourceImportExportConfigurationProvider implements ImportExportConfigurationProviderInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritDoc}
     */
    public function get(): ImportExportConfigurationInterface
    {
        return new ImportExportConfiguration([
            ImportExportConfiguration::FIELD_ENTITY_CLASS => Resource::class,
            ImportExportConfiguration::FIELD_EXPORT_PROCESSOR_ALIAS => 'fm.resource',
            ImportExportConfiguration::FIELD_EXPORT_TEMPLATE_PROCESSOR_ALIAS => 'fm.resource',
            ImportExportConfiguration::FIELD_IMPORT_PROCESSOR_ALIAS => 'fm.resource.add_or_replace',
            ImportExportConfiguration::FIELD_IMPORT_STRATEGY_TOOLTIP =>
                $this->translator->trans('fm.resource.import.strategy.tooltip'),
        ]);
    }
}
