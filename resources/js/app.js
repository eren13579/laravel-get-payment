import "./bootstrap";

import jQuery from "jquery";
window.$ = window.jQuery = jQuery;

import select2 from "select2";

import { Notyf } from "notyf";
import "notyf/notyf.min.css";
import { Depots } from "./depots.js";
import { Retrait } from "./retrait.js";

const notyf = new Notyf({
    position: {
        x: "center",
        y: "top",
    },
});
window.notyf = notyf;

select2();
Depots();
Retrait();


import Alpine from "alpinejs";
import axios from "axios";
window.Alpine = Alpine;
Alpine.start();
