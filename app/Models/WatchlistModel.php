<?php
// ============================================
// WATCHLIST MODEL
// File: app/Models/WatchlistModel.php
// ============================================

namespace App\Models;

use CodeIgniter\Model;

class WatchlistModel extends Model
{
    protected $table = 'watchlist';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'movie_id', 'is_watched'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Get semua film di watchlist user
    public function getUserWatchlist($userId, $watched = null)
    {
        $builder = $this->db->table('watchlist w')
            ->select('m.*, w.created_at as added_at, w.is_watched')
            ->join('movies m', 'm.id = w.movie_id')
            ->where('w.user_id', $userId);

        if ($watched !== null) {
            $builder->where('w.is_watched', $watched);
        }

        return $builder->orderBy('w.created_at', 'DESC')->get()->getResultArray();
    }

    // Cek apakah movie ada di watchlist
    public function isInWatchlist($userId, $movieId)
    {
        return $this->where(['user_id' => $userId, 'movie_id' => $movieId])->first() !== null;
    }

    // Toggle watchlist (add/remove)
    public function toggleWatchlist($userId, $movieId)
    {
        $watch = $this->where(['user_id' => $userId, 'movie_id' => $movieId])->first();

        if ($watch) {
            // Sudah ada, hapus
            $this->delete($watch['id']);
            return ['status' => 'removed', 'message' => 'Film dihapus dari watchlist'];
        } else {
            // Belum ada, tambah
            $this->insert(['user_id' => $userId, 'movie_id' => $movieId]);
            return ['status' => 'added', 'message' => 'Film ditambahkan ke watchlist'];
        }
    }

    // Mark as watched
    public function markAsWatched($userId, $movieId)
    {
        $watch = $this->where(['user_id' => $userId, 'movie_id' => $movieId])->first();
        
        if ($watch) {
            $this->update($watch['id'], ['is_watched' => 1]);
            return ['status' => 'success', 'message' => 'Film ditandai sudah ditonton'];
        }
        
        return ['status' => 'error', 'message' => 'Film tidak ditemukan di watchlist'];
    }

    // Get total watchlist
    public function getTotalWatchlist($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }
}