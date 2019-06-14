<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="user")
 **/
class User
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string") **/
    protected $name;

    /** @OneToMany(targetEntity="Favourite", mappedBy="user") **/
    protected $favourites;


    public function __construct()
    {
        $this->favourites = new ArrayCollection();
    }

    public function addFavourites(Favourite $favourite)
    {
        $this->favourites[] = $favourite;
    }

    public function getFavourites()
    {
        return $this->favourites;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }


}
