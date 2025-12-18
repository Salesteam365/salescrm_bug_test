(function () {
    "use strict";

    var myElement1 = document.getElementById('chat-msg-scroll');
    new SimpleBar(myElement1, { autoHide: true });

    var myElement2 = document.getElementById('groups-tab-pane');
    new SimpleBar(myElement2, { autoHide: true });

    var myElement3 = document.getElementById('calls-tab-pane');
    new SimpleBar(myElement3, { autoHide: true });

    var myElement4 = document.getElementById('main-chat-content');
    new SimpleBar(myElement4, { autoHide: true });

    var myElement5 = document.getElementById('chat-user-details');
    new SimpleBar(myElement5, { autoHide: true });


    document.querySelector(".responsive-chat-close").addEventListener("click", () => {
        document.querySelector(".main-chart-wrapper").classList.remove("responsive-chat-open")
    })

    document.querySelectorAll(".responsive-userinfo-open").forEach((ele) => {
        ele.addEventListener("click", () => {
            document.querySelector("#chat-user-details").classList.add("open")
        })
    })
    document.querySelector(".responsive-chat-close2").addEventListener("click",() =>{
        document.querySelector("#chat-user-details").classList.remove("open")
    })

    document.querySelector(".chat-info").addEventListener("click", () => {
        document.querySelector("#chat-user-details").classList.remove("open")
    })
    document.querySelector(".chat-content").addEventListener("click", () => {
        document.querySelector("#chat-user-details").classList.remove("open")
    })

})();

/**
* Activate a chat list item and update the chat UI (display name, avatar image, status and responsive class).
* @example
* setActiveChat(element, "Alice", "alice", "online")
* undefined
* @param {HTMLElement} element - The DOM element that was interacted with (used to find and mark the parent li as active).
* @param {string} name - The display name to set for the active chat.
* @param {string} img - The avatar image filename (without extension) to apply to chat images.
* @param {string} status - The status class to apply to status elements (e.g., "online" or "offline").
* @returns {void} No return value.
*/
let changeTheInfo = (element, name, img, status) => {
    document.querySelectorAll(".checkforactive").forEach((ele) => {
        ele.classList.remove("active")
    })
    element.closest("li").classList.add("active")
    document.querySelectorAll(".chatnameperson").forEach((ele) => {
        ele.innerText = name
    })
    let image = `../assets/images/faces/${img}.jpg`
    document.querySelectorAll(".chatimageperson").forEach((ele) => {
        ele.src = image
    })

    document.querySelectorAll(".chatstatusperson").forEach((ele)=>{
        ele.classList.remove("online")
        ele.classList.remove("offline")
        ele.classList.add(status)
    })



    document.querySelector(".chatpersonstatus").innerText = status

    document.querySelector(".main-chart-wrapper").classList.add("responsive-chat-open")
}