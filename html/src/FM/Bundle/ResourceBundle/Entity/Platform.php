<?php

namespace FM\Bundle\ResourceBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Platform
 *
 * @ORM\Table(name="fm_platform")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Platform extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;
    /**
     * @var string
     *
     * @ORM\Column(name="match_rule", type="string", length=255)
     */
    private $matchRule;

    /**
     * @var Resource[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="platform", cascade={"persist"})
     */
    protected $resources;

    /**
     * Account constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->resources = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Platform
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @return Resource[]|Collection
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param Resource $resource
     * @return Platform
     */
    public function addResource(Resource $resource): Platform
    {
        if (!$this->getResources()->contains($resource)) {
            $this->getResources()->add($resource);
            $resource->setPlatform($this);
        }

        return $this;
    }

    /**
     * @param Resource $resource
     * @return Platform
     */
    public function removeResource(Resource $resource): Platform
    {
        $this->getResources()->removeElement($resource);
        if ($resource->getPlatform() === $this) {
            $resource->setPlatform(null);
        }

        return $this;
    }

    /**
     * @param string $matchRule
     * @return Platform
     */
    public function setMatchRule(string $matchRule): Platform
    {
        $this->matchRule = $matchRule;
        return $this;
    }

    /**
     * @return string
     */
    public function getMatchRule()
    {
        return $this->matchRule;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}

