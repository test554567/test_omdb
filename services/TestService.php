<?php

class TestService
{
    protected $_mapper;

    protected $_plot = 'short';
    protected $_type = 'movie';
    protected $_responseType = 'json';
    protected $_key;

    /**
     * @param string $key
     */
    public function __construct(string $key) {
        $this->_key = $key;
    }

    public function getMapper()
    {
        if(!$this->_mapper) {
            $this->_mapper = new TestMapper();
        }
        return $this->_mapper;
    }

    /**
     * @param string $title
     * @return Movie
     */
    public function getMovieByTitle(string $title)
    {
        if (!$title) {
            return false;
        }

        try {
            $response = $this->getCURL('http://www.omdbapi.com/' .
                '?t=' . urlencode($title) .
                '&apikey=' . $this->_key .
                '&plot=' . $this->_plot .
                '&r=' . $this->_responseType .
                '&type=' . $this->_type);
        } catch (Exception $e) {
            error_log ('Data retrieve error' . $e->getMessage());
            return false;
        }

        if ($response['Response'] != 'True') {
            return false;
        }

        $movie = new Movie();
        $movie->setTitle($response['Title']);
        $movie->setYear($response['Year']);
        $movie->setImdbId($response['imdbID']);
        $poster = ($response['Poster'] && $response['Poster'] != 'N/A') ?
            $response['Poster'] :
            Movie::$defaultPoster;
        $movie->setPoster($poster);
        $movie->setPlot($response['Plot']);

        return $movie;
    }

    public function addToFavourites(User $user, Movie $movie, array $favData)
    {
        return $this->getMapper()->addToFavourites($user, $movie, $favData);
    }

    public function removeFromFavourites(User $user, int $movieId)
    {
        $movie = $this->getMovieById($movieId);
        if (!$movie) {
            return false;
        }
        return $this->getMapper()->removeFromFavourites($user, $movie);
    }

    public function getMovieById(int $id)
    {
        if (!$id) {
            return false;
        }
        return $this->getMapper()->fetchMovieById($id);
    }

    public function getMovieByImdbId(string $imdbId)
    {
        if (!$imdbId) {
            return false;
        }
        return $this->getMapper()->fetchMovieByImdbId($imdbId);
    }

    public function getFavouriteMovieByImdbId(User $user, string $id)
    {
        if (!$id) {
            return false;
        }
        return $this->getMapper()->fetchFavouriteMovieByImdbId($user, $id);
    }

    public function getFavouritesList(User $user)
    {
        return $user->getFavourites();
    }

    public function getCurrentUser()
    {
        //TODO user sessions
        $userId = $_COOKIE['user'] ? $_COOKIE['user'] : 1;
        $user = $this->getMapper()->fetchUserById($userId);
        if (!$user) {
            return false;
        }
        return $user;
    }

    public function getCURL($CURLOPT_URL)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_URL, $CURLOPT_URL);
        $result = curl_exec($ch);
        curl_close($ch);
        return json_decode($result,true);
    }

}