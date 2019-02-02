<?php

namespace App\Controller;


use App\Entity\Driver;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AdminCustomController extends Controller
{
    /**
     * @Route("/admin/delete/image/{slug}", name="admin_custom_delete_image")
     */
    public function index($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Driver::class)->find($slug);

        $fileSystem = new Filesystem();
        $fileSystem->remove(Driver::SERVER_PATH_TO_IMAGE_FOLDER.'/'.$entity->getAvatar());

        $entity->setAvatar(null);
        $em->flush();
        $em->persist($entity);

        return $this->redirect('/app/driver/'.$slug.'/edit');
    }

}
