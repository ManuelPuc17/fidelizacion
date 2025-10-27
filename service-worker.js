const CACHE_NAME = 'fidelizacion-v1';
const urlsToCache = [                     // Página principal
  './view/V.login.php',     // Login
  './manifest.json',
  './icons/tienda-online.png',
  'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
];

// ✅ Instalar y guardar archivos en caché
self.addEventListener('install', event => {
  event.waitUntil(
    caches.open(CACHE_NAME).then(cache => {
      console.log('Archivos cacheados correctamente');
      return cache.addAll(urlsToCache);
    })
  );
});

// ✅ Activar y limpiar cachés viejos
self.addEventListener('activate', event => {
  event.waitUntil(
    caches.keys().then(cacheNames =>
      Promise.all(
        cacheNames.map(name => {
          if (name !== CACHE_NAME) {
            console.log('Cache antiguo eliminado:', name);
            return caches.delete(name);
          }
        })
      )
    )
  );
});

self.addEventListener('fetch', event => {
  const req = event.request;

  // Ignora métodos distintos de GET y URLs que contengan "dashboard" o "admin"
  if (req.method !== 'GET' || req.url.includes('/dashboard') || req.url.includes('/admin') || req.url.includes('/process')) {
    return; // Deja que el navegador maneje la petición normalmente
  }

  event.respondWith(
    caches.match(req, { ignoreSearch: true }).then(response => {
      return response || fetch(req, { redirect: 'follow' }).catch(() =>
        caches.match('./view/V.login.php')
      );
    })
  );
});


// 📬 Evento cuando el usuario hace clic en la notificación
self.addEventListener('notificationclick', event => {
  event.notification.close();

  // Ejemplo: abrir dashboard del cliente
  event.waitUntil(
    clients.openWindow('./view/cliente/dashboard.php')
  );
});
