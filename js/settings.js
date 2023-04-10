let openProfile = document.querySelector("#profile");
let profileMenu = document.querySelector(".profile-disclosed");
let profileArrow = document.querySelector("#menu-arrow-profile");

let openTheme = document.querySelector("#theme");
let themeMenu = document.querySelector(".theme-disclosed");
let themeArrow = document.querySelector("#menu-arrow-theme");

let openPrivacy = document.querySelector("#privacy");
let privacyMenu = document.querySelector(".privacy-disclosed");
let privacyArrow = document.querySelector("#menu-arrow-privacy");

let openDelete = document.querySelector("#delete");
let deleteMenu = document.querySelector(".delete-disclosed");
let deleteArrow = document.querySelector("#menu-arrow-delete");

/*
    Menu opening functions
*/

function openSettings(input, menu, arrow){
    if(input.getAttribute("name") === "Closed"){
        menu.style.display = "block";
        arrow.style.rotate = "90deg";
        input.setAttribute("name", "Open");
    }
    else if(input.getAttribute("name") === "Open"){
        menu.style.display = "none";
        arrow.style.rotate = "0deg";
        input.setAttribute("name", "Closed");
    }
}

/*
    Event listeners
*/

openTheme.addEventListener('click', function(){openSettings(openTheme, themeMenu, themeArrow)});
openProfile.addEventListener('click', function(){openSettings(openProfile, profileMenu, profileArrow)});
openPrivacy.addEventListener('click', function(){openSettings(openPrivacy, privacyMenu, privacyArrow)});
openDelete.addEventListener('click', function(){openSettings(openDelete, deleteMenu, deleteArrow)});

/*
    Confirm function
*/
function delete_account(){
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover your account!",
        icon: "warning",
        buttons: {
            cancel: true,
            confirm: "Delete",
        },
        dangerMode: true,
    })
    .then((willDelete) => {
        if (willDelete) {
            swal("Your account was succesfully deleted!", {
                icon: "success",
            });
        } else {
            swal("Your account was not deleted!", {
                icon: "error",
            });
        }
    });
}