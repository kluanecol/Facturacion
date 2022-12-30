

// Guardar  en el cache dinamico
function actualizaCacheDinamico( dynamicCache, req, res ) {


    if ( res.ok ) {

        return caches.open( dynamicCache ).then( cache => {

            cache.put( req, res.clone() );

            return res.clone();

        });

    } else {
        return res;
    }

}

// Cache with network update
function actualizaCacheStatico( staticCache, req, APP_SHELL_INMUTABLE ) {


    if ( APP_SHELL_INMUTABLE.includes(req.url) ) {
        // No hace falta actualizar el inmutable
        // console.log('existe en inmutable', req.url );

    } else {
        // console.log('actualizando', req.url );
        return fetch( req )
                .then( res => {
                    return actualizaCacheDinamico( staticCache, req, res );
                });
    }



}

function manejoApi( cacheName, req){

    if (req.clone().method === 'POST') {

        if ( self.registration.sync && !navigator.onLine) {

            return req.clone().formData().then( data => {

                var object = {};
                data.forEach((value, key) => {
                    // Reflect.has in favor of: object.hasOwnProperty(key)
                    if(!Reflect.has(object, key)){
                        if (key  != '_token' ) {
                            object[key] = value;
                            return;
                        }else{
                            object['token'] = value;
                            return;
                        }
                    }
                    if(!Array.isArray(object[key])){
                        object[key] = [object[key]];
                    }
                    object[key].push(value);
                });
                var json = JSON.stringify(object);
               /*
               const dataObject = Object.fromEntries(data.entries());
               dataObject.topics = data.getAll("topics");
                if (dataObject._token) {
                    dataObject.token = dataObject._token;
                    delete dataObject._token;

                }
               */


               return guardarMensaje( object );
            });
        }
        else {
            return fetch( req );
        }
    }
    else{
        return fetch( req ).then( res => {

            if (res.ok) {
                actualizaCacheDinamico( cacheName, req, res.clone() );
                return res.clone();
            }
            else{
                console.log("else manejo API");
                return caches.match( req );
            }
        }).catch( err => {
            return caches.match( req ).then( res => {
                if ( res ) {
                    return res;

                }
                else {

                    return caches.match('offline');

                }
            });


        });
    }

}
