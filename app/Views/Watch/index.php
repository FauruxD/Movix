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
            background-color: #0a0a0a;
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

        .hero-section {
            position: relative;
            height: 500px;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), 
                        url('<?= !empty($watchlist) ? esc($watchlist[0]['poster_url']) : 'https://via.placeholder.com/1920x500' ?>') center/cover;
            display: flex;
            align-items: center;
            padding: 0 50px;
        }

        .hero-content {
            max-width: 600px;
        }

        .hero-badge {
            background-color: #FFD700;
            color: #000;
            padding: 6px 15px;
            border-radius: 5px;
            display: inline-block;
            margin-bottom: 15px;
            font-size: 14px;
            font-weight: bold;
        }

        .hero-title {
            font-size: 48px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .hero-subtitle {
            color: #ccc;
            font-size: 16px;
            margin-bottom: 25px;
            line-height: 1.6;
        }

        .hero-buttons {
            display: flex;
            gap: 15px;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: all 0.3s;
            text-decoration: none;
        }

        .btn-primary {
            background-color: #FFD700;
            color: #000;
            font-weight: bold;
        }

        .btn-primary:hover {
            background-color: #FFC700;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
        }

        .btn-secondary {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fff;
        }

        .btn-secondary:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 50px;
        }

        .section-title {
            font-size: 28px;
            margin-bottom: 30px;
        }

        .movie-slider {
            display: flex;
            gap: 20px;
            overflow-x: auto;
            padding-bottom: 20px;
            scrollbar-width: thin;
            scrollbar-color: #FFD700 #2a2a2a;
        }

        .movie-slider::-webkit-scrollbar {
            height: 8px;
        }

        .movie-slider::-webkit-scrollbar-track {
            background: #2a2a2a;
            border-radius: 10px;
        }

        .movie-slider::-webkit-scrollbar-thumb {
            background: #FFD700;
            border-radius: 10px;
        }

        .movie-card {
            min-width: 200px;
            max-width: 200px;
            position: relative;
            border-radius: 10px;
            overflow: hidden;
            transition: transform 0.3s, box-shadow 0.3s;
            cursor: pointer;
            background-color: #1a1a1a;
        }

        .movie-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(255, 215, 0, 0.3);
        }

        .movie-poster {
            width: 100%;
            height: 300px;
            object-fit: cover;
        }

        .movie-rating {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: #FFD700;
            color: #000;
            padding: 5px 10px;
            border-radius: 5px;
            font-weight: bold;
            font-size: 14px;
        }

        .movie-info {
            padding: 15px;
        }

        .movie-title {
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 5px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .movie-genre {
            color: #888;
            font-size: 13px;
            margin-bottom: 10px;
        }

        .movie-actions {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }

        .action-btn {
            flex: 1;
            padding: 8px;
            background-color: #2a2a2a;
            border: none;
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
            transition: all 0.3s;
        }

        .action-btn:hover {
            background-color: #3a3a3a;
        }

        .watch-btn {
            background-color: #FFD700;
            color: #000;
            font-weight: bold;
        }

        .watch-btn:hover {
            background-color: #FFC700;
        }

        .empty-state {
            text-align: center;
            padding: 100px 20px;
        }

        .empty-state h2 {
            font-size: 32px;
            margin-bottom: 15px;
            color: #FFD700;
        }

        .empty-state p {
            color: #888;
            font-size: 18px;
            margin-bottom: 30px;
        }

        .empty-state .btn-explore {
            display: inline-block;
            padding: 12px 30px;
            background-color: #FFD700;
            color: #000;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s;
        }

        .empty-state .btn-explore:hover {
            background-color: #FFC700;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <a href="<?= base_url('dashboard') ?>" class="logo">MOVIX</a>
        <ul class="nav-menu">
            <li><a href="<?= base_url('dashboard') ?>">Beranda</a></li>
            <li><a href="<?= base_url('favorite') ?>">Favorit</a></li>
            <li><a href="<?= base_url('watch') ?>" class="active">Watch List</a></li>
        </ul>
        <div>
            <a href="<?= base_url('auth/logout') ?>" class="logout-btn">Logout</a>
        </div>
    </nav>

    <?php if (!empty($watchlist)): ?>
        <?php $featured = $watchlist[0]; ?>
        <div class="hero-section" style="background-image: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.8)), url('<?= esc($featured['poster_url']) ?>')">
            <div class="hero-content">
                <span class="hero-badge">⭐ <?= esc($featured['rating']) ?> • <?= esc($featured['genre']) ?></span>
                <h1 class="hero-title"><?= esc($featured['title']) ?></h1>
                <p class="hero-subtitle">
                    <?= esc(substr($featured['description'] ?? 'Film menarik yang patut ditonton!', 0, 150)) ?>...
                </p>
                <div class="hero-buttons">
                    <a href="<?= base_url('watch/player/' . $featured['id']) ?>" class="btn btn-primary">
                        ▶ Tonton Sekarang
                    </a>
                    <button class="btn btn-secondary" onclick="toggleFavorite(<?= $featured['id'] ?>)">
                        ❤️ Tambah Favorit
                    </button>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="empty-state" style="background-color: #1a1a1a;">
            <h2>📺 Watchlist Kosong</h2>
            <p>Belum ada film yang ingin Anda tonton. Mulai tambahkan sekarang!</p>
            <a href="<?= base_url('dashboard') ?>" class="btn-explore">Jelajahi Film</a>
        </div>
    <?php endif; ?>

    <?php if (!empty($recommendations)): ?>
    <div class="container">
        <h2 class="section-title">🎬 Film Lainnya</h2>
        <div class="movie-slider">
            <?php foreach ($recommendations as $movie): ?>
                <div class="movie-card">
                    <span class="movie-rating">⭐ <?= number_format($movie['rating'], 1) ?></span>
                    <img src="<?= esc($movie['poster_url']) ?>" alt="<?= esc($movie['title']) ?>" class="movie-poster" onerror="this.src='https://via.placeholder.com/200x300?text=No+Image'">
                    <div class="movie-info">
                        <div class="movie-title"><?= esc($movie['title']) ?></div>
                        <div class="movie-genre"><?= esc($movie['genre']) ?></div>
                        <div class="movie-actions">
                            <button class="action-btn" onclick="toggleWatchlist(<?= $movie['id'] ?>)">
                                <?= $movie['in_watchlist'] ? '✓ Watchlist' : '+ Watchlist' ?>
                            </button>
                            <button class="action-btn watch-btn" onclick="window.location.href='<?= base_url('watch/player/' . $movie['id']) ?>'">
                                Tonton
                            </button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function toggleWatchlist(movieId) {
            fetch('<?= base_url('watch/toggle') ?>', {
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

        function toggleFavorite(movieId) {
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
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    </script>
</body>
</html>