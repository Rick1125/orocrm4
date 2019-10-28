<?php

namespace FM\PlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FM\PlatformBundle\Constant\Status;
use FM\PlatformBundle\Model\ExtendResource;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\Config;
use Oro\Bundle\EntityConfigBundle\Metadata\Annotation\ConfigField;

/**
 * Resource
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.ExcessivePublicCount)
 * @SuppressWarnings(PHPMD.TooManyFields)
 * @SuppressWarnings(PHPMD.ExcessiveClassLength)
 * @SuppressWarnings(PHPMD.ExcessiveClassComplexity)
 *
 * @ORM\Table(name="fm_resource", options={"collate":"utf8mb4_bin", "charset":"utf8mb4"})
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @Config(
 *      routeName="fm_resource_index",
 *      routeView="fm_resource_view",
 *      defaultValues={
 *          "ownership"={
 *              "owner_type"="BUSINESS_UNIT",
 *              "owner_field_name"="owner",
 *              "owner_column_name"="business_unit_owner_id",
 *              "organization_field_name"="organization",
 *              "organization_column_name"="organization_id"
 *          },
 *          "security"={
 *              "type"="ACL",
 *              "group_name"="",
 *              "field_acl_supported"="true",
 *              "category"="fm_management"
 *          },
 *          "dataaudit"={
 *              "auditable"=true
 *          },
 *          "form"={
 *              "form_type"="FM\PlatformBundle\Form\Type\ResourceType",
 *              "grid_name"="fm-resource-grid",
 *          },
 *          "grid"={
 *              "default"="fm-resource-grid"
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
class Resource extends ExtendResource
{
    const QUOTE_INDEX = 1.3;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Name",
     *              "order"=10
     *          }
     *      }
     * )
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Contact Name",
     *              "order"=20
     *          }
     *      }
     * )
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=15)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=1024)
     * @ConfigField(
     *      defaultValues={
     *          "merge"={
     *              "display"=true
     *          },
     *          "dataaudit"={
     *              "auditable"=true
     *          },
     *          "importexport"={
     *              "header"="Link",
     *              "identity"=true,
     *              "order"=30
     *          }
     *      }
     * )
     */
    private $link;

    /**
     * @var string
     *
     * @ORM\Column(name="link_hash", type="string", length=32, unique=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    private $linkHash;

    /**
     * @var float
     *
     * @ORM\Column(name="score", type="decimal", scale=2, precision=10)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "excluded"=true
     *          }
     *      }
     * )
     */
    private $score = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="quote_direct", type="decimal", scale=2, precision=10)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Quote Direct",
     *              "order"=45
     *          },
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          }
     *      }
     * )
     */
    private $quoteDirect = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="quote_repost", type="decimal", scale=2, precision=10)
    * @ConfigField(
    *      defaultValues={
    *          "importexport"={
    *              "header"="Quote Repost",
     *              "order"=55
     *          },
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          }
    *      }
    * )
    */
    private $quoteRepost = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="follower", type="decimal", scale=2, precision=10)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Follower",
     *              "order"=35
     *          }
     *      }
     * )
     */
    private $follower = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_direct", type="decimal", scale=2, precision=10)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Cost Direct",
     *              "order"=40
     *          },
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          }
     *      }
     * )
     */
    private $costDirect = 0.0;

    /**
     * @var float
     *
     * @ORM\Column(name="cost_repost", type="decimal", scale=2, precision=10)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Cost Repost",
     *              "order"=50
     *          },
     *          "security"={
     *              "permissions"="VIEW;CREATE;EDIT",
     *          }
     *      }
     * )
     */
    private $costRepost = 0.0;

    /**
     * @var string
     *
     * @ORM\Column(name="memo", type="string", length=1024, nullable=true)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Memo",
     *              "order"=80
     *          }
     *      }
     * )
     */
    private $memo;

    /**
     * @var string
     *
     * @ORM\Column(name="channel_name", type="string", length=179)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Channel Name",
     *              "order"=60
     *          }
     *      }
     * )
     */
    private $channelName = '';

    /**
     * @var boolean
     *
     * @ORM\Column(name="is_person", type="boolean")
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Person",
     *              "order"=70
     *          }
     *      }
     * )
     */
    private $person = false;

    /**
     * @var float
     *
     * @ORM\Column(name="discount", type="decimal", scale=2, precision=5)
     * @ConfigField(
     *      defaultValues={
     *          "importexport"={
     *              "header"="Discount",
     *              "order"=90
     *          }
     *      }
     * )
     */
    private $discount = 1.0;

    /**
     * @var Platform
     *
     * @ORM\ManyToOne(targetEntity="Platform", inversedBy="resources")
     * @ORM\JoinColumn(name="platform_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $platform;

    /**
     * @var Channel
     *
     * @ORM\ManyToOne(targetEntity="Channel", inversedBy="resources")
     * @ORM\JoinColumn(name="channel_id", referencedColumnName="id", onDelete="SET NULL")
     */
    protected $channel;

    /**
     * Contract constructor.
     */
    public function __construct()
    {
        parent::__construct();

        $this->setStatus(Status::ENABLED);
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Resource
     */
    public function setName($name): Resource
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
     * Set nickname
     *
     * @param string $nickname
     *
     * @return Resource
     */
    public function setNickname($nickname): Resource
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return Resource
     */
    public function setStatus($status): Resource
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
     * Set link
     *
     * @param string $link
     *
     * @return Resource
     */
    public function setLink($link): Resource
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
     * Set link_hash
     *
     * @param string $linkHash
     *
     * @return Resource
     */
    public function setLinkHash($linkHash): Resource
    {
        $this->linkHash = $linkHash;

        return $this;
    }

    /**
     * Get linkHash
     *
     * @return string
     */
    public function getLinkHash()
    {
        return $this->linkHash;
    }

    /**
     * @param Platform $platform
     * @return Resource
     */
    public function setPlatform(Platform $platform = null): Resource
    {
        $this->platform = $platform;

        return $this;
    }

    /**
     * @return Platform|null
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param Channel $channel
     * @return Resource
     */
    public function setChannel(Channel $channel = null): Resource
    {
        $this->channel = $channel;

        return $this;
    }

    /**
     * @return Channel|null
     */
    public function getChannel()
    {
        return $this->channel;
    }

    /**
     * @param float $score
     * @return Resource
     */
    public function setScore(float $score): Resource
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return float
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param float $quote
     * @return Resource
     */
    public function setQuoteDirect(float $quote): Resource
    {
        $this->quoteDirect = $quote;
        return $this;
    }

    /**
     * @return float
     */
    public function getQuoteRepost()
    {
        return $this->quoteRepost;
    }

    /**
     * @return float
     */
    public function getQuoteDirect()
    {
        return $this->quoteDirect;
    }

    /**
     * @param float $quote
     * @return Resource
     */
    public function setQuoteRepost(float $quote): Resource
    {
        $this->quoteRepost = $quote;
        return $this;
    }

    /**
     * @return float
     */
    public function getCostDirect()
    {
        return $this->costDirect;
    }

    /**
     * @param float $cost
     * @return Resource
     */
    public function setCostDirect(float $cost): Resource
    {
        $this->costDirect = $cost;
        return $this;
    }

    /**
     * @return float
     */
    public function getCostRepost()
    {
        return $this->costRepost;
    }

    /**
     * @param float $cost
     * @return Resource
     */
    public function setCostRepost(float $cost): Resource
    {
      $this->costRepost = $cost;
      return $this;
    }

    /**
     * @param string $memo
     * @return Resource
     */
    public function setMemo(string $memo): Resource
    {
        $this->memo = $memo;
        return $this;
    }

    /**
     * @return string
     */
    public function getMemo()
    {
        return $this->memo;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Resource
     */
    public function setChannelName($name): Resource
    {
        $this->channelName = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getChannelName()
    {
        return $this->channelName;
    }

    /**
     * @param bool $person
     * @return Resource
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
     * Pre update event handler
     *
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function doPreUpdate()
    {
        $this->linkHash = md5($this->link);
    }

    /**
     * @param float $discount
     * @return Resource
     */
    public function setDiscount(float $discount): Resource
    {
        $this->discount = $discount;
        return $this;
    }

    /**
     * @return float
     */
    public function getDiscount()
    {
        return $this->discount;
    }

    /**
     * @param float $follower
     * @return Resource
     */
    public function setFollower(float $follower): Resource
    {
        $this->follower = $follower;
        return $this;
    }

    /**
     * @return float
     */
    public function getFollower()
    {
        return $this->follower;
    }
}
