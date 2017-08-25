<?php

namespace DefaultBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Purchase
 *
 * @ORM\Table(name="purchase")
 * @ORM\Entity(repositoryClass="DefaultBundle\Repository\PurchaseRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Purchase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="string", length=55)
     * @Assert\NotBlank(message="Veuillez renseigner un nom")
     * @Assert\Length(
     *      max = 55,
     *      maxMessage = "Pas plus de {{ limit }} charactères"
     * )
     * @Assert\Regex(
     *     pattern="/^([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+([-]([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+)*$/iu",
     *     match=true,
     *     message="Le format n'est pas correct"
     * )
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=55)
     * @Assert\NotBlank(message="Veuillez renseigner un prénom")
     * @Assert\Length(
     *      max = 55,
     *      maxMessage = "Pas plus de {{ limit }} charactères"
     * )
     * @Assert\Regex(
     *     pattern="/^([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+([-]([a-zàáâäçèéêëìíîïñòóôöùúûü]+(( |')[a-zàáâäçèéêëìíîïñòóôöùúûü]+)*)+)*$/iu",
     *     match=true,
     *     message="Le format n'est pas correct"
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=55)
     * @Assert\Length(
     *      max = 55,
     *      maxMessage = "Pas plus de {{ limit }} charactères"
     * )
     * @Assert\Email(
     *     message = "The email '{{ value }}' is not a valid email.",
     *     checkMX = true
     * )
     * @Assert\NotBlank(message="Veuillez renseigner un email")
     *
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="adress", type="string", length=255)
     * @Assert\NotBlank(message="Veuillez renseigner une adresse")
     */
    private $adress;

    /**
     * @var string
     *
     * @ORM\Column(name="zip_code", type="string", length=5)
     * @Assert\NotBlank(message="Veuillez renseigner un code postal")
     * @Assert\Length(
     *      max = 5,
     *      maxMessage = "Pas plus de {{ limit }} charactères"
     * )
     * @Assert\Type(
     *     type="digit",
     *     message="Le format n'est pas correct"
     * )
     */
    private $zip_code;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=55)
     * @Assert\NotBlank(message="Veuillez renseigner une ville")
     * @Assert\Length(
     *      max = 55,
     *      maxMessage = "Pas plus de {{ limit }} charactères"
     * )
     * @Assert\Type(
     *     type="alpha",
     *     message="Le format n'est pas correct"
     * )
     */
    private $city;

    /**
     * @var string
     *
     * @ORM\Column(name="number", type="string", length=10)
     * @Assert\NotBlank(message="Veuillez renseigner un numéro")
     * @Assert\Length(
     *      max = 10,
     *      maxMessage = "Pas plus de {{ limit }} charactères"
     * )
     * @Assert\Type(
     *     type="digit",
     *     message="Le format n'est pas correct"
     * )
     */
    private $number;

    /**
     * @var array
     *
     * @ORM\Column(name="buy_list", type="json_array")
     */
    private $buyList;

    /**
     * @var \Datetime
     * @ORM\Column(name="datePurchase", type="datetime")
     */
    private $datePurcahse;

    /**
     * @ORM\ManyToOne(targetEntity="DefaultBundle\Entity\Status")
     */
    private $status;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set lastname
     *
     * @param string $lastname
     *
     * @return Purchase
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set firstname
     *
     * @param string $firstname
     *
     * @return Purchase
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Purchase
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set adress
     *
     * @param string $adress
     *
     * @return Purchase
     */
    public function setAdress($adress)
    {
        $this->adress = $adress;

        return $this;
    }

    /**
     * Get adress
     *
     * @return string
     */
    public function getAdress()
    {
        return $this->adress;
    }

    /**
     * Set number
     *
     * @param string $number
     *
     * @return Purchase
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return string
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set buyList
     *
     * @param array $buyList
     *
     * @return Purchase
     */
    public function setBuyList($buyList)
    {
        $this->buyList = $buyList;

        return $this;
    }

    /**
     * Get buyList
     *
     * @return array
     */
    public function getBuyList()
    {
        return $this->buyList;
    }

    /**
     * @return \Datetime
     */
    public function getDatePurcahse()
    {
        return $this->datePurcahse;
    }

    /**
     * @param \Datetime $datePurcahse
     */
    public function setDatePurcahse($datePurcahse)
    {
        $this->datePurcahse = $datePurcahse;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zip_code;
    }

    /**
     * @param string $zip_code
     */
    public function setZipCode($zip_code)
    {
        $this->zip_code = $zip_code;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->datePurcahse = new \DateTime('now');
    }
}
