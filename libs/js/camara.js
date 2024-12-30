var localstream, canvas, video, cxt;

function turnOnCamera() {
    canvas = document.getElementById("canvas");
    cxt = canvas.getContext("2d");
    video = document.getElementById("video");

    if(!navigator.getUserMedia)
        navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || 
    navigator.msGetUserMedia;
    if(!window.URL)
        window.URL = window.webkitURL;

    if (navigator.getUserMedia) {
        navigator.getUserMedia({"video" : true, "audio": false
        }, function(stream) {
            try {
                localstream = stream;
                video.srcObject = stream;
                video.play();
            } catch (error) {
                video.srcObject = null;
            }
        }, function(err){
            swal("Error", err, "error");
        });
    } else {
        swal("Mensaje", "User Media No Disponible" , "error");
        return;
    }
}

function turnOffCamera() {
    video.pause();
    video.srcObject = null;
    localstream.getTracks()[0].stop();
}

$("#radiotfoto").click(function() {
    
    document.getElementById("cont_input_file").style.display = "none";

    $("#subirfoto").addClass("none");
    $("#video").removeClass("none");
    turnOnCamera();
    document.getElementById("subirfoto").value = null;
});

$("#radiosfoto").click(function() {

    document.getElementById("cont_input_file").removeAttribute('style');

    $("#subirfoto").removeClass("none");
    $("#video").addClass("none");
    turnOffCamera();
});


//Codigo para el modificar (Update)

function turnOnCameraDos() {
    canvas = document.getElementById("canvas_update");
    cxt = canvas.getContext("2d");
    video = document.getElementById("video_update");

    if(!navigator.getUserMedia)
        navigator.getUserMedia = navigator.webkitGetUserMedia || navigator.mozGetUserMedia || 
    navigator.msGetUserMedia;
    if(!window.URL)
        window.URL = window.webkitURL;

    if (navigator.getUserMedia) {
        navigator.getUserMedia({"video" : true, "audio": false
        }, function(stream) {
            try {
                localstream = stream;
                video.srcObject = stream;
                video.play();
            } catch (error) {
                video.srcObject = null;
            }
        }, function(err){
            swal("Error", err, "error");
        });
    } else {
        swal("Mensaje", "User Media No Disponible" , "error");
        return;
    }
}

$("#radiostfotoUpdate").click(function() {
    
    $("#subirfotoUpdate").addClass("none");
    $("#video_update").removeClass("none");
    document.getElementById("video_update").removeAttribute('style');
    document.getElementById("video_update").setAttribute('style', 'width:100%;')
    document.getElementById("cont_input_file_update").setAttribute("style", "display:none;");
    
    turnOnCameraDos();
    document.getElementById("subirfotoUpdate").value = null;
});

$("#radiosfotoUpdate").click(function() {

    document.getElementById("video_update").setAttribute('style', 'display:none; width:100%;');
    document.getElementById("cont_input_file_update").removeAttribute("style");
    $("#subirfotoUpdate").removeClass("none");
    $("#video_update").addClass("none");
    turnOnCameraDos();
});