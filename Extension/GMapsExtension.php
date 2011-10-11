<?php

namespace Dmontoto\GmapsBundle\Extension;

use Dmontoto\GmapsBundle\Helper\GMapsHelper;

class GMapsExtension extends \Twig_Extension {
    private $mapsHelper;

    public function __construct(GMapsHelper $mapsHelper) {
        $this->mapsHelper = $mapsHelper;
    }

    public function getGlobals() {
        return array(
            'gmaps' => $this->mapsHelper
        );
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName() {
        return 'gmaps';
    }
}
