const CACHE_NAME = 'mrplayer-cache-v2';

// Файли, які кешуються при встановленні (повна офлайн-оболонка плеєра)
const urlsToCache = [
  '/mrplayer/',
  '/mrplayer/mRPlayer.html',
  '/mrplayer/style.css',
  '/mrplayer/config.js',
  '/mrplayer/player.js',
  '/mrplayer/howler.min.js',
  '/mrplayer/fonts/inter-latin.woff2',
  '/mrplayer/fonts/inter-cyrillic.woff2',
  '/mrplayer/icons/icon-192x192.png',
  '/mrplayer/icons/icon-512x512.png'
];

// Для цих файлів спочатку йдемо в мережу (щоб оновлення коду доходили до користувачів),
// а кеш використовуємо лише як офлайн-резерв
const networkFirstPaths = [
  '/mrplayer/',
  '/mrplayer/mRPlayer.html',
  '/mrplayer/config.js',
  '/mrplayer/player.js',
  '/mrplayer/style.css'
];

// Встановлення: кешуємо оболонку і одразу активуємо нову версію SW.
// Кешуємо кожен файл окремо, щоб один недоступний URL не зривав встановлення всього кешу.
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME)
      .then(cache => Promise.allSettled(urlsToCache.map(url => cache.add(url))))
      .then(() => self.skipWaiting())
  );
});

// Активація: видаляємо всі старі версії кешу (mrplayer-cache-v1 тощо)
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys()
      .then(keys => Promise.all(
        keys.filter(key => key !== CACHE_NAME).map(key => caches.delete(key))
      ))
      .then(() => self.clients.claim())
  );
});

self.addEventListener('fetch', event => {
  // Кешуємо лише GET-запити; аудіопотоки та сторонні запити пропускаємо повз кеш
  if (event.request.method !== 'GET') return;

  const url = new URL(event.request.url);
  if (url.origin !== self.location.origin) return;

  if (networkFirstPaths.includes(url.pathname)) {
    // Network-first: свіжа версія з мережі, кеш — офлайн-резерв
    event.respondWith(
      fetch(event.request)
        .then(response => {
          const copy = response.clone();
          caches.open(CACHE_NAME).then(cache => cache.put(event.request, copy));
          return response;
        })
        .catch(() => caches.match(event.request).then(cached =>
          // Офлайн-резерв для /mrplayer/ — віддаємо закешовану сторінку плеєра
          cached || caches.match('/mrplayer/mRPlayer.html')
        ))
    );
  } else {
    // Cache-first: статика (шрифти, іконки, бібліотеки)
    event.respondWith(
      caches.match(event.request)
        .then(response => response || fetch(event.request))
    );
  }
});
