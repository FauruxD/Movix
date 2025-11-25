<?php
// ============================================
// FAVORITE MODEL
// File: app/Models/FavoriteModel.php
// ============================================

namespace App\Models;

use CodeIgniter\Model;

class FavoriteModel extends Model
{
    protected $table = 'favorites';
    protected $primaryKey = 'id';
    protected $allowedFields = ['user_id', 'movie_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';

    // Get semua film favorit user dengan detail movie
    public function getUserFavorites($userId, $genre = null, $rating = null)
    {
        $builder = $this->db->table('favorites f')
            ->select('m.*, f.created_at as favorited_at')
            ->join('movies m', 'm.id = f.movie_id')
            ->where('f.user_id', $userId);

        if ($genre) {
            $builder->like('m.genre', $genre);
        }

        if ($rating) {
            $builder->where('m.rating >=', $rating);
        }

        return $builder->orderBy('f.created_at', 'DESC')->get()->getResultArray();
    }

    // Cek apakah movie sudah difavoritkan
    public function isFavorite($userId, $movieId)
    {
        return $this->where(['user_id' => $userId, 'movie_id' => $movieId])->first() !== null;
    }

    // Toggle favorite (add/remove)
    public function toggleFavorite($userId, $movieId)
    {
        $favorite = $this->where(['user_id' => $userId, 'movie_id' => $movieId])->first();

        if ($favorite) {
            // Sudah ada, hapus
            $this->delete($favorite['id']);
            return ['status' => 'removed', 'message' => 'Film dihapus dari favorit'];
        } else {
            // Belum ada, tambah
            $this->insert(['user_id' => $userId, 'movie_id' => $movieId]);
            return ['status' => 'added', 'message' => 'Film ditambahkan ke favorit'];
        }
    }

    // Get total favorit user
    public function getTotalFavorites($userId)
    {
        return $this->where('user_id', $userId)->countAllResults();
    }
}