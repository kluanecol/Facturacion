
importScripts('js/utils/pouch-db.min.js');
importScripts('js/sw-db.js');
importScripts('js/sw-utils.js');

const STATIC_CACHE    = 'static-v2';
const DYNAMIC_CACHE   = 'dynamic-v23';
const INMUTABLE_CACHE = 'inmutable-v2';



var staticCacheName = "pwa-v" + new Date().getTime();

    APP_SHELL = [
        '/public/offline',
        '/public/css/app.css',
        '/public/js/app.js',
        '/public/js/sw-utils.js',
        '/public/invoicing/contract/getContractForm?id_contract=',
        '/public/js/utils/pouch-db.min.js',
        '/public/images/icons/icon-72x72.png',
        '/public/images/icons/icon-96x96.png',
        '/public/images/icons/icon-128x128.png',
        '/public/images/icons/icon-144x144.png',
        '/public/images/icons/icon-152x152.png',
        '/public/images/icons/icon-192x192.png',
        '/public/images/icons/icon-384x384.png',
        '/public/images/icons/icon-512x512.png',
    ];


const APP_SHELL_INMUTABLE = [
    'https://fonts.googleapis.com/css?family=Quicksand:300,400',
    'https://fonts.googleapis.com/css?family=Lato:400,300',
    'https://use.fontawesome.com/releases/v5.3.1/css/all.css',
    'https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.css',
    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'
];


// Cache on install
self.addEventListener('install', e => {


    const cacheStatic = caches.open( STATIC_CACHE ).then(cache =>
        cache.addAll( APP_SHELL ));

    const cacheInmutable = caches.open( INMUTABLE_CACHE ).then(cache =>
        cache.addAll( APP_SHELL_INMUTABLE ));



    e.waitUntil( Promise.all([ cacheStatic, cacheInmutable ])  );

});

// Clear cache on activate
self.addEventListener('activate', e => {

    const respuesta = caches.keys().then( keys => {

        keys.forEach( key => {

            if (  key !== STATIC_CACHE && key.includes('static') ) {
                return caches.delete(key);
            }

            if (  key !== DYNAMIC_CACHE && key.includes('dynamic') ) {
                return caches.delete(key);
            }

        });

    });

    e.waitUntil( respuesta );

});

//
self.addEventListener( 'fetch', e => {

    let respuesta;

    if (e.request.url.includes('invoicing/')) {
       respuesta = manejoApi(DYNAMIC_CACHE, e.request);
    }
    else{
        respuesta = caches.match( e.request ).then( res => {

            if ( res ) {

                actualizaCacheStatico( STATIC_CACHE, e.request, APP_SHELL_INMUTABLE );
                return res;
            } else {

                return fetch( e.request ).then( newRes => {

                    return actualizaCacheDinamico( DYNAMIC_CACHE, e.request, newRes );

                });

            }

        }).catch(() => {
            return caches.match('offline');
        });

    }



    e.respondWith( respuesta );

});

//async tasks
self.addEventListener('sync', e => {
    console.log('SW: SYNC');

    if (e.tag === 'nuevo-post') {
        //POST WHERE CONECTION RECOVER

        postearMensajes();
        //e.waitUntil();
    }

});
