<?php
/**
 * Created by PhpStorm.
 * User: mrpolitegrizly
 * Date: 12/1/18
 * Time: 11:27 AM
 */

namespace App\Admin;

use App\Entity\Driver;
use App\Entity\Vehicle;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class VehicleAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $formMapper->with('Транспорт', ['class'=> 'col-md-4 col-lg-3'])
                ->add('name', TextType::class)
                ->add('type', ChoiceType::class, [
                    'choices' => Vehicle::TYPES
                ])
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
        $datagridMapper->add('line');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('name')
                    ->addIdentifier('type')
                    ->addIdentifier('drivers');
    }

}