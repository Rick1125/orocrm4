<?php

namespace FM\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Channel
 *
 * @ORM\Table(name="fm_channel")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Channel extends BaseEntity
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=179, unique=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Name",
     *              "identity"=true,
     *              "order"=10
     *          }
     *      }
     * )
     */
    private $name;

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_person", type="boolean")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Person",
     *              "order"=20
     *          }
     *      }
     * )
     */
    private $person = false;

    /**
     * @var Resource[]|Collection
     *
     * @ORM\OneToMany(targetEntity="Resource", mappedBy="channel", cascade={"persist"})
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
     * @return Channel
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
     * @return Channel
     */
    public function addResource(Resource $resource): Channel
    {
        if (!$this->getResources()->contains($resource)) {
            $this->getResources()->add($resource);
            $resource->setChannel($this);
        }

        return $this;
    }

    /**
     * @param Resource $resource
     * @return Channel
     */
    public function removeResource(Resource $resource): Channel
    {
        $this->getResources()->removeElement($resource);
        if ($resource->getChannel() === $this) {
            $resource->setChannel(null);
        }

        return $this;
    }

    /**
     * @param bool $person
     * @return Channel
     */
    public function setPerson(bool $person): Channel
    {
        $this->person = $person;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPerson(): bool
    {
        return $this->person;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}
