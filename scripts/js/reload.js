"use strict";
const SET_DEBUG_MODE = true;
function automaticReload(time) {
    if (SET_DEBUG_MODE) {
        window.setTimeout("window.location.reload()", time);
    }
}
automaticReload(10000);