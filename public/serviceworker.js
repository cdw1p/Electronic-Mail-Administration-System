var version = 'v1.0.0'

self.addEventListener('install', function(event) {
  event.waitUntil(
    caches.open(`${version}-app`).then(function(cache) {
      return cache.addAll([
        '/assets/'
      ])
    })
  )
})

self.addEventListener('fetch', function (event) {
  event.respondWith(fetch(event.request)
    .catch(() => {
      return caches.open(`${version}-app`).then((cache) => {
        return cache.match(event.request)
      })
    })
  )
})

self.addEventListener('activate', function(event) {
  event.waitUntil(
    caches.keys().then(function (keys) {
      return Promise.all(
        keys.filter(function (key) {
          return !key.startsWith(version)
        })
        .map(function (key) {
          return caches.delete(key)
        })
      )
    })
  )
})