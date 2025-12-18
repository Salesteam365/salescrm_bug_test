
"use strict"

// for show password 
/**
* Toggle password visibility for a given input and switch the eye icon classes.
* @example
* togglePasswordVisibility('passwordInputId', buttonElement)
* undefined
* @param {{string}} {{type}} - The id of the input element whose type will be toggled.
* @param {{HTMLElement}} {{ele}} - The element (usually a button) containing the eye icon that was clicked.
* @returns {{void}} Does not return a value.
**/
let createpassword = (type, ele) => {
    document.getElementById(type).type = document.getElementById(type).type == "password" ? "text" : "password"
    let icon = ele.childNodes[0].classList
    let stringIcon = icon.toString()
    if (stringIcon.includes("ri-eye-line")) {
        ele.childNodes[0].classList.remove("ri-eye-line")
        ele.childNodes[0].classList.add("ri-eye-off-line")
    }
    else {
        ele.childNodes[0].classList.add("ri-eye-line")
        ele.childNodes[0].classList.remove("ri-eye-off-line")
    }
}