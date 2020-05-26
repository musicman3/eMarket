/**
 * Random generator (генератор случайной строки)
 * @param length {String} (количество символов)
 * @returns id {String}
 */

function randomize(length) {
    var id = '';
    var rdm62;
    while (length--) {
        // Generate random integer between 0 and 61, 0|x works for Math.floor(x) in this case 
        rdm62 = 0 | Math.random() * 62;
        // Map to ascii codes: 0-9 to 48-57 (0-9), 10-35 to 65-90 (A-Z), 36-61 to 97-122 (a-z)
        id += String.fromCharCode(rdm62 + (rdm62 < 10 ? 48 : rdm62 < 36 ? 55 : 61));
    }
    return id;
}
