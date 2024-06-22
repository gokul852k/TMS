const body = document.querySelector('body'),
    sidebar = body.querySelector('nav'),
    toggle = body.querySelector(".toggle"),
    searchBtn = body.querySelector(".search-box"),
    modeSwitch = body.querySelector(".toggle-switch"),
    modeText = body.querySelector(".mode-text");
toggle.addEventListener("click", () => {
    console.log("calling..");
    sidebar.classList.toggle("close");
})
// searchBtn.addEventListener("click", () => {
//     sidebar.classList.remove("close");
// })
// modeSwitch.addEventListener("click", () => {
//     body.classList.toggle("dark");
//     if (body.classList.contains("dark")) {
//         modeText.innerText = "Light mode";
//     } else {
//         modeText.innerText = "Dark mode";
//     }
// });


//Mobile Navbar JS

// (function (cb) {
//     // browser event has already occurred.
//     if (document.readyState === "complete") {
//         return setTimeout(cb);
//     }

//     // Mozilla, Opera and webkit style
//     if (window.addEventListener) {
//         return window.addEventListener("load", cb, false);
//     }

//     // If IE event model is used
//     if (window.attachEvent) {
//         return window.attachEvent("onload", cb);
//     }
// })(function () {
//     document.querySelectorAll(".nav-btn").forEach(function (el) {
//         el.addEventListener("click", function () {
//             var nav = this.parentElement.parentElement,
//                 _class = "open";

//             if (nav.classList.contains(_class)) {
//                 nav.classList.remove(_class);
//                 document.getElementsByClassName("nav-list")[0].style.display = "none";
//                 setTimeout(() => {
//                     document.getElementsByClassName("nav-content")[0].style.display = "none";
//                 }, 500);
//             } else {
//                 document.getElementsByClassName("nav-content")[0].style.display = "block";
//                 setTimeout(() => {
//                     nav.classList.add(_class);
//                 }, 1);
//                 setTimeout(() => {
//                     document.getElementsByClassName("nav-list")[0].style.display = "block";
//                 }, 500);

//             }
//         });
//     });
// });