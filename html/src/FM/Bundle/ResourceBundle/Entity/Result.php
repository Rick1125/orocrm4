<?php

namespace FM\Bundle\ResourceBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Kol
 *
 * @ORM\Table(name="fm_resource_result")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Result extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=1024)
     */
    private $link;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="decimal", scale=2, precision=10)
     */
    private $price = 0.0;

    /**
     * @var Resource
     *
     * @ORM\ManyToOne(targetEntity="Resource", inversedBy="results")
     * @ORM\JoinColumn(name="resource_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $resource;

    /**
     * Set link
     *
     * @param string $link
     *
     * @return Result
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get link
     *
     * @return string
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * @param Resource $resource
     * @return Result
     */
    public function setResource(Resource $resource): Result
    {
        $this->resource = $resource;
        return $this;
    }

    /**
     * @return Resource
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * @param float $price
     * @return Result
     */
    public function setPrice(float $price): Result
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}

