// eigene Sammlung
function isNumber(number) {
    return number && !Number.isNaN(Number(number)) && typeof number !== "boolean" && !Array.isArray(number) && !isObject(number);
}
