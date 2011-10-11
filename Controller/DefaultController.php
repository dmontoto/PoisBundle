<?php

namespace Dmontoto\GmapsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Dmontoto\GmapsBundle\Entity\Poi;
use Dmontoto\GmapsBundle\API\GMap;
use Dmontoto\GmapsBundle\API\GMapMarker;
use Dmontoto\GmapsBundle\API\GMapMarkerImage;
use Dmontoto\GmapsBundle\API\GMapInfoWindow;
use Dmontoto\GmapsBundle\Form\PoiFormType;
use Sorien\DataGridBundle\Grid\Source\Entity;
use Sorien\DataGridBundle\Grid\Column\Column;

class DefaultController extends Controller
{
    
    public function indexAction()
    {
        //Data Load
        $repository = $this->getDoctrine()->getRepository('GmapsBundle:Poi');
        $pois = $repository->findAll();
        
        //Creamos el mapa
        $map = new GMap();
        $map->setWidth(850);
        $map->setHeight(300);
        
        //Cargamos los iconos para los POIS
        $gMapMarkerImageCamping = new GMapMarkerImage('gMapMarkerImageCamping','/bundles/gmaps/images/campground.png', array('width' => 32,'height' => 32), array('x' => 0, 'y' => 32), array('x' => 32, 'y' => 32));
        $map->addMarkerImage($gMapMarkerImageCamping);
        
        //Cargamos los POIS
        foreach ($pois as &$poi) {
            $gMapMarker = new GMapMarker($poi->getLatitude(),$poi->getLongitude(), array('markerImage'=> $gMapMarkerImageCamping->getName()), 'mapMarker'.$poi->getId());
            $gMapMarker->addHtmlInfoWindow(new GMapInfoWindow($poi->getDescription(), array(), 'InfoWindow'.$poi->getId()));
            $map->addMarker($gMapMarker);
        }
        $map->centerAndZoomOnMarkers(3);
        $this->container->get('gmaps')->addMap($map);
        
        return $this->render('GmapsBundle:Default:index.html.twig');
    }
    
    public function poiFormEditAction($id)
    {
        $request = $this->get('request');

        if (is_null($id)) {
            $postData = $request->get('Poi');
            $id = $postData['id'];
        }

        $em = $this->getDoctrine()->getEntityManager();
        $poi = $em->getRepository('GmapsBundle:Poi')->find($id);
        $form = $this->createForm(new PoiFormType(), $poi);

        if ($request->getMethod() == 'POST') {
            $form->bindRequest($request);

            if ($form->isValid()) {
                // perform some action, such as save the object to the database
                $em->flush();

                return $this->redirect($this->generateUrl('GmapsBundle_grid'));
            }
        }

        return $this->render('GmapsBundle:Default:poiEditForm.html.twig', array(
                'form' => $form->createView(),
            ));       
        
        
    }
    
    public function poiFormAction()
    {
        $request = $this->getRequest();
        $poi = new Poi();
        $form = $this->createForm(new PoiFormType(), $poi);

        if ($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);
            if ($form->isValid())
            {
                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($poi);
                $em->flush();
                return $this->redirect($this->generateUrl('GmapsBundle_grid'));
            }
        }
        return $this->render('GmapsBundle:Default:poiForm.html.twig', array(
            'form' => $form->createView()
        ));
        
    }

    public function gridAction()
    {
        // Creamos las columnas del grid
        $source = new Entity('GmapsBundle:Poi');
        $source->setPrepareCallback(function ($columns){
            $columns->addColumn(new Column(array(
                'id' => 'botones',
                'title' => 'Botones',
                'size' => '100', 
                'sortable' => false, 
                'filterable' => false, 
                'source' => false,  
                'values' => array('id'),
                'visible' => true)));
        });

        // creates simple grid based on your entity (ORM)
        $grid = $this->get('grid')->setSource($source)->setRoute('GmapsBundle_filter');

        if ($grid->isReadyForRedirect())
        {
            //data are stored, do redirect
            return new RedirectResponse($this->generateUrl('GmapsBundle_grid'));
        }
        else
        {
            // to obtain data for template you need to call prepare function
            return $this->render('GmapsBundle:Grid:grid.html.twig', array('data' => $grid->prepare()));
        }
    }
    
}
