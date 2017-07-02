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

    //ELEMENTS
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
    var navIcon = document.getElementById("nav-icon");
    var fullNav = document.getElementsByClassName("full-nav")[0];
    var close = document.getElementsByClassName("close")[0];
    var mobileLogout = document.getElementById("mobile-logout");
    var chooseUpload = document.getElementById("choose-upload");
    var mobileUpload = document.getElementById("mobile-upload");
    var mobileDeleteAll = document.getElementById("mobile-all");
    var navUpload = document.getElementById("nav-upload");
    var form = document.getElementById("desktop-nav");
    var pages = document.getElementsByClassName("page");
    var addModal = document.getElementsByClassName("add-modal")[0];
    var next = document.getElementsByClassName("next");
    var addBack = document.querySelectorAll(".page .back");
    var addModalContainer = document.getElementsByClassName("add-modal-wrapper")[0];
    var cancelButton = document.getElementsByClassName("cancel");
    var addRecord = document.querySelector(".nav-button.add");
    var mobileAdd = document.getElementById("mobile-add");
    var content = document.getElementsByClassName("content")[0];
    var addForm = document.getElementById("add-form");
    var formSubmit = document.getElementById("form-submit");

    //EVENT LISTENERS
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
    navIcon.addEventListener("touch", openNav);
    navIcon.addEventListener("click", openNav);
    close.addEventListener("click", closeNav);
    mobileLogout.addEventListener("click", function(){closeNav();logoutListener();});
    mobileDeleteAll.addEventListener("click", function(){closeNav();deleteallPromptListener();});
    mobileUpload.addEventListener("click", function(){closeNav(); uploadListener(); form.submit();});
    Array.prototype.forEach.call(next, function(n){
        n.addEventListener("click", nextPage);
    });
    Array.prototype.forEach.call(addBack, function(b){
        b.addEventListener("click", prevPage);
    });
    Array.prototype.forEach.call(cancelButton, function(c){
        c.addEventListener("click", cancelAdd);
    });
    addRecord.addEventListener("click", addRecordPrompt);
    mobileAdd.addEventListener("click", function(){closeNav(); addRecordPrompt();});
    formSubmit.addEventListener("click", submitAdd);

    function fileListener(){
        var file = fileUpload.value;
        var fileMobile = fileUpload.value;
        var regex = /^(C:\\).*(\\)+([a-zA-Z.\-0-9]+)$/;
        file = file.replace(regex,"$3");
        fileMobile = fileMobile.replace(regex,"$3");
        var span = document.querySelector("#importfile>span");
        if(file===""){
            file = "Import CSV";
            fileMobile = "lalala";
        }
        span.innerHTML = file;
        navUpload.innerHTML = fileMobile;
        
        //check if it is csv
        var csvRegex = /^.*\.csv$/;
        var errorTag = document.getElementsByClassName("error")[0];
        var upload = document.getElementById("upload");
        if(file.match(csvRegex)){
            errorTag.style.display = "none";
            correctFileType = true;
            upload.disabled = false;
            upload.style.cursor = "pointer";

            //mobile activate upload
            mobileUpload.classList.remove("disabled");
        }else{
            upload.disabled = true;
            upload.style.cursor = "default";
            errorTag.style.display = "block";

            //mobile deactivate upload
            mobileUpload.classList.add("disabled");
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

    function openNav(){
        fullNav.style.display = "block";
    }

    function closeNav(){
        fullNav.style.display = "none";
    }

    function hasClass(element, cls) {
        return (' ' + element.className + ' ').indexOf(' ' + cls + ' ') > -1;
    }

    //Add record page function
    function nextPage(){
        var computed = getComputedStyle(addModal);
        var current = computed["margin-left"];
        current = parseInt(current.replace("px",""));
        addModal.style["margin-left"] = (current - 290) + "px";
    }

    function prevPage(){
        var computed = getComputedStyle(addModal);
        var current = computed["margin-left"];
        current = parseInt(current.replace("px",""));
        addModal.style["margin-left"] = (current + 290) + "px";
    }

    function cancelAdd(){
        addModalContainer.style.display = "none";
    }

    function addRecordPrompt(){
        addModalContainer.style.display = "block";
    }

    function validateAdd(){
        var firstname = document.getElementById("add-first").value;
        var lastname = document.getElementById("add-last").value;
        var email = document.getElementById("add-email").value;

        if(firstname.length === 0
        || lastname.length === 0
        || email.length === 0){
            var err = document.querySelector(".add-error");
            err.style.display = "block";
            return false;
        }
        cancelAdd();
        uploadListener();
        return true;
    }

    function submitAdd(){
        if(validateAdd()){
            addForm.submit();
        }
    }

})(window);