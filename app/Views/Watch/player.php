<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($movie['title']) ?> - Movix Player</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #000;
            color: #fff;
            overflow-x: hidden;
        }

        .player-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 30px;
            background-color: rgba(0, 0, 0, 0.95);
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 10px rgba(0,0,0,0.5);
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .back-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background-color: rgba(255, 215, 0, 0.2);
            color: #FFD700;
        }

        .movie-title-header {
            font-size: 20px;
            font-weight: bold;
        }

        .header-actions {
            display: flex;
            gap: 15px;
        }

        .header-btn {
            padding: 8px 20px;
            background-color: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .header-btn:hover {
            background-color: rgba(255, 215, 0, 0.2);
            border-color: #FFD700;
        }

        .player-container {
            position: relative;
            width: 100%;
            max-width: 100vw;
            height: calc(100vh - 250px);
            background-color: #000;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            height: 100%;
        }

        video {
            width: 100%;
            height: 100%;
            object-fit: contain;
            background-color: #000;
        }

        .video-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.9));
            opacity: 0;
            transition: opacity 0.3s;
        }

        .player-container:hover .video-controls,
        .video-controls.active {
            opacity: 1;
        }

        .progress-bar {
            width: 100%;
            height: 6px;
            background-color: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
            margin-bottom: 15px;
            cursor: pointer;
            position: relative;
        }

        .progress-filled {
            height: 100%;
            background-color: #FFD700;
            border-radius: 3px;
            width: 0%;
            transition: width 0.1s;
        }

        .controls-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .controls-left {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .control-btn {
            background: none;
            border: none;
            color: #fff;
            font-size: 18px;
            cursor: pointer;
            padding: 8px;
            border-radius: 5px;
            transition: all 0.3s;
        }

        .control-btn:hover {
            background-color: rgba(255, 215, 0, 0.2);
            color: #FFD700;
        }

        .play-btn {
            font-size: 28px;
        }

        .volume-control {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .volume-slider {
            width: 80px;
        }

        .time-display {
            color: #fff;
            font-size: 14px;
        }

        .controls-right {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .movie-info-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 40px 50px;
            background-color: #0a0a0a;
        }

        .movie-details {
            display: flex;
            gap: 30px;
            align-items: flex-start;
        }

        .movie-poster-small {
            width: 200px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }

        .movie-content {
            flex: 1;
        }

        .movie-title {
            font-size: 36px;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .movie-meta {
            display: flex;
            gap: 20px;
            margin-bottom: 20px;
            color: #888;
            font-size: 16px;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .meta-item strong {
            color: #FFD700;
        }

        .movie-description {
            line-height: 1.8;
            color: #ccc;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .loading-placeholder {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 100%;
            font-size: 20px;
            color: #888;
        }

        .play-icon {
            width: 80px;
            height: 80px;
            background-color: rgba(255, 215, 0, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #FFD700;
            margin-bottom: 20px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .play-icon:hover {
            background-color: rgba(255, 215, 0, 0.4);
            transform: scale(1.1);
        }
    </style>
</head>
<body>
    <div class="player-header">
        <div class="header-left">
            <button class="back-btn" onclick="history.back()">
                ← Kembali
            </button>
            <h1 class="movie-title-header"><?= esc($movie['title']) ?></h1>
        </div>
        <div class="header-actions">
            <button class="header-btn" onclick="toggleFavorite(<?= $movie['id'] ?>)">
                ❤️ Favorit
            </button>
            <button class="header-btn" onclick="toggleWatchlist(<?= $movie['id'] ?>)">
                📋 Watchlist
            </button>
        </div>
    </div>

    <div class="player-container">
        <div class="video-wrapper">
            <?php if (!empty($movie['video_url'])): ?>
                <video id="moviePlayer" poster="<?= esc($movie['poster_url']) ?>">
                    <source src="<?= esc($movie['video_url']) ?>" type="video/mp4">
                    Browser Anda tidak mendukung video player.
                </video>
            <?php else: ?>
                <div class="loading-placeholder">
                    <div class="play-icon">▶</div>
                    <p>Video tidak tersedia</p>
                </div>
            <?php endif; ?>

            <?php if (!empty($movie['video_url'])): ?>
            <div class="video-controls">
                <div class="progress-bar" id="progressBar">
                    <div class="progress-filled" id="progressFilled"></div>
                </div>
                
                <div class="controls-row">
                    <div class="controls-left">
                        <button class="control-btn play-btn" id="playBtn">▶</button>
                        
                        <div class="volume-control">
                            <button class="control-btn" id="volumeBtn">🔊</button>
                            <input type="range" class="volume-slider" id="volumeSlider" min="0" max="100" value="100">
                        </div>
                        
                        <span class="time-display">
                            <span id="currentTime">00:00</span> / <span id="duration">00:00</span>
                        </span>
                    </div>
                    
                    <div class="controls-right">
                        <button class="control-btn" id="speedBtn">1x</button>
                        <button class="control-btn" id="fullscreenBtn">⛶</button>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="movie-info-section">
        <div class="movie-details">
            <img src="<?= esc($movie['poster_url']) ?>" alt="<?= esc($movie['title']) ?>" class="movie-poster-small" onerror="this.src='https://via.placeholder.com/200x300?text=No+Image'">
            
            <div class="movie-content">
                <h2 class="movie-title"><?= esc($movie['title']) ?></h2>
                
                <div class="movie-meta">
                    <span class="meta-item">
                        <strong><?= esc($movie['year']) ?></strong>
                    </span>
                    <span class="meta-item">
                        • <strong><?= esc($movie['genre']) ?></strong>
                    </span>
                    <span class="meta-item">
                        • <strong><?= esc($movie['duration']) ?></strong>
                    </span>
                    <span class="meta-item">
                        • ⭐ <strong><?= number_format($movie['rating'], 1) ?></strong>
                    </span>
                </div>
                
                <p class="movie-description">
                    <?= esc($movie['description'] ?? 'Deskripsi film tidak tersedia.') ?>
                </p>
            </div>
        </div>
    </div>

    <script>
        <?php if (!empty($movie['video_url'])): ?>
        const video = document.getElementById('moviePlayer');
        const playBtn = document.getElementById('playBtn');
        const progressBar = document.getElementById('progressBar');
        const progressFilled = document.getElementById('progressFilled');
        const currentTimeEl = document.getElementById('currentTime');
        const durationEl = document.getElementById('duration');
        const volumeBtn = document.getElementById('volumeBtn');
        const volumeSlider = document.getElementById('volumeSlider');
        const speedBtn = document.getElementById('speedBtn');
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const controls = document.querySelector('.video-controls');

        playBtn.addEventListener('click', togglePlay);
        video.addEventListener('click', togglePlay);

        function togglePlay() {
            if (video.paused) {
                video.play();
                playBtn.textContent = '⏸';
            } else {
                video.pause();
                playBtn.textContent = '▶';
            }
        }

        video.addEventListener('timeupdate', () => {
            const percent = (video.currentTime / video.duration) * 100;
            progressFilled.style.width = percent + '%';
            currentTimeEl.textContent = formatTime(video.currentTime);
        });

        video.addEventListener('loadedmetadata', () => {
            durationEl.textContent = formatTime(video.duration);
        });

        progressBar.addEventListener('click', (e) => {
            const rect = progressBar.getBoundingClientRect();
            const percent = (e.clientX - rect.left) / rect.width;
            video.currentTime = percent * video.duration;
        });

        volumeSlider.addEventListener('input', (e) => {
            video.volume = e.target.value / 100;
            updateVolumeIcon();
        });

        volumeBtn.addEventListener('click', () => {
            video.muted = !video.muted;
            updateVolumeIcon();
        });

        function updateVolumeIcon() {
            if (video.muted || video.volume === 0) {
                volumeBtn.textContent = '🔇';
            } else if (video.volume < 0.5) {
                volumeBtn.textContent = '🔉';
            } else {
                volumeBtn.textContent = '🔊';
            }
        }

        const speeds = [0.5, 1, 1.5, 2];
        let currentSpeed = 1;
        speedBtn.addEventListener('click', () => {
            const currentIndex = speeds.indexOf(currentSpeed);
            currentSpeed = speeds[(currentIndex + 1) % speeds.length];
            video.playbackRate = currentSpeed;
            speedBtn.textContent = currentSpeed + 'x';
        });

        fullscreenBtn.addEventListener('click', () => {
            if (video.requestFullscreen) {
                video.requestFullscreen();
            } else if (video.webkitRequestFullscreen) {
                video.webkitRequestFullscreen();
            }
        });

        let hideControlsTimeout;
        document.querySelector('.player-container').addEventListener('mousemove', () => {
            controls.classList.add('active');
            clearTimeout(hideControlsTimeout);
            hideControlsTimeout = setTimeout(() => {
                if (!video.paused) {
                    controls.classList.remove('active');
                }
            }, 3000);
        });

        document.addEventListener('keydown', (e) => {
            if (e.code === 'Space') {
                e.preventDefault();
                togglePlay();
            } else if (e.code === 'ArrowRight') {
                video.currentTime += 10;
            } else if (e.code === 'ArrowLeft') {
                video.currentTime -= 10;
            } else if (e.code === 'ArrowUp') {
                video.volume = Math.min(1, video.volume + 0.1);
                volumeSlider.value = video.volume * 100;
            } else if (e.code === 'ArrowDown') {
                video.volume = Math.max(0, video.volume - 0.1);
                volumeSlider.value = video.volume * 100;
            }
        });

        function formatTime(seconds) {
            if (isNaN(seconds)) return '00:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        }
        <?php endif; ?>

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
                alert(data.success ? data.message : 'Error: ' + data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }

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
                alert(data.success ? data.message : 'Error: ' + data.message);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Terjadi kesalahan. Silakan coba lagi.');
            });
        }
    </script>
</body>
</html>