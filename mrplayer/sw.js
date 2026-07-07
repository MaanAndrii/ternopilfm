const CACHE_NAME = 'mrplayer-cache-v1';
// Список файлів, які потрібно закешувати, з оновленими шляхами
const urlsToCache = [
  '/mrplayer/',
  '/mrplayer/mRPlayer.html',
  '/mrplayer/style.css',
  '/mrplayer/config.js',
  '/mrplayer/player.js',
  '/mrplayer/icons/icon-192x192.png',
  '/mrplayer/icons/icon-512x512.png'
];

// Встановлення Service Worker
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => {
        console.log('Opened cache');
        return cache.addAll(urlsToCache);
      })
  );
});

// Обробка запитів
self.addEventListener('fetch', event => {
  event.respondWith(
    caches.match(event.request)
      .then(response => {
        // Якщо запит є в кеші, повертаємо його
        if (response) {
          return response;
        }
        // Інакше, робимо запит до мережі
        return fetch(event.request);
      }
    )
  );
});