// Utilidades para grabar PouchDB
const db = new PouchDB('mensajes');


function guardarMensaje( mensaje ) {

    mensaje._id = new Date().toISOString();


    return db.put( mensaje ).then( () => {

        console.log("Guardado",mensaje);

        self.registration.sync.register('nuevo-post');

        const newResp = {
            ok: true,
            offline: true,
            status: 200,
            title: 'Datos guardados sin conexiòn',
            message: 'Se sincronizaran los datos cuando recupere la conexión a internet',
            type: 'success'
        };

        return new Response( JSON.stringify(newResp) );

    });

}


function postearMensajes() {

    const posteos = [];

    return db.allDocs({ include_docs: true }).then( docs => {


        docs.rows.forEach( row => {

            const doc = row.doc;

            console.log("Document PouchDB");
            console.log(doc);


            const fetchPom =  fetch('https://rhomboffline.kluanecorporatetraining.com/public/api/rhombapi/contract/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify( doc )
                }).then( res => {

                    return db.remove( doc );

                });

            posteos.push( fetchPom );


        }); // fin del foreach

        return Promise.all( posteos );

    });





}

