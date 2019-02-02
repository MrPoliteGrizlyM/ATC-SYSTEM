<?php
/**
 * Created by PhpStorm.
 * User: mrpolitegrizly
 * Date: 2/2/19
 * Time: 9:37 PM
 */

namespace App\Service;


use App\Entity\User;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\Encoder\BCryptPasswordEncoder;


class AdminService
{

    private $em;

    public function __construct(ContainerInterface $container)
    {
        $this->em = $container->get('doctrine')->getManager();
    }

    public function createAdmin()
    {
        $user = new User();
        $user->setName('Admin');
        $user->setEmail('admin@gmail.com');
        $user->setGender(1);
        $user->setBirthDate(new \DateTime());
        $user->setLogin(User::ADMIN_LOGIN);
        $user->setPassword(User::ADMIN_PASSWORD);
        $user->setRoles(['ROLE_ADMIN']);
        $this->em->persist($user);
        $this->em->flush();
    }

}