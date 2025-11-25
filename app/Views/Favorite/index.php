<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="base-url" content="<?= base_url() ?>">
    <title><?= esc($title) ?> - Movix</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #141414;
            color: #fff;
            min-height: 100vh;
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 50px;
            background-color: #1a1a1a;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
        }

        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #FFD700;
            text-decoration: none;
        }

        .nav-menu {
            display: flex;
            gap: 30px;
            list-style: none;
            align-items: center;
        }

        .nav-menu a {
            color: #fff;
            text-decoration: none;
            font-size: 16px;
            transition: color 0.3s;
            padding: 8px 15px;
            border-radius: 5px;
        }

        .nav-menu a:hover, .nav-menu a.active {
            color: #FFD700;
            background-color: rgba(255, 215, 0, 0.1);
        }

        .user-section {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .logout-btn {
            padding: 8px 20px;
            background-color: #dc3545;
            color: #fff;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .logout-btn:hover {
            background-color: #c82333;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 50px;
        }

        .page-header {
            margin-bottom: 30px;
        }

        .page-header h1 {
            font-size: 36px;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .page-header p {
            color: #888;
            font-size: 16px;
        }

        .total-badge {
            display: inline-block;
            background-color: #FFD700;
            color: #000;
            padding: 5px 18px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 18px;
        }

        .filter-section {
            display: flex;
            gap: 15px;
            margin-bottom: 30px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-select {
            padding: 12px 20px;
            background-color: #2a2a2a;
            color: #fff;
            border: 1px solid #444;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s;
        }

        .filter-select:hover {
            border-color: #FFD700;
        }

        .filter-select:focus {
            outline: none;
            border-color: #FFD700;
        }

        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
            gap: 25px;
            margin-bottom: 50px;
        }

        .movie-card {
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            background-color: #1a1a1a;
        }

        .movie-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
        }

        .movie-poster {
            width: 100%;
            height: 330px;
            object-fit: cover;
            display: block;
        }

        .movie-info {
            padding: 15px;
        }

        .movie-rating {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #FFD700;
            color: #000;
            padding: 6px 12px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .movie-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 8px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie-genre {
            color: #888;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .movie-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 10px;
        }

        .movie-year {
            color: #aaa;
            font-size: 13px;
        }

        .favorite-btn {
            background: none;
            border: none;
            color: #FF4444;
            font-size: 22px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .favorite-btn:hover {
            transform: scale(1.2);
        }

        .recommendations {
            margin-top: 60px;
        }

        .recommendations h2 {
            font-size: 28px;
            margin-bottom: 25px;
        }

        .no-favorites {
            text-align: center;
            padding: 100px 20px;
        }

        .no-favorites h2 {
            font-size: 32px;
            margin-bottom: 20px;
            color: #FFD700;
        }

        .no-favorites p {
            color: #888;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .btn-explore {
            display: inline-block;
            padding: 12px 30px;
            background-color: #FFD700;
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .btn-explore:hover {
            background-color: #FFC700;
            transform: translateY(-2px);
        }

        .loading {
            text-align: center;
            padding: 50px;
            font-size: 18px;
            color: #888;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="<?= base_url('dashboard') ?>" class="logo">MOVIX</a>
        <ul class="nav-menu">
            <li><a href="<?= base_url('dashboard') ?>">Beranda</a></li>
            <li><a href="<?= base_url('favorite') ?>" class="active">Favorit</a></li>
            <li><a href="<?= base_url('watch') ?>">Watch List</a></li>
        </ul>
        <div class="user-section">
            <a href="<?= base_url('auth/logout') ?>" class="logout-btn">Logout</a>
        </div>
    </nav>

    <div class="container">

        <div class="page-header">
            <h1>
                Film Favorit 
                <span class="total-badge"><?= $total_favorites ?></span>
            </h1>
            <p>Koleksi film yang sudah Anda simpan</p>
        </div>

        <div class="filter-section">
            <select class="filter-select" id="genreFilter" onchange="applyFilter()">
                <option value="">📁 Semua Genre</option>
                <?php foreach ($genres as $genre): ?>
                    <option value="<?= esc($genre) ?>" <?= $current_genre == $genre ? 'selected' : '' ?>>
                        <?= esc($genre) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select class="filter-select" id="ratingFilter" onchange="applyFilter()">
                <option value="">⭐ Semua Rating</option>
                <option value="8" <?= $current_rating == '8' ? 'selected' : '' ?>>8.0+</option>
                <option value="7" <?= $current_rating == '7' ? 'selected' : '' ?>>7.0+</option>
                <option value="6" <?= $current_rating == '6' ? 'selected' : '' ?>>6.0+</option>
            </select>

            <select class="filter-select" id="sortFilter" onchange="applyFilter()">
                <option value="newest" <?= $current_sort == 'newest' ? 'selected' : '' ?>>🕒 Baru Ditambahkan</option>
                <option value="rating" <?= $current_sort == 'rating' ? 'selected' : '' ?>>⭐ Rating Tertinggi</option>
            </select>
        </div>

        <?php if (!empty($favorites)): ?>
            <div class="movie-grid">
                <?php foreach ($favorites as $movie): ?>
                    <div class="movie-card" onclick="window.location.href='<?= base_url('watch/player/' . $movie['id']) ?>'">
                        <span class="movie-rating">⭐ <?= number_format($movie['rating'], 1) ?></span>
                        <img src="<?= esc($movie['poster_url']) ?>" alt="<?= esc($movie['title']) ?>" class="movie-poster" onerror="this.src='https://via.placeholder.com/220x330?text=No+Image'">
                        <div class="movie-info">
                            <div class="movie-title"><?= esc($movie['title']) ?></div>
                            <div class="movie-genre"><?= esc($movie['genre']) ?></div>
                            <div class="movie-meta">
                                <span class="movie-year"><?= esc($movie['year']) ?></span>
                                <button class="favorite-btn" onclick="event.stopPropagation(); removeFavorite(<?= $movie['id'] ?>)" title="Hapus dari favorit">
                                    ❤️
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-favorites">
                <h2>📽️ Belum Ada Film Favorit</h2>
                <p>Mulai tambahkan film favorit Anda sekarang!</p>
                <a href="<?= base_url('dashboard') ?>" class="btn-explore">Jelajahi Film</a>
            </div>
        <?php endif; ?>

        <?php if (!empty($recommendations)): ?>
            <div class="recommendations">
                <h2>🎬 Rekomendasi Untukmu</h2>
                <div class="movie-grid">
                    <?php foreach ($recommendations as $movie): ?>
                        <div class="movie-card" onclick="window.location.href='<?= base_url('watch/player/' . $movie['id']) ?>'">
                            <span class="movie-rating">⭐ <?= number_format($movie['rating'], 1) ?></span>
                            <img src="<?= esc($movie['poster_url']) ?>" alt="<?= esc($movie['title']) ?>" class="movie-poster" onerror="this.src='https://via.placeholder.com/220x330?text=No+Image'">
                            <div class="movie-info">
                                <div class="movie-title"><?= esc($movie['title']) ?></div>
                                <div class="movie-genre"><?= esc($movie['genre']) ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <script>
        function applyFilter() {
            const genre = document.getElementById('genreFilter').value;
            const rating = document.getElementById('ratingFilter').value;
            const sort = document.getElementById('sortFilter').value;
            
            const params = new URLSearchParams();
            if (genre) params.append('genre', genre);
            if (rating) params.append('rating', rating);
            if (sort) params.append('sort', sort);
            
            window.location.href = '<?= base_url('favorite') ?>?' + params.toString();
        }

        function removeFavorite(movieId) {
            if (confirm('Hapus film dari favorit?')) {
                fetch('<?= base_url('favorite/toggle') ?>', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: 'movie_id=' + movieId
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                });
            }
        }
    </script>
</body>
</html>