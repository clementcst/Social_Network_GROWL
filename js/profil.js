var button1 = document.getElementById("button1");
var button2 = document.getElementById("button2");
var button3 = document.getElementById("button3");

var content1 = document.getElementById("content1");
var content2 = document.getElementById("content2");
var content3 = document.getElementById("content3");

box1.addEventListener("click", function() {
    content1.style.display = "block";
    content2.style.display = "none";
    content3.style.display = "none";
  });
  
  box2.addEventListener("click", function() {
    content1.style.display = "none";
    content2.style.display = "block";
    content3.style.display = "none";
  });
  
  box3.addEventListener("click", function() {
    content1.style.display = "none";
    content2.style.display = "none";
    content3.style.display = "block";
  });

function submitFormConvLinkProfil() {
    document.getElementById("form-conversation-link-profil").submit();
}

function submitFormSendFriendReq() {
  document.getElementById("form-send-f-req").submit();
}