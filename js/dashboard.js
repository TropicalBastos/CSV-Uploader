(function(w){

    w.correctFileType = false;
    var fileUpload = document.getElementById("file-upload");
    var importFile = document.getElementById("importfile");
    var prompt = document.getElementById("file-prompt");
    fileUpload.addEventListener("change", fileListener);
    importFile.addEventListener("mouseenter", promptListener);
    importFile.addEventListener("mouseleave", promptListener);

    function fileListener(){
        var file = fileUpload.value;
        var regex = /^(C:\\).*(\\)+([a-zA-Z.\-0-9]+)$/;
        file = file.replace(regex,"$3");
        var span = document.querySelector("#importfile>span");
        if(file==="") file = "Import CSV";
        span.innerHTML = file;
        
        //check if it is csv
        var csvRegex = /^.*\.csv$/;
        var errorTag = document.getElementsByClassName("error")[0];
        var upload = document.getElementById("upload");
        if(file.match(csvRegex)){
            errorTag.style.display = "none";
            correctFileType = true;
            upload.disabled = false;
            upload.style.cursor = "pointer";
        }else{
            upload.disabled = true;
            upload.style.cursor = "default";
            errorTag.style.display = "block";
        }
    }

    function promptListener(e){
        if(e.type === "mouseenter"){
            prompt.style.display = "block";
        }else if(e.type === "mouseleave"){
            prompt.style.display = "none";
        }
    }

})(window);