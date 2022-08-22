import IMask from 'imask';

export class Masks {
    nipMask(elementId) {
        return IMask(
            document.getElementById(elementId),
            {
                mask: '00000000000',
            });
    }

    zipCodeMask(elementId) {
        return IMask(
            document.getElementById(elementId),
            {
                mask: '00-000'
            });
    }

    dateMask(elementId) {
        let date = IMask(
            document.getElementById(elementId),
            {
                mask: Date,
                min: new Date(new Date().getFullYear(), 0, 1),
                max: new Date(9999, 0, 1),
                lazy: false
            });

        date.updateOptions({
            mask: Date,
            min: new Date(new Date().getFullYear(), 0, 1),
            max: new Date(9999, 0, 1),
            lazy: false
        })
        return date;
    }
}

