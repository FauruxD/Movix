<?php

namespace App\Models;

use CodeIgniter\Model;

class MovieModel extends Model
{
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'year', 'genre', 'rating', 'duration', 'description', 'poster_url', 'video_url'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getMovieWithUserStatus($movieId, $userId = null)
    {
        $movie = $this->find($movieId);
        
        if ($movie && $userId) {
            $favoriteModel = new FavoriteModel();
            $watchlistModel = new WatchlistModel();
            
            $movie['is_favorite'] = $favoriteModel->isFavorite($userId, $movieId);
            $movie['in_watchlist'] = $watchlistModel->isInWatchlist($userId, $movieId);
        }
        
        return $movie;
    }

    public function getRecommendations($genre, $currentMovieId = null, $limit = 4)
    {
        $builder = $this->like('genre', $genre)
                        ->orderBy('rating', 'DESC')
                        ->limit($limit);
        
        if ($currentMovieId) {
            $builder->where('id !=', $currentMovieId);
        }
        
        return $builder->findAll();
    }

    public function searchMovies($keyword)
    {
        return $this->like('title', $keyword)
                    ->orLike('genre', $keyword)
                    ->orLike('description', $keyword)
                    ->orderBy('rating', 'DESC')
                    ->findAll();
    }

    public function getAllMovies()
    {
        return $this->orderBy('created_at', 'DESC')->findAll();
    }

    public function getMoviesByGenre($genre, $limit = null)
    {
        $builder = $this->like('genre', $genre)
                        ->orderBy('rating', 'DESC');
        
        if ($limit) {
            $builder->limit($limit);
        }
        
        return $builder->findAll();
    }

    public function getTopRatedMovies($limit = 10)
    {
        return $this->orderBy('rating', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }

    public function getLatestMovies($limit = 10)
    {
        return $this->orderBy('created_at', 'DESC')
                    ->limit($limit)
                    ->findAll();
    }
}