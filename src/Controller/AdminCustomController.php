<?php

namespace App\Controller;


use App\Entity\Driver;
use App\Entity\Line;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminCustomController extends Controller
{
    /**
     * @Route("/admin/delete/image/{type}/{slug}", name="admin_custom_delete_image")
     */
    public function deleteImage($type, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = null;
        switch ($type) {
            case 'map':
                $rep = Line::class;
                break;
            case 'avatar':
                $rep = Driver::class;
                break;
        }
        $entity = $em->getRepository($rep)->find($slug);

        $render = $entity->render();
        $fileSystem = new Filesystem();
        $fileSystem->remove($render['path']);

        $em->flush();
        $em->persist($entity);

        return $this->redirect('/admin/app/'.$render['entity'].'/'.$slug.'/edit');
    }

}
