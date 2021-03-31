const staticCacheName = 'site-static-v2';//
const dynamicCache = 'site-dynamic-v1';
const assets = [
    '/',
    '/index.php'
];



self.addEventListener('install', evt => {
    console.log('installed');
    evt.waitUntil(
        caches.open(staticCacheName).then(cache => {
            cache.addAll(assets);
        })
        );
});

self.addEventListener('activate', evt => {
    console.log('activated');
    evt.waitUntil(
        caches.keys().then(keys => {
            //console.log(keys);
            return Promise.all(keys
                .filter(key => key !== staticCacheName)
                .map(key => caches.delete(key))
                )
        })
    );
});

self.addEventListener('fetch', evt => {
    console.log('fetch event', evt);
    evt.respondWith(
        caches.match(evt.request).then(cacheRes => {
            return cacheRes || fetch(evt.request).then(fetchRes =>{
                return caches.open(dynamicCache).then(cache => {
                    cache.put(evt.request.url, fetchRes.clone());
                    return fetchRes;
                })
            });
        })
    );
});