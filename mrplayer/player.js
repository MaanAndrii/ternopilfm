// Оголошуємо змінну в глобальній області видимості
let errorLog = [];

document.addEventListener('DOMContentLoaded', () => {
    // === ОБРОБКА КОНФІГУРАЦІЇ ===
    let stationsToShow;
    const isInIframe = (window.top !== window.self);

    if (isInIframe) {
        const iframeStation = stations.find(station => station.id === playerConfig.iframe_station_id);
        stationsToShow = iframeStation ? [iframeStation] : [stations[0]];
    } else {
        stationsToShow = (playerConfig.stations_to_display > 0 && playerConfig.stations_to_display < stations.length)
            ? stations.slice(0, playerConfig.stations_to_display)
            : stations;
    }

    // === DOM ЕЛЕМЕНТИ ===
    const radioPlayerEl = document.querySelector('.radio-player');
    const stationSelector = document.querySelector('.station-selector');
    const stationNameEl = document.getElementById('stationName');
    const prevStationBtn = document.getElementById('prevStationBtn');
    const nextStationBtn = document.getElementById('nextStationBtn');
    const playBtn = document.getElementById('playBtn');
    const playIcon = document.getElementById('playIcon');
    const pauseIcon = document.getElementById('pauseIcon');
    const loader = document.getElementById('loader');
    const visualizer = document.getElementById('visualizer');
    const statusMessage = document.getElementById('statusMessage');
    const qualitySDBtn = document.getElementById('qualitySD');
    const qualityHDBtn = document.getElementById('qualityHD');
    const volumeSlider = document.getElementById('volumeSlider');
    const muteBtn = document.getElementById('muteBtn');
    const volumeOnIcon = document.getElementById('volumeOnIcon');
    const volumeMutedIcon = document.getElementById('volumeMutedIcon');
    const volumeUpIcon = document.getElementById('volumeUpIcon');

    // === СТАН ПЛЕЄРА ===
    let sound;
    let currentStationIndex = 0;
    let currentQuality = 'sd';
    let isPlaying = false;
    let retryCount = 0;
    let retryTimer;
    let wasPlayingBeforeOffline = false;
    let lastVolume = playerConfig.initialVolume;
    let silenceCheckInterval;
    let lastSeekPosition = 0;

    // === ФУНКЦІЯ ЛОГУВАННЯ ПОМИЛОК ===
    function logError(type, details) {
        const now = new Date();
        const logEntry = {
            timestamp: now.toISOString(),
            stationId: stationsToShow[currentStationIndex].id,
            errorType: type,
            streamQuality: currentQuality,
            retryAttempt: retryCount + 1,
            isOnline: navigator.onLine,
            errorDetails: details || 'Немає деталей'
        };
        errorLog.push(logEntry);
        // Обмежуємо розмір логу, щоб він не ріс безмежно за довгу сесію
        if (errorLog.length > 50) {
            errorLog.shift();
        }
        console.error("Помилку зафіксовано:", logEntry);
    }

    // === МОНІТОР ТИШІ ===
    function startSilenceMonitor() {
        stopSilenceMonitor();
        lastSeekPosition = 0;
        
        silenceCheckInterval = setInterval(() => {
            if (!sound || !sound.playing()) return;

            const currentPosition = sound.seek();
            
            if (currentPosition === lastSeekPosition && currentPosition > 0) {
                console.warn('Виявлено тишу (зависання потоку). Запускаємо перезапуск...');
                logError('stalled', 'Stream playback stalled');
                handleStreamError();
                stopSilenceMonitor();
            } else {
                lastSeekPosition = currentPosition;
            }
        }, 5000);
    }

    function stopSilenceMonitor() {
        clearInterval(silenceCheckInterval);
    }

    // === ФУНКЦІЇ КЕРУВАННЯ ВІДТВОРЕННЯМ ===
    function playStream(quality) {
        if (sound) {
            sound.unload();
        }
        clearTimeout(retryTimer);
        
        const station = stationsToShow[currentStationIndex];
        currentQuality = quality;
        updateQualityButtons();
        showLoader(true);
        if (retryCount === 0) {
            statusMessage.textContent = `Буферизація ${quality.toUpperCase()}...`;
        }

        sound = new Howl({
            src: [station.streams[quality]],
            html5: true,
            format: ['aac', 'mp3'],
            volume: volumeSlider.value,
            onplay: () => {
                isPlaying = true;
                retryCount = 0;
                updatePlayPauseIcon();
                visualizer.classList.add('active');
                showLoader(false);
                statusMessage.textContent = `В ефірі: ${quality.toUpperCase()}`;
                startSilenceMonitor();
            },
            onpause: () => {
                isPlaying = false;
                updatePlayPauseIcon();
                visualizer.classList.remove('active');
                stopSilenceMonitor();
                if (navigator.onLine) {
                  statusMessage.textContent = `Пауза`;
                }
            },
            onstop: () => {
                isPlaying = false;
                updatePlayPauseIcon();
                visualizer.classList.remove('active');
                stopSilenceMonitor();
            },
            onloaderror: (id, err) => {
                logError('load', err);
                if (navigator.onLine) handleStreamError();
            },
            onplayerror: (id, err) => {
                logError('play', err);
                if (navigator.onLine) handleStreamError();
            }
        });
        sound.play();
    }
    
    function togglePlayPause() {
        retryCount = 0;
        clearTimeout(retryTimer);
        
        if (!sound || !isPlaying && !sound.playing()) {
             playStream(currentQuality);
        } else {
            if (isPlaying) {
                sound.pause();
            }
        }
    }

    function handleStreamError() {
        stopSilenceMonitor();
        isPlaying = false;
        if (sound) {
            sound.unload();
        }

        if (retryCount < playerConfig.maxRetries) {
            retryCount++;
            statusMessage.textContent = `Помилка. Перезапуск... (${retryCount}/${playerConfig.maxRetries})`;
            showLoader(true);
            updatePlayPauseIcon();
            visualizer.classList.remove('active');

            const delay = (retryCount === 1) ? 500 : playerConfig.retryDelay;

            retryTimer = setTimeout(() => {
                playStream(currentQuality);
            }, delay);
        } else {
            showLoader(false);
            updatePlayPauseIcon();
            visualizer.classList.remove('active');
            statusMessage.textContent = 'Не вдалося підключитись.';
        }
    }
    
    function loadStation(index) {
        const wasPlaying = isPlaying;
        stopSilenceMonitor();
        if (sound) {
            sound.stop();
        }

        currentStationIndex = index;
        const station = stationsToShow[currentStationIndex];
        stationNameEl.textContent = station.name;
        
        currentQuality = 'sd';
        updateQualityButtons();

        if (wasPlaying) {
            playStream(currentQuality);
        }
    }

    // === ОНОВЛЕННЯ ІНТЕРФЕЙСУ ===
    function showLoader(show) {
        loader.style.display = show ? 'block' : 'none';
        playIcon.style.display = show ? 'none' : (isPlaying ? 'none' : 'block');
        pauseIcon.style.display = show ? 'none' : (isPlaying ? 'block' : 'none');
    }

    function updatePlayPauseIcon() {
        playIcon.style.display = isPlaying ? 'none' : 'block';
        pauseIcon.style.display = isPlaying ? 'block' : 'none';
    }

    function updateQualityButtons() {
        qualitySDBtn.classList.toggle('active', currentQuality === 'sd');
        qualityHDBtn.classList.toggle('active', currentQuality === 'hd');
    }
    
    function updateMuteIcons(isMuted) {
        volumeOnIcon.style.display = isMuted ? 'none' : 'block';
        volumeMutedIcon.style.display = isMuted ? 'block' : 'none';
    }
    
    function setVolume(volume) {
        if (sound) {
            sound.volume(volume);
        }
        volumeSlider.value = volume;
        updateMuteIcons(volume === 0);
        saveVolume(volume);
    }

    // === ЗБЕРЕЖЕННЯ ГУЧНОСТІ МІЖ СЕСІЯМИ ===
    function loadSavedVolume() {
        try {
            const saved = parseFloat(localStorage.getItem('mrplayer_volume'));
            return (saved >= 0 && saved <= 1) ? saved : playerConfig.initialVolume;
        } catch (e) {
            return playerConfig.initialVolume;
        }
    }

    function saveVolume(volume) {
        try {
            localStorage.setItem('mrplayer_volume', volume);
        } catch (e) {
            // localStorage може бути недоступним (приватний режим) — ігноруємо
        }
    }

    // === ОБРОБНИКИ ПОДІЙ ===
    playBtn.addEventListener('click', togglePlayPause);
    
    function switchQuality(newQuality) {
        if (currentQuality !== newQuality) {
            playStream(newQuality);
        }
    }

    qualitySDBtn.addEventListener('click', () => switchQuality('sd'));
    qualityHDBtn.addEventListener('click', () => switchQuality('hd'));

    volumeSlider.addEventListener('input', (e) => {
        const volume = parseFloat(e.target.value);
        setVolume(volume);
        if (volume > 0) {
            lastVolume = volume;
        }
    });
    
    muteBtn.addEventListener('click', () => {
        const currentVolume = sound ? sound.volume() : parseFloat(volumeSlider.value);
        if (currentVolume > 0) {
            lastVolume = currentVolume;
            setVolume(0);
        } else {
            setVolume(lastVolume);
        }
    });

    volumeUpIcon.addEventListener('click', () => {
        let newVolume = Math.min(1, parseFloat(volumeSlider.value) + 0.1);
        setVolume(newVolume);
        lastVolume = newVolume;
    });

    nextStationBtn.addEventListener('click', () => {
        const nextIndex = (currentStationIndex + 1) % stationsToShow.length;
        loadStation(nextIndex);
    });

    prevStationBtn.addEventListener('click', () => {
        const prevIndex = (currentStationIndex - 1 + stationsToShow.length) % stationsToShow.length;
        loadStation(prevIndex);
    });

    // === EASTER EGG: ЗМІНА НАЗВИ СТАНЦІЇ ===
    let clickCount = 0;
    let lastClickTime = 0;
    let easterEggActive = false;

    stationNameEl.addEventListener('click', () => {
        if (easterEggActive) return;

        const currentTime = new Date().getTime();
        if (currentTime - lastClickTime > 1000) clickCount = 0;
        
        clickCount++;
        lastClickTime = currentTime;

        if (clickCount === 13) {
            easterEggActive = true;
            stationNameEl.textContent = 'Ukraine';
            stationNameEl.classList.add('ukraine-colors');
            setTimeout(() => {
                stationNameEl.textContent = stationsToShow[currentStationIndex].name;
                stationNameEl.classList.remove('ukraine-colors');
                easterEggActive = false;
            }, 5000);
            clickCount = 0;
        }
    });

    // === ОБРОБКА СТАНУ МЕРЕЖІ ===
    window.addEventListener('offline', () => {
        console.warn('Втрачено з\'єднання з мережею.');
        if (isPlaying) {
            wasPlayingBeforeOffline = true;
            sound.pause();
        }
        clearTimeout(retryTimer);
        stopSilenceMonitor();
        statusMessage.textContent = 'Немає з\'єднання. Очікуємо...';
        showLoader(false);
    });

    window.addEventListener('online', () => {
        console.info('З\'єднання відновлено.');
        if (wasPlayingBeforeOffline) {
            wasPlayingBeforeOffline = false;
            statusMessage.textContent = 'З\'єднання відновлено. Запускаємо...';
            playStream(currentQuality);
        }
    });

    // === ІНІЦІАЛІЗАЦІЯ ПЛЕЄРА ПРИ ЗАВАНТАЖЕННІ ===
    function init() {
        if (stationsToShow.length <= 1) {
            prevStationBtn.style.display = 'none';
            nextStationBtn.style.display = 'none';
            stationSelector.style.justifyContent = 'center';
        }

        // Відновлюємо збережену гучність (або початкову з конфігу)
        const savedVolume = loadSavedVolume();
        setVolume(savedVolume);
        if (savedVolume > 0) {
            lastVolume = savedVolume;
        }
        // --- НОВА ЛОГІКА ДЛЯ ОБРОБКИ URL-ПАРАМЕТРА ---
        const urlParams = new URLSearchParams(window.location.search);
        const stationIdFromUrl = urlParams.get('station');
        
        let initialStationIndex = 0; // За замовчуванням - перша станція

        if (stationIdFromUrl) {
            const requestedIndex = stationsToShow.findIndex(station => station.id === stationIdFromUrl);
            if (requestedIndex !== -1) {
                // Якщо станцію з таким ID знайдено, використовуємо її індекс
                initialStationIndex = requestedIndex;
            }
        }
        
        loadStation(initialStationIndex);
    }
    
    init();

    // Очищення при закритті сторінки
    window.addEventListener('beforeunload', () => {
        if (sound) {
            sound.unload();
        }
        clearTimeout(retryTimer);
        stopSilenceMonitor();
    });
});

// === РЕЄСТРАЦІЯ SERVICE WORKER ДЛЯ PWA ===
if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    // ЗМІНА: шлях тепер веде до /mrplayer/sw.js
    navigator.serviceWorker.register('/mrplayer/sw.js').then(registration => {
      console.log('ServiceWorker для mRPlayer успішно зареєстровано:', registration.scope);
    }).catch(error => {
      console.log('Помилка реєстрації ServiceWorker:', error);
    });
  });
}