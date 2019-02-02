<?php
/**
 * Created by PhpStorm.
 * User: mrpolitegrizly
 * Date: 12/1/18
 * Time: 11:27 AM
 */

namespace App\Admin;

use App\Entity\Line;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Sonata\Form\Type\DateTimePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LineAdmin extends AbstractAdmin
{
    protected function configureFormFields(FormMapper $formMapper)
    {

        $image = $this->getSubject();
        $file_options = ['required' => false, 'label' => 'Map' ];
        if ($image->getMap()) {
            $full_path = "/".Line::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$image->getMap();
            $file_options['help'] = '<br> <img src="'.$full_path.'" class="admin-preview" style="max-width: 350px; max-height: 800px;" /> <br> <br> <a class="btn btn-danger" id="delete-image-map" name="'.$image->getId().'">Удалить фотографию</a>';
            $file_options['attr'] = array('style' => 'display: none;');

        }

        $formMapper->with('Маршрут', ['class'=> 'col-md-4 col-lg-3'])
                ->add('code', TextType::class)
                ->add('type', TextType::class)
                ->add('start_time_operation', DateTimePickerType::class)
                ->add('end_time_operation', DateTimePickerType::class)
                ->add('image', FileType::class, $file_options)
                ->end();
    }

    protected function configureDatagridFilters(DatagridMapper $datagridMapper)
    {
        $datagridMapper->add('code');
        $datagridMapper->add('type');
    }

    protected function configureListFields(ListMapper $listMapper)
    {
        $listMapper->addIdentifier('code')
                    ->addIdentifier('type')
                    ->addIdentifier('station')
                    ->addIdentifier('vehicles')
                    ->addIdentifier('start_time_operation')
                    ->addIdentifier('end_time_operation')
                    ->addIdentifier('map', null, array('template' => '/fields/map.html.twig'));

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

    private function manageFileUpload(Line $entity)
    {
        if ($entity->getImage()) {
            $entity->lifecycleFileUpload();
        }
    }

    private function manageFileDelete(Line $entity)
    {
        $entity->lifecycleFileDelete();
    }

}