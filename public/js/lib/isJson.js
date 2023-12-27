// https://stackoverflow.com/questions/3710204/how-to-check-if-a-string-is-a-valid-json-string
/**
 * If you don't care about primitives and only objects then this function
 * is for you, otherwise look elsewhere.
 * This function will return `false` for any valid json primitive.
 * EG, 'true' -> false
 *     '123' -> false
 *     'null' -> false
 *     '"I'm a string"' -> false
 */
function isJson(json) {
    try {
        var o = JSON.parse(json);

        // Handle non-exception-throwing cases:
        // Neither JSON.parse(false) or JSON.parse(1234) throw errors, hence the type-checking,
        // but... JSON.parse(null) returns null, and typeof null === "object",
        // so we must check for that, too. Thankfully, null is falsey, so this suffices:
        if (o && typeof o === "object") {
            // return o;
            return o; // geändert am 27.12.2023
        }
    } catch (e) {}

    return false;
}
