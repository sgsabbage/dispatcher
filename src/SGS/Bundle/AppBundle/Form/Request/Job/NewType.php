<?php
namespace SGS\Bundle\AppBundle\Form\Request\Job;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * @codeCoverageIgnore
 */
class NewType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name',null,array('label' => 'job.name'))
        ;
    }

    public function getName()
    {
        return 'request_job_new';
    }
}