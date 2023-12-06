function isLuxonDateTime(object) {
    return isObject(object) && "isLuxonDateTime" in object && object.isLuxonDateTime;
}
