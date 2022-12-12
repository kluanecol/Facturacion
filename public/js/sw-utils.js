

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

        //console.log(req.clone());
        req.clone().formData().then( data => {

           //const bodyObject = JSON.parse( data );
           //data.delete('username');
           const dataObject = Object.fromEntries(data.entries());
           dataObject.topics = data.getAll("topics");
            if (dataObject._token) {
                dataObject.token = dataObject._token;
                delete dataObject._token;

            }
           console.log(dataObject);
           guardarMensaje( dataObject );
        });

        return fetch( req );
    }
    else{
        return fetch( req ).then( res => {

            if (res.ok) {
                actualizaCacheDinamico( cacheName, req, res.clone() );
                return res.clone();
            }
            else{
                console.log("else manejO API");
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
