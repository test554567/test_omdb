<?php

use Doctrine\Common\Collections\ArrayCollection;

/**
 * @Entity @Table(name="movie")
 **/
class Movie
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
    protected $id;

    /** @Column(type="string") **/
    protected $title;

    /** @Column(type="smallint", nullable=TRUE) **/
    protected $year;

    /** @Column(type="text", nullable=TRUE) **/
    protected $plot;

    /** @Column(type="string", length=10, name="imdb_id", nullable=TRUE, unique=TRUE) **/
    protected $imdbId;

    /** @Column(type="text", nullable=TRUE) **/
    protected $poster;

    public static $defaultPoster = '/img/default_poster.jpg';

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getPlot()
    {
        return $this->plot;
    }

    public function setPlot($plot)
    {
        $this->plot = $plot;
    }

    public function getImdbId()
    {
        return $this->imdbId;
    }

    public function setImdbId($imdbId)
    {
        $this->imdbId = $imdbId;
    }

    public function getPoster()
    {
        return $this->poster;
    }

    public function setPoster($poster)
    {
        $this->poster = $poster;
    }


}
