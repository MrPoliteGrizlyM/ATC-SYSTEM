<?php
/**
 * Created by PhpStorm.
 * User: mrpolitegrizly
 * Date: 12/4/18
 * Time: 12:37 PM
 */

namespace App\Admin\Block;

use App\Service\XMLService;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Doctrine\ORM\EntityManager;

use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BlockContextInterface;

use Sonata\AdminBundle\Form\FormMapper;
use Sonata\CoreBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Block\Service\AbstractBlockService;

class ToolsBlock extends AbstractBlockService
{

    protected $entity;

    private $container;
    private $manager;

    /**
     * @param string             $name
     * @param EngineInterface    $templating
     * @param ContainerInterface $container
     */
    public function __construct(?string $name = null, EngineInterface $templating = null,  ContainerInterface $container)
    {
        parent::__construct($name, $templating);

        $this->container = $container;
        $this->manager = $container->get('doctrine')->getManager();
    }

    public function configureSettings(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'url'      => false,
            'title'    => 'Insert the rss title',
            'template' => 'tools_block.html.twig',
        ));
    }

    public function execute(BlockContextInterface $blockContext, Response $response = null)
    {
        // merge settings
        $settings = $blockContext->getSettings();
        $path_to_xml = XMLService::PATH_TO_XML_FILE;

        return $this->renderResponse($blockContext->getTemplate(), array(
            'path_to_xml'     => $path_to_xml,
            'block'           => $blockContext->getBlock(),
            'settings'        => $settings
        ), $response);
    }

}