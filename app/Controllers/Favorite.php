<?php

namespace App\Controllers;

use App\Models\FavoriteModel;
use App\Models\MovieModel;

class Favorite extends BaseController
{
    protected $favoriteModel;
    protected $movieModel;

    public function __construct()
    {
        $this->favoriteModel = new FavoriteModel();
        $this->movieModel = new MovieModel();
        helper(['form', 'url']);
    }


    public function index()
    {
        $userId = session()->get('user_id');
        
        $genre = $this->request->getGet('genre');
        $rating = $this->request->getGet('rating');
        $sort = $this->request->getGet('sort') ?? 'newest';

        $favorites = $this->favoriteModel->getUserFavorites($userId, $genre, $rating);
        
        if ($sort === 'rating') {
            usort($favorites, function($a, $b) {
                return $b['rating'] <=> $a['rating'];
            });
        }

        $totalFavorites = $this->favoriteModel->getTotalFavorites($userId);

        $allGenres = $this->movieModel->select('genre')->distinct()->findAll();
        $genres = [];
        foreach ($allGenres as $movie) {
            if (!empty($movie['genre'])) {
                $movieGenres = explode(',', $movie['genre']);
                foreach ($movieGenres as $g) {
                    $trimmed = trim($g);
                    if (!empty($trimmed)) {
                        $genres[] = $trimmed;
                    }
                }
            }
        }
        $genres = array_unique($genres);
        sort($genres);

        $recommendations = $this->getRecommendations($userId);

        $data = [
            'title' => 'Film Favorit',
            'favorites' => $favorites,
            'total_favorites' => $totalFavorites,
            'genres' => $genres,
            'recommendations' => $recommendations,
            'current_genre' => $genre,
            'current_rating' => $rating,
            'current_sort' => $sort
        ];

        return view('favorite/index', $data);
    }

    public function toggle()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request'
            ])->setStatusCode(400);
        }

        $userId = session()->get('user_id');
        $movieId = $this->request->getPost('movie_id');

        if (empty($movieId) || !is_numeric($movieId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Movie ID tidak valid'
            ])->setStatusCode(400);
        }

        $movie = $this->movieModel->find($movieId);
        if (!$movie) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Film tidak ditemukan'
            ])->setStatusCode(404);
        }

        $result = $this->favoriteModel->toggleFavorite($userId, $movieId);

        return $this->response->setJSON([
            'success' => true,
            'status' => $result['status'],
            'message' => $result['message']
        ])->setStatusCode(200);
    }

    private function getRecommendations($userId, $limit = 4)
    {
        $favorites = $this->favoriteModel->getUserFavorites($userId);
        
        if (empty($favorites)) {
            return $this->movieModel
                ->orderBy('rating', 'DESC')
                ->limit($limit)
                ->findAll();
        }

        $firstFavorite = $favorites[0];
        if (!empty($firstFavorite['genre'])) {
            $genres = explode(',', $firstFavorite['genre']);
            $mainGenre = trim($genres[0]);

            return $this->movieModel->getRecommendations($mainGenre, null, $limit);
        }

        return $this->movieModel
            ->orderBy('rating', 'DESC')
            ->limit($limit)
            ->findAll();
    }

    public function checkStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['favorites' => []])->setStatusCode(400);
        }

        $userId = session()->get('user_id');
        $movieIds = $this->request->getPost('movie_ids');

        if (empty($movieIds) || !is_array($movieIds)) {
            return $this->response->setJSON(['favorites' => []]);
        }

        $favorites = [];
        foreach ($movieIds as $movieId) {
            if (is_numeric($movieId)) {
                $favorites[$movieId] = $this->favoriteModel->isFavorite($userId, $movieId);
            }
        }

        return $this->response->setJSON(['favorites' => $favorites]);
    }
}