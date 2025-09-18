// Service Worker para optimización de cache
const CACHE_NAME = 'powergyma-v1';
const STATIC_CACHE = 'powergyma-static-v1';
const DYNAMIC_CACHE = 'powergyma-dynamic-v1';

// Recursos críticos para cachear inmediatamente
const STATIC_ASSETS = [
    '/',
    '/build/assets/app.css',
    '/build/assets/app.js',
    '/build/assets/main.css',
    '/build/assets/main.js',
    '/build/manifest.json',
];

// Instalar Service Worker
self.addEventListener('install', event => {
    console.log('Service Worker: Installing...');
    event.waitUntil(
        caches.open(STATIC_CACHE)
            .then(cache => {
                console.log('Service Worker: Caching static assets');
                return cache.addAll(STATIC_ASSETS);
            })
            .catch(err => console.log('Service Worker: Cache failed', err))
    );
});

// Activar Service Worker
self.addEventListener('activate', event => {
    console.log('Service Worker: Activating...');
    event.waitUntil(
        caches.keys()
            .then(cacheNames => {
                return Promise.all(
                    cacheNames.map(cache => {
                        if (cache !== STATIC_CACHE && cache !== DYNAMIC_CACHE) {
                            console.log('Service Worker: Clearing old cache', cache);
                            return caches.delete(cache);
                        }
                    })
                );
            })
    );
});

// Interceptar requests
self.addEventListener('fetch', event => {
    const { request } = event;
    const url = new URL(request.url);

    // Solo manejar requests del mismo origen
    if (url.origin === location.origin) {
        event.respondWith(handleRequest(request));
    }
});

async function handleRequest(request) {
    const url = new URL(request.url);
    
    // Estrategia Cache First para assets estáticos
    if (url.pathname.includes('/build/')) {
        return cacheFirst(request, STATIC_CACHE);
    }
    
    // Estrategia Network First para páginas
    if (request.destination === 'document') {
        return networkFirst(request, DYNAMIC_CACHE);
    }
    
    // Estrategia Cache First para imágenes
    if (request.destination === 'image') {
        return cacheFirst(request, DYNAMIC_CACHE);
    }
    
    // Para todo lo demás, intentar red primero
    return networkFirst(request, DYNAMIC_CACHE);
}

// Cache First Strategy
async function cacheFirst(request, cacheName) {
    const cachedResponse = await caches.match(request);
    if (cachedResponse) {
        return cachedResponse;
    }
    
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(cacheName);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.log('Service Worker: Network failed, no cache available', error);
        throw error;
    }
}

// Network First Strategy
async function networkFirst(request, cacheName) {
    try {
        const networkResponse = await fetch(request);
        if (networkResponse.ok) {
            const cache = await caches.open(cacheName);
            cache.put(request, networkResponse.clone());
        }
        return networkResponse;
    } catch (error) {
        console.log('Service Worker: Network failed, trying cache', error);
        const cachedResponse = await caches.match(request);
        if (cachedResponse) {
            return cachedResponse;
        }
        throw error;
    }
}