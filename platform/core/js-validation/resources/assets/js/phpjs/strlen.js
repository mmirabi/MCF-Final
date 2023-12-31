function strlen(string) {
    //  discuss at: http://phpjs.org/functions/strlen/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // improved by: Sakimori
    // improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    //    input by: Kirk Strobeck
    // bugfixed by: Onno Marsman
    //  revised by: Brett Zamir (http://brett-zamir.me)
    //        note: May look like overkill, but in order to be truly faithful to handling all Unicode
    //        note: characters and to this function in PHP which does not count the number of bytes
    //        note: but counts the number of characters, something like this is really necessary.
    //   example 1: strlen('Kevin van Zonneveld');
    //   returns 1: 19
    //   example 2: ini_set('unicode.semantics', 'on');
    //   example 2: strlen('A\ud87e\udc04Z');
    //   returns 2: 3

    var str = string + ''
    var i = 0,
        chr = '',
        lgth = 0

    if (
        !this.php_js ||
        !this.php_js.ini ||
        !this.php_js.ini['unicode.semantics'] ||
        this.php_js.ini['unicode.semantics'].local_value.toLowerCase() !== 'on'
    ) {
        return string.length
    }

    var getWholeChar = function (str, i) {
        var code = str.charCodeAt(i)
        var next = '',
            prev = ''
        if (0xd800 <= code && code <= 0xdbff) {
            // High surrogate (could change last hex to 0xDB7F to treat high private surrogates as single characters)
            if (str.length <= i + 1) {
                throw 'High surrogate without following low surrogate'
            }
            next = str.charCodeAt(i + 1)
            if (0xdc00 > next || next > 0xdfff) {
                throw 'High surrogate without following low surrogate'
            }
            return str.charAt(i) + str.charAt(i + 1)
        } else if (0xdc00 <= code && code <= 0xdfff) {
            // Low surrogate
            if (i === 0) {
                throw 'Low surrogate without preceding high surrogate'
            }
            prev = str.charCodeAt(i - 1)
            if (0xd800 > prev || prev > 0xdbff) {
                // (could change last hex to 0xDB7F to treat high private surrogates as single characters)
                throw 'Low surrogate without preceding high surrogate'
            }
            // We can pass over low surrogates now as the second component in a pair which we have already processed
            return false
        }
        return str.charAt(i)
    }

    for (i = 0, lgth = 0; i < str.length; i++) {
        if ((chr = getWholeChar(str, i)) === false) {
            continue
        } // Adapt this line at the top of any loop, passing in the whole string and the current iteration and returning a variable to represent the individual character; purpose is to treat the first part of a surrogate pair as the whole character and then ignore the second part
        lgth++
    }
    return lgth
}
