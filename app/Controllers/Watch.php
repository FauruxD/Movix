<?php


namespace App\Controllers;

use App\Models\WatchlistModel;
use App\Models\MovieModel;
use App\Models\FavoriteModel;

class Watch extends BaseController
{
    protected $watchlistModel;
    protected $movieModel;
    protected $favoriteModel;

    public function __construct()
    {
        $this->watchlistModel = new WatchlistModel();
        $this->movieModel = new MovieModel();
        $this->favoriteModel = new FavoriteModel();
        helper(['form', 'url']);
    }

    public function index()
    {
        $userId = session()->get('user_id');

        $watchlist = $this->watchlistModel->getUserWatchlist($userId, false);

        $recommendations = $this->movieModel
            ->orderBy('rating', 'DESC')
            ->limit(6)
            ->findAll();

        foreach ($recommendations as &$movie) {
            $movie['is_favorite'] = $this->favoriteModel->isFavorite($userId, $movie['id']);
            $movie['in_watchlist'] = $this->watchlistModel->isInWatchlist($userId, $movie['id']);
        }

        $data = [
            'title' => 'Watch List',
            'watchlist' => $watchlist,
            'recommendations' => $recommendations,
            'user_id' => $userId
        ];

        return view('watch/index', $data);
    }

    public function player($movieId = null)
    {
        $userId = session()->get('user_id');

        if (empty($movieId) || !is_numeric($movieId)) {
            return redirect()->to('/watch')
                ->with('error', 'ID Film tidak valid');
        }

        $movie = $this->movieModel->getMovieWithUserStatus($movieId, $userId);

        if (!$movie) {
            return redirect()->to('/watch')
                ->with('error', 'Film tidak ditemukan');
        }

        $this->watchlistModel->markAsWatched($userId, $movieId);

        $data = [
            'title' => $movie['title'],
            'movie' => $movie,
            'user_id' => $userId
        ];

        return view('watch/player', $data);
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

        $result = $this->watchlistModel->toggleWatchlist($userId, $movieId);

        return $this->response->setJSON([
            'success' => true,
            'status' => $result['status'],
            'message' => $result['message']
        ])->setStatusCode(200);
    }

    public function markWatched()
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

        $result = $this->watchlistModel->markAsWatched($userId, $movieId);

        return $this->response->setJSON([
            'success' => $result['status'] === 'success',
            'message' => $result['message']
        ]);
    }

    public function checkStatus()
    {
        if (!$this->request->isAJAX()) {
            return $this->response->setJSON(['watchlist' => []])->setStatusCode(400);
        }

        $userId = session()->get('user_id');
        $movieIds = $this->request->getPost('movie_ids');

        if (empty($movieIds) || !is_array($movieIds)) {
            return $this->response->setJSON(['watchlist' => []]);
        }

        $watchlist = [];
        foreach ($movieIds as $movieId) {
            if (is_numeric($movieId)) {
                $watchlist[$movieId] = $this->watchlistModel->isInWatchlist($userId, $movieId);
            }
        }

        return $this->response->setJSON(['watchlist' => $watchlist]);
    }
}