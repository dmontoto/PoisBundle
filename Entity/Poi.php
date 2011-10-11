<?php
namespace Dmontoto\GmapsBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="poi")
 */
class Poi
{
    /**
     * @var integer $id
     * 
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    
    /**
     * @var string $name
     * 
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @Assert\NotBlank(message="Nombre es obligatorio")
     */
    protected $name;

     /**
     * @var float $latitude
      * 
     * @ORM\Column(name="latitude", type="decimal", scale="6", precision="10")
     */
    protected $latitude;

    /**
     * @var float $longitude
     * 
     * @ORM\Column(name="longitude", type="decimal", scale="6", precision="10")
     */
    protected $longitude;
    
    /**
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    protected $description;

    /**
    * @Assert\Type(type="Dmontoto\GmapsBundle\Entity\PoiCategory")
     * 
    * @ORM\ManyToOne(targetEntity="PoiCategory", inversedBy="poicategories")
    * @ORM\JoinColumn(name="poiCategory_id", referencedColumnName="id")
    */
    protected $poiCategory;

    /**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }    
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
    }

    /**
     * Get latitude
     *
     * @return float 
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
    }

    /**
     * Get longitude
     *
     * @return float 
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set description
     *
     * @param text $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * Get description
     *
     * @return text 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set poiCategory
     *
     * @param PoiCategory $poiCategory
     */
    public function setPoiCategory(PoiCategory $poiCategory)
    {
        $this->poiCategory = $poiCategory;
    }

    /**
     * Get poiCategory
     *
     * @return PoiCategory 
     */
    public function getPoiCategory()
    {
        return $this->poiCategory;
    }
}