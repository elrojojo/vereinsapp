// eigene Sammlung
function isNumber(number) {
    return number && !Number.isNaN(Number(number)) && typeof number !== "boolean" && !isArray(number) && !isObject(number);
}
