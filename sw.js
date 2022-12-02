

self.addEventListener('install', event => {

    self.skipWaiting();
});

self.addEventListener('activate', event => {



});


self.addEventListener('push', event => {

    console.log('Notificacion recibida');

});

self.addEventListener('fetch', event => {


    console.log( 'SW:', event.request.url );
    console.log(event);
});
