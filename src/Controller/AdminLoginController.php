<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\AdminService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\AdminLoginForm;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AdminLoginController extends Controller
{
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;


    public function __construct(AuthenticationUtils $authenticationUtils)
    {
        $this->authenticationUtils = $authenticationUtils;
    }

    /**
     * @Route("/admin/login", name="admin_login")
     */
    public function loginAction(): Response
    {
        $form = $this->createForm(AdminLoginForm::class, [
            'login' => $this->authenticationUtils->getLastUsername()
        ]);

        return $this->render('security/login.html.twig', [
            'last_username' => $this->authenticationUtils->getLastUsername(),
            'form' => $form->createView(),
            'error' => $this->authenticationUtils->getLastAuthenticationError(),
        ]);
    }

    /**
     * @Route("/admin/logout", name="admin_logout")
     */
    public function logoutAction(): void
    {
        // Left empty intentionally because this will be handled by Symfony.
    }



    /**
     * @Route("/create-admin", name="admin_create")
     */
    public function createAdmin(AdminService $adminService)
    {
        $em = $this->getDoctrine()->getManager();
        $last_admin = $em->getRepository(User::class)->findBy(['login' => User::ADMIN_LOGIN]);

        if (!$last_admin) {
            $adminService->createAdmin();
            return new JsonResponse('Created admin with login: '.User::ADMIN_LOGIN.' password: admin123');
        }

        return new JsonResponse('Admin is already exist');
    }

}