<?php

namespace FM\PlatformBundle\Form\Handler;

use Doctrine\ORM\EntityManagerInterface;
use Oro\Bundle\FormBundle\Form\Handler\FormHandlerInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;

class FormHandler implements FormHandlerInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected $manager;

    /**
     * @param EntityManagerInterface $manager
     */
    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Process form
     *
     * @param  object $entity
     * @param  FormInterface $form
     * @param  Request $request
     *
     * @return bool True on successful processing, false otherwise
     */
    public function process($entity, FormInterface $form, Request $request)
    {
        $form->setData($entity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->onSuccess($entity, $form);

            return true;
        }

        return false;
    }

    /**
     * "Success" form handler
     *
     * @param $entity
     * @param FormInterface $form
     */
    protected function onSuccess($entity, FormInterface $form)
    {
        $this->manager->persist($entity);
        $this->manager->flush();
    }
}
