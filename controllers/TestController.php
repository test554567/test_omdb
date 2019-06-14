<?php

//TODO autoload
//TODO routing
//TODO authentication
//TODO session
//TODO success messages

require_once 'TestControllerAbstract.php';

class TestController extends TestControllerAbstract
{
    protected $_service;
    protected $_key;
    protected $_currentUser;

    public function __construct($key)
    {
        parent::__construct();
        $this->_key = $key;
    }

    public function getService()
    {
        if (!$this->_service) {
            $this->_service = new TestService($this->_key);
        }
        return $this->_service;
    }

    public function getCurrentUser()
    {
        if (!$this->_currentUser){
            $this->_currentUser = $this->getService()->getCurrentUser();
        }
        return $this->_currentUser;
    }

    public function view()
    {
        $movieTitle = $this->getRequestParam('title');
        if (!$movieTitle) {
            //TODO templates autoload by action
            include 'templates/view.phtml';
            return true;
        }

        $user = $this->getCurrentUser();
        if (!$user) {
            $errorMessage = 'User required';
            include 'templates/view.phtml';
            return true;
        }

        $movie = $this->getService()->getMovieByTitle($movieTitle);
        if (!$movie) {
            $errorMessage = 'Not found';
            include 'templates/view.phtml';
            return true;
        }

        if ($movie->getImdbId()) {
            $favouriteMovie = $this->getService()->getFavouriteMovieByImdbId($user, $movie->getImdbId());
        }

        include 'templates/view.phtml';
        return true;
    }

    public function addToFavourites()
    {
        $user = $this->getCurrentUser();
        if (!$user ) {
            return false;
        }

        $title = $this->getRequestParam('title');
        if (!$title) {
            return false;
        }

        $imdbId = $this->getRequestParam('imdbId');
        $movie = $this->getService()->getMovieByImdbId($imdbId);
        if(!$movie) {
            $movie = new Movie();
            $movie->setTitle($title);
            $movie->setImdbID($imdbId);
            $movie->setYear($this->getRequestParam('year'));
            $movie->setPoster($this->getRequestParam('poster'));
            $movie->setPlot($this->getRequestParam('plot'));
        }
        $favData = [
            'rating' => $this->getRequestParam('rating'),
            'comment' => $this->getRequestParam('comment')
        ];

        $res = $this->getService()->addToFavourites($user, $movie, $favData);
        if ($res) {
            $this->redirect('/?action=search&title=' . $movie->getTitle());
        }
        return true;
    }

    public function removeFromFavourites()
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            return false;
        }

        $movieId = (int) $this->getRequestParam('id');
        if (!$movieId){
            return false;
        }

        $this->getService()->removeFromFavourites($user, $movieId);
        $this->redirect('/?action=list');
        return true;
    }

    public function viewFavourites()
    {
        $user = $this->getCurrentUser();
        if (!$user) {
            $errorMessage = 'User required';
            include 'templates/view.phtml';
            return true;
        }

        $favourites = $this->getService()->getFavouritesList($user);

        include 'templates/view.phtml';
        return true;
    }
}