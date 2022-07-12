export const textLimit = function (text, limit) {
    return text.length > limit ? `${text.substring(0, limit)}...` : v
}
