//import './bootstrap';
import Dropzone from "dropzone";

Dropzone.autoDiscover=false;

const dropzone = new Dropzone ('#dropzone', {
    dictDefaultMessage:"Sube aquí tu imagen",
    paramName: "images",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar Archivo",
    maxFiles:1,
    uploadMultiple: false,

    init: function init(){
        if (document.querySelector('[name="imagen"]').value.trim()){
            var imagenPublicada = {};
            imagenPublicada.size = 1234;
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;
            this.options.addedfile.call(this, imagenPublicada);
            this.options.thumbnail.call(this, imagenPublicada, "/uploads/".concat(imagenPublicada.name));
            imagenPublicada.previewElement.classList.add("dz-success","dz-complete");
        }
    },
});

//dropzone.on('sending', function(file, xhr, formData){
//    console.log(file);
//});
dropzone.on('success', function(file, response){
    //console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.images;
});

//dropzone.on('error', function(file, message){
    //console.log(response.message);
//});

dropzone.on('removedfile', function(){
    document.querySelector('[name="imagen"]').value = "";
});
