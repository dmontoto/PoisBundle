<?php

namespace Dmontoto\GmapsBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Dmontoto\GmapsBundle\Manager\GMapsManager;
use Dmontoto\GmapsBundle\API\GMap;

class GMapsHelper extends Helper {
    private $manager;

    public function __construct(GMapsManager $manager) {
        $this->manager = $manager;
    }

    public function getKey() {
        return $this->manager->getKey();
    }

    public function hasMaps() {
        return $this->manager->hasMaps();
    }

    public function getMaps() {
        return $this->manager->getMaps();
    }

    public function getMapById($id) {
        return $this->manager->getMapById($id);
    }

    public function render(GMap $map) {
        return $map->render();
    }

    public function getName() {
        return 'gmaps';
    }
}
