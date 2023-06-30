import "./bootstrap";
import.meta.glob(["../img/**"]);
import "flowbite";

import Alpine from "alpinejs";
window.Alpine = Alpine;
Alpine.start();

import Inputmask from "inputmask";
const integerOptions = {
    alias: "numeric",
    digits: "9,0",
    radixPoint: "",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
};
window.integerOptions = integerOptions;
const moneyOptions = {
    alias: "currency",
    radixPoint: ",",
    prefix: "R$ ",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
};
window.moneyOptions = moneyOptions;
const decimalOptions = {
    alias: "numeric",
    digits: "9,2",
    radixPoint: ",",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
};
window.decimalOptions = decimalOptions;
const weightOptions = {
    alias: "numeric",
    digits: "9,3",
    radixPoint: ",",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
};
window.weightOptions = weightOptions;
const percentOptions = {
    alias: "percentage",
    radixPoint: "",
    prefix: "",
    rightAlign: false,
    autoUnmask: true,
    removeMaskOnSubmit: true,
};
window.percentOptions = percentOptions;
if (document.querySelectorAll(".integerMask").length) {
    Inputmask(integerOptions).mask(document.querySelectorAll(".integerMask"));
}
if (document.querySelectorAll(".moneyMask").length) {
    Inputmask(moneyOptions).mask(document.querySelectorAll(".moneyMask"));
}
if (document.querySelectorAll(".decimalMask").length) {
    Inputmask(decimalOptions).mask(document.querySelectorAll(".decimalMask"));
}
if (document.querySelectorAll(".weightMask").length) {
    Inputmask(weightOptions).mask(document.querySelectorAll(".weightMask"));
}
if (document.querySelectorAll(".percentMask").length) {
    Inputmask(percentOptions).mask(document.querySelectorAll(".percentMask"));
}

import cep from "cep-promise";
let oldCepValueApp = null;
const fetchAddressByCep = (
    cepInp,
    streetInp,
    neighborInp,
    cityInp,
    stateInp,
    oldCepValue = null
) => {
    cepInp.addEventListener("keyup", () => {
        let cepValue = cepInp.value.replace(/[^\d.-]+/g, "");

        if (
            oldCepValue &&
            oldCepValue != oldCepValueApp &&
            oldCepValueApp == null
        ) {
            oldCepValueApp = oldCepValue;
        }

        if (cepValue != oldCepValueApp && cepValue.length == 9) {
            oldCepValueApp = cepValue;
            cep(cepValue)
                .then((data) => {
                    streetInp.value = data.street;
                    neighborInp.value = data.neighborhood;
                    cityInp.value = data.city;
                    stateInp.value = data.state;
                })
                .catch(function () {
                    cepInp.value = "";
                    streetInp.value = "";
                    neighborInp.value = "";
                    cityInp.value = "";
                    stateInp.value = "";
                });
        }
    });
};
window.fetchAddressByCep = fetchAddressByCep;
