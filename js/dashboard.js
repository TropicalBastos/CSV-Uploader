(function(w){

    w.columns = [
        "First Name",
        "Last Name",
        "Company",
        "Profession",
        "Chapter Name",
        "Phone Number",
        "Alt Phone",
        "Fax Number",
        "Cell Number",
        "Email",
        "Website",
        "Address",
        "City",
        "State",
        "Zip",
        "Substitute",
        "Status",
        "Join Date",
        "Renewal",
        "Sponsor"
    ]

    w.correctFileType = false;
    var fileUpload = document.getElementById("file-upload");
    var importFile = document.getElementById("importfile");
    var prompt = document.getElementById("file-prompt");
    var logout = document.getElementById("logout-button");
    var logoutYes = document.getElementById("logout-yes");
    var logoutNo = document.getElementById("logout-no");
    var logoutPrompt = document.getElementById("logout-prompt");
    var deleteAll = document.getElementById("deleteall");
    var deleteAllPrompt = document.getElementById("deleteall-prompt");
    var deleteallYes = document.getElementById("deleteall-yes");
    var deleteallNo = document.getElementById("deleteall-no");
    var viewMore = document.getElementsByClassName("view-more");
    var loader = document.getElementsByClassName("loader-wrapper")[0];
    var upload = document.getElementById("upload");
    var navWrapper = document.getElementsByClassName("nav-wrapper")[0];
    var table = document.getElementsByClassName("table-wrapper")[0];

    fileUpload.addEventListener("change", fileListener);
    importFile.addEventListener("mouseenter", promptListener);
    importFile.addEventListener("mouseleave", promptListener);
    logout.addEventListener("click", logoutListener);
    logoutYes.addEventListener("click", logoutUser);
    logoutNo.addEventListener("click", closePrompt);
    deleteAll.addEventListener("click", deleteallPromptListener);
    deleteallYes.addEventListener("click", deleteAllRecords);
    deleteallNo.addEventListener("click", closePrompt);
    Array.prototype.forEach.call(viewMore, function(item){
        item.addEventListener("click", getViewMore);
    });
    upload.addEventListener("click", uploadListener);

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

    function uploadListener(){
        loader.style.display = "block";
    }

    function promptListener(e){
        if(e.type === "mouseenter"){
            prompt.style.display = "block";
        }else if(e.type === "mouseleave"){
            prompt.style.display = "none";
        }
    }

    function logoutListener(){
        logoutPrompt.style.display = "block";
    }

    function closePrompt(){
        var prompts = document.getElementsByClassName("prompt");
        Array.prototype.forEach.call(prompts, function(item){
            item.style.display = "none";
        });
    }

    function logoutUser(){
        window.location = "../index.php?logout=a";
    }

    function deleteallPromptListener(){
        deleteAllPrompt.style.display = "block";
    }

    function deleteAllRecords(){
        window.location = "/account/delete.php?deleteall=d";
    }

    function backFromView(){
        table.style.display = "block";
        navWrapper.style.display = "block";
        var modal = document.getElementById("view-modal");
        modal.style.display = "none";
    }

    function getViewMore(e){
        var cell = e.target;
        var parent = cell.parentElement;
        var id = parent.querySelector(".cellId").textContent;
        var xhr = new XMLHttpRequest();
        var url = "/account/fetchrow.php?id=" + id;
        xhr.onreadystatechange = function(){
            if(xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
                table.style.display = "none";
                navWrapper.style.display = "none";
                var el;
                if((el = document.getElementById("view-modal")) !== null) el.remove();
                var json = JSON.parse(xhr.responseText);
                var container = document.createElement("div");
                container.id = "view-modal";
                document.body.appendChild(container);
                var count = 0;
                for(var i in json){
                    if(count >= json.length-1) break;
                    var element = document.createElement("span");
                    var strong = document.createElement("strong");
                    var div = document.createElement("div");
                    if(count === json.length-2) div.id = "last-view";
                    div.classList.add("view-div");
                    strong.innerHTML = columns[count] + ":";
                    element.innerHTML = " " + json[count+1];
                    div.appendChild(strong);
                    div.appendChild(element);
                    div.appendChild(document.createElement("br"));
                    container.appendChild(div);
                    if(count >= (json.length-2)){
                        var backButton = document.createElement("button");
                        backButton.innerHTML = "Back";
                        backButton.id = "view-back";
                        backButton.addEventListener("click", backFromView);
                        container.appendChild(backButton);
                    }
                    count++;
                }
                loader.style.display = "none";
            }else{
                loader.style.display = "none";
            }
        }
        xhr.open("GET", url);
        loader.style.display = "block";
        xhr.send();
    }

})(window);