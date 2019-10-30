<?php
/**
 * Created by PhpStorm.
 * User: rick
 * Date: 2017/11/26
 * Time: 16:37
 */

namespace FM\Bundle\ResourceBundle\Form\Extension;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use oro\Bundle\ImportExportBundle\Form\Type\ImportType;
use Oro\Bundle\OrganizationBundle\Form\Type\BusinessUnitSelectAutocomplete;

use FM\Bundle\ResourceBundle\Entity\Resource;

/**
 * @method iterable getExtendedTypes()
 */
class BUImportTypeExtension extends AbstractTypeExtension
{
    public function getExtendedType()
    {
        return ImportType::NAME;
    }

    /**
     * TODO: 此处应该判断用户的bu，只允许上传有 bu 权限的数据，可以参考以下实现
     * Oro/Bundle/OrganizationBundle/Form/Extension/OwnerFormExtension.php
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     * @return void
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $entityName = $builder->getOption('entityName');
        if ($entityName !== Resource::class) {
            return;
        }
        $builder->add(
            'owner',
            BusinessUnitSelectAutocomplete::class,
            [
                'required' => true,
                'label' => 'oro.business_unit.label',
                'autocomplete_alias' => 'business_units_owner_search_handler',
                'configs' => [
                    'multiple' => false,
                    'allowClear'  => false,
                    'autocomplete_alias' => 'business_units_owner_search_handler',
                    'component'   => 'tree-autocomplete',
                ]
            ]
        );

        $this->addListener($builder);
    }

    // owner 无法通过 form 的 validation，所以提交表单之前从 post 中移除，放入 query.
    protected function addListener(FormBuilderInterface $builder)
    {
        $builder->addEventListener(
            FormEvents::PRE_SUBMIT,
            function (FormEvent $event) {
                $form = $event->getForm();
                if ($form->has('owner')) {
                    $form->remove('owner');
                    $data = $event->getData();
                    $importData = $data->request->get($this->getExtendedType());
                    if (isset($importData['owner'])) {
                        $data->query->set('options', ['owner' => $importData['owner']]);
                        unset($importData['owner']);
                        $data->request->set($this->getExtendedType(), $importData);
                    }
                }
            }, 900);
    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method iterable getExtendedTypes()
    }
}
