<?php
namespace Dmontoto\GmapsBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;

class Builder extends ContainerAware
{
    public function mainMenu(FactoryInterface $factory)
    {
        $menu = $factory->createItem('mainMenu', array('attributes' => array('id' => 'menu')));
        $menu->setCurrentUri($this->container->get('request')->getRequestUri());

        $menu->addChild('Home', array('route' => 'GmapsBundle_homepage'));
        $menu->addChild('List of Pois', array('route' => 'GmapsBundle_grid'));
        $menu->addChild('Nuevo Poi', array('route' => 'GmapsBundle_poiForm'));
        
        return $menu;
    }
}
?>
