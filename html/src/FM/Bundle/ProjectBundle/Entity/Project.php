<?php

namespace FM\Bundle\ProjectBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FM\Bundle\ProjectBundle\Model\ExtendProject;
use FM\Bundle\ResourceBundle\Constant\Status;
use FM\Bundle\ResourceBundle\Entity\Resource;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Project
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 *
 * @ORM\Table(name="fm_project")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      routeName="fm_project_index",
 *      routeView="fm_project_view",
 *      defaultValues={
 *          "ownership"={
 *              "owner_type"="USER",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="user_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "permissions"="All",
 *              "group_name"="Resource",
 *              "field_acl_supported"="true"
 *          },
 *          "dataaudit"={
 *              "auditable"=true
 *          },
 *          "form"={
 *              "form_type"="FM\ProjectBundle\Form\Type\ProjectType",
 *              "grid_name"="fm-project-grid"
 *          },
 *          "grid"={
 *              "default"="fm-project-grid"
 *          },
 *          "tag"={
 *              "enabled"=true
 *          },
 *          "merge"={
 *              "enable"=true
 *          }
 *      }
 * )
 */
class Project extends ExtendProject
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
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=15)
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="quote", type="decimal", precision=10, scale=2)
     * @ConfigField(
     *      defaultValues={
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          },
     *      }
     * )
     */
    private $quote;

    /**
     * @var float
     *
     * @ORM\Column(name="budget", type="decimal", precision=10, scale=2)
     * @ConfigField(
     *      defaultValues={
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          },
     *      }
     * )
     */
    private $budget;

    /**
     * @var float
     *
     * @ORM\Column(name="profit_rate", type="decimal", precision=6, scale=2)
     * @ConfigField(
     *      defaultValues={
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          },
     *      }
     * )
     */
    private $profitRate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="launched_at", type="datetime")
     */
    private $launchedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expired_at", type="datetime", nullable=true)
     */
    private $expiredAt;

    /**
     * Project has Resources
     * @var Collection|Resource[]
     *
     * @ORM\ManyToMany(targetEntity="FM\Bundle\ResourceBundle\Entity\Resource")
     * @ORM\JoinTable(name="fm_project_has_resources",
     *      joinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="resource_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $resources;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="user_owner_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $owner;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Oro\Bundle\UserBundle\Entity\User")
     * @ORM\JoinColumn(name="assigned_to_user_id", referencedColumnName="id", onDelete="SET NULL")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    protected $assignedTo;

    /**
     * Contract constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setStatus(Status::ENABLED);
        $this->resources = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Project
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
     * Set description
     *
     * @param string $description
     *
     * @return Project
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Project
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set quote
     *
     * @param float $quote
     *
     * @return Project
     */
    public function setQuote(float $quote)
    {
        $this->quote = $quote;

        return $this;
    }

    /**
     * Get quote
     *
     * @return string
     */
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * Set budget
     *
     * @param float $budget
     *
     * @return Project
     */
    public function setBudget(float $budget)
    {
        $this->budget = $budget;

        return $this;
    }

    /**
     * Get budget
     *
     * @return string
     */
    public function getBudget()
    {
        return $this->budget;
    }

    /**
     * Set launchedAt
     *
     * @param \DateTime $launchedAt
     *
     * @return Project
     */
    public function setLaunchedAt($launchedAt)
    {
        $this->launchedAt = $launchedAt;

        return $this;
    }

    /**
     * Get launchedAt
     *
     * @return \DateTime
     */
    public function getLaunchedAt()
    {
        return $this->launchedAt;
    }

    /**
     * Set expiredAt
     *
     * @param \DateTime $expiredAt
     *
     * @return Project
     */
    public function setExpiredAt($expiredAt)
    {
        $this->expiredAt = $expiredAt;

        return $this;
    }

    /**
     * Get expiredAt
     *
     * @return \DateTime
     */
    public function getExpiredAt()
    {
        return $this->expiredAt;
    }

    /**
     * @return Collection|Resource[]
     */
    public function getResources()
    {
        return $this->resources;
    }

    /**
     * @param Resource $resource
     * @return Project
     */
    public function addResource(Resource $resource): Project
    {
        if (!$this->getResources()->contains($resource)) {
            $this->getResources()->add($resource);
        }

        return $this;
    }

    /**
     * @param Resource $resource
     * @return Project
     */
    public function removeResource(Resource $resource): Project
    {
        if ($this->getResources()->contains($resource)) {
            $this->getResources()->remove($resource);
        }

        return $this;
    }

    /**
     * @param User $assignedTo
     * @return $this
     */
    public function setAssignedTo(User $assignedTo)
    {
        $this->assignedTo = $assignedTo;

        return $this;
    }

    /**
     * @return User
     */
    public function getAssignedTo()
    {
        return $this->assignedTo;
    }

    /**
     * @return User
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param User $owningUser
     *
     * @return Project
     */
    public function setOwner($owningUser)
    {
        $this->owner = $owningUser;

        return $this;
    }

    /**
     * @param string $profitRate
     * @return Project
     */
    public function setProfitRate(string $profitRate): Project
    {
        $this->profitRate = $profitRate;
        return $this;
    }

    /**
     * @return string
     */
    public function getProfitRate()
    {
        return $this->profitRate;
    }

    /**
     * @return bool
     */
    public function hasResources()
    {
        return count($this->resources) > 0;
    }
}
