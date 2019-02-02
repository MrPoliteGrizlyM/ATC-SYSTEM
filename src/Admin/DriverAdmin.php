<?php
/**
 * Created by PhpStorm.
 * User: mrpolitegrizly
 * Date: 12/1/18
 * Time: 11:27 AM
 */

namespace App\Admin;

use App\Entity\Driver;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\CollectionType;
use Sonata\AdminBundle\Form\Type\Filter\DateTimeType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class DriverAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {
        $image = $this->getSubject();
        $file_options = ['required' => false, 'label' => 'Avatar' ];
        if ($image->getAvatar()) {
            $full_path = "/".Driver::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$image->getAvatar();
            $file_options['help'] = '<br> <img src="'.$full_path.'" class="admin-preview" style="width: 150px; height: 100px;" /> <br> <br> <a class="btn btn-danger" id="delete-image-avatar" name="'.$image->getId().'">Удалить фотографию</a>';
            $file_options['attr'] = array('style' => 'display: none;');

        }


        $formMapper->with('Водитель', ['class'=> 'col-md-4 col-lg-3'])
                ->add('image', FileType::class, $file_options)
                ->add('name', TextType::class)
                ->add('birth_date', DateTimePickerType::class, [
                    'dp_use_current' => false,
                ])
                ->add('email')
                ->add('phone')
                ->add('vehicle')
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('name');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->add('image', null, array('template' => '/fields/avatar.html.twig', 'label' => 'Avatar'));
        $listMapper->addIdentifier('name')
                    ->addIdentifier('email')
                    ->addIdentifier('phone')
                    ->addIdentifier('vehicle.name')
                    ->addIdentifier('vehicle.type');
    }

    public function prePersist($entity)
    {
        $this->manageFileUpload($entity);
    }

    public function preUpdate($entity)
    {
        $this->manageFileUpload($entity);
    }

    public function preRemove($entity)
    {
        $this->manageFileDelete($entity);
    }

    private function manageFileUpload(Driver $entity)
    {
        if ($entity->getImage()) {
            $entity->lifecycleFileUpload();
        }
    }

    private function manageFileDelete(Driver $entity)
    {
        $entity->lifecycleFileDelete();
    }
}