<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity
 * @Table(
 *     name="favourite",
 *     uniqueConstraints={@UniqueConstraint(name="user_movie_idx", columns={"user_id", "movie_id"})})
 **/
class Favourite
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /**
     * @ManyToOne(targetEntity="User", inversedBy="favourites")
     **/
    protected $user;

    /**
     * @ManyToOne(targetEntity="Movie", cascade={"persist"})
     **/
    protected $movie;


    /** @Column(type="smallint", nullable=TRUE) **/
    protected $rating;

    /** @Column(type="text", nullable=TRUE) **/
    protected $comment;


    public function __construct()
    {
        $this->user = new ArrayCollection();
        $this->movie = new ArrayCollection();
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user)
    {
        $user->addFavourites($this);
        $this->user = $user;
    }

    public function getMovie()
    {
        return $this->movie;
    }

    public function setMovie(Movie $movie)
    {
        $this->movie = $movie;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }


}
