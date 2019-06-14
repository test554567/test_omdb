<?php

//TODO cacher

require_once 'MapperAbstract.php';

class TestMapper extends MapperAbstract
{
    public function addToFavourites($user, $movie, $favData)
    {
        $favourite = $this->getEntityManager()->getRepository('Favourite')
            ->findOneBy([
                'user' => $user,
                'movie' => $movie
            ]);
        if (!$favourite) {
            $favourite = new Favourite();
            $favourite->setUser($user);
            $favourite->setMovie($movie);
        }
        if($favData['rating']) {
            $favourite->setRating($favData['rating']);
        }
        $favourite->setComment($favData['comment']);

        $this->getEntityManager()->persist($favourite);
        $this->getEntityManager()->flush();

        return $favourite->getId();
    }

    public function removeFromFavourites($user, $movie)
    {
        $favourite = $this->getEntityManager()->getRepository('Favourite')
            ->findOneBy([
                'user' => $user,
                'movie' => $movie
            ]);
        if (!$favourite) {
            return false;
        }
        $this->getEntityManager()->remove($favourite);
        $this->getEntityManager()->flush();

        return true;
    }

    public function fetchFavouriteMovieByImdbId($user, $id)
    {
        $dql = 'SELECT f FROM Favourite f JOIN f.movie m '.
            'WHERE f.user = ?1 AND m.imdbId = ?2';

        $favourite = $this->getEntityManager()->createQuery($dql)
            ->setParameter(1, $user->getId())
            ->setParameter(2, $id)
            ->setMaxResults(1)
            ->getResult();
        if (!$favourite) {
            return false;
        }

        return $favourite[0];
    }

    public function fetchMovieById($id)
    {
        return $this->getEntityManager()->find('Movie', $id);
    }

    public function fetchMovieByImdbId($id)
    {
        $movie = $this->getEntityManager()->getRepository('Movie')
            ->findOneBy(['imdbId' => $id]);
        if (!$movie) {
            return false;
        }
        return $movie;
    }

    public function fetchUserById($userId)
    {
        $user = $this->getEntityManager()->find('User', $userId);
        //TODO sessions
        if (!$user) {
            $user = new User();
            $user->setName('test');
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            setcookie('user', $user->getId());
        }
        return $user;
    }

}