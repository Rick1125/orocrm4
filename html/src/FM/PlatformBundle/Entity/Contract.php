<?php

namespace FM\PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use FM\PlatformBundle\Constant\Status;
use Oro\Bundle\UserBundle\Entity\User;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Contract
 *
 * @ORM\Table(name="fm_contract")
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 */
class Contract extends AbstractEntity
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
     * @ORM\Column(name="status", type="string", length=15)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="decimal", precision=10, scale=2)
     */
    private $amount;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="launched_at", type="datetime")
     */
    private $launchedAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expired_at", type="datetime")
     */
    private $expiredAt;

    /**
     * Contract has Projects
     * @var Collection|Project[]
     *
     * @ORM\ManyToMany(targetEntity="Project")
     * @ORM\JoinTable(name="fm_contract_has_projects",
     *      joinColumns={@ORM\JoinColumn(name="contract_id", referencedColumnName="id", onDelete="CASCADE")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="project_id", referencedColumnName="id", onDelete="CASCADE")}
     * )
     */
    protected $projects;

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
        $this->projects = new ArrayCollection();
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Contract
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
     * Set status
     *
     * @param string $status
     *
     * @return Contract
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
     * Set description
     *
     * @param string $description
     *
     * @return Contract
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
     * Set amount
     *
     * @param string $amount
     *
     * @return Contract
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * Get amount
     *
     * @return string
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * Set launchedAt
     *
     * @param \DateTime $launchedAt
     *
     * @return Contract
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
     * @return Contract
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
     * @return Collection|Project[]
     */
    public function getProjects()
    {
        return $this->projects;
    }

    /**
     * @param Project $project
     * @return Contract
     */
    public function addProject(Project $project): Contract
    {
        if (!$this->getProjects()->contains($project)) {
            $this->getProjects()->add($project);
        }

        return $this;
    }

    /**
     * @param Project $project
     * @return Contract
     */
    public function removeProject(Project $project): Contract
    {
        if ($this->getProjects()->contains($project)) {
            $this->getProjects()->remove($project);
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
     * @return string
     */
    public function __toString()
    {
        return (string) $this->name;
    }
}

