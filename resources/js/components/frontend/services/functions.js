import localData from "./localData";
export default {
    validDate() {
        let today = new Date();
        let year = today.getFullYear();
        let month = today.getMonth();
        month = month < 9 ? "0" + (month + 1) : month + 1;
        let day = today.getDate();
        day = day < 10 ? "0" + day : day;
        return year + "-" + month + "-" + day;
    },
    calcDw(item) {
        let x = ((item.length * item.width * item.height) / 166) * item.number;
        let y = item.weight * item.number;
        let dw = x >= y ? x : y;
        return dw;
    },
    totalWeight(items) {
        let total = 0;
        items.forEach(element => {
            total = total + parseFloat(element.weight);
        });
        return total;
    },

    getDaysName(num) {
        switch (num) {
            case 0:
                return "Sun";
            case 1:
                return "Mon";
            case 2:
                return "Tue";
            case 3:
                return "Wed";
            case 4:
                return "Thu";
            case 5:
                return "Fri";
            case 6:
                return "Sat";
        }
    },
    getTimeRanges(time) {
        var time = parseInt(time);
        switch (time) {
            case 6:
                return "6:00pm";
            case 7:
                return "7:00am";
            case 8:
                return "8:00am";
            case 9:
                return "9:00am";
            case 10:
                return "10:00am";
            case 11:
                return "11:00am";
            case 12:
                return "12:00am";
            case 13:
                return "1:00pm";
            case 14:
                return "2:00pm";
            case 15:
                return "3:00pm";
            case 16:
                return "4:00pm";
            case 17:
                return "5:00pm";
            default:
                return "not available";
        }
        const ranges = [];
        const date = new Date();
        const format = {
            hour: "numeric",
            minute: "numeric"
        };
        for (let minutes = 0; minutes < 24 * 60; minutes = minutes + interval) {
            date.setHours(0);
            date.setMinutes(minutes);
            ranges.push(date.toLocaleTimeString(language, format));
        }
        return ranges.slice(from, to);
    },
    myDateFormat(date) {
        let myDate = new Date(date);
        let year = myDate.getFullYear();
        let month = myDate.getMonth();
        month = month < 9 ? "0" + (month + 1) : month + 1;
        let day = myDate.getDate();
        day = day < 10 ? "0" + day : day;
        let hours = myDate.getHours();
        hours = hours < 10 ? "0" + hours : hours;
        let minuts = myDate.getMinutes();
        minuts = minuts < 10 ? "0" + minuts : minuts;
        let ampm = hours >= 12 ? "pm" : "am";
        return (
            year +
            "-" +
            month +
            "-" +
            day +
            " " +
            hours +
            ":" +
            minuts +
            " " +
            ampm
        );
    },

    phoneValidator(phone) {
        let pattern = /^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im;
        if (phone.match(pattern)) {
            return true;
        } else {
            return false;
        }
    },
    emailValidator(email) {
        let pattern = /(?!.*\.{2})^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        if (email.match(pattern)) {
            return true;
        } else {
            return false;
        }
    },
    async buildOrder() {
        let order = {};
        order["from"] = await localData.read("from");
        order["to"] = await localData.read("to");
        order["moving_size"] = await localData.read("moving-size");
        order["vehicle"] = await localData.read("vehicle");
        order["number_of_movers"] = await localData.read("number-of-movers");
        order["floors"] = await localData.read("floors");
        order["moving_date"] = await localData.read("moving-date");
        order["instructions"] = await localData.read("instructions");
        order["contacts"] = await localData.read("contacts");
        order["items"] = await localData.read("moving-items");
        order["moving_type"] = await localData.read("moving-type");
        order["distance"] = await localData.read("distance");
        order["duration"] = await localData.read("duration");
        order["supplies"] = this.buildSupplies();
        order["carrier"] = await localData.read("carrier");
        order["shipper"] = await localData.read("shipper");

        return order;
    },
    buildDate() {
        let d = localData.read("moving-date");
        return d.date.year + "-" + (d.date.month<10?"0"+d.date.month:d.date.month) + "-" + (d.date.date<10?"0"+d.date.date:d.date.date);
    },
    buildTime() {
        let t = localData.read("moving-date");
        return (t.time.from<10?'0'+t.time.from:t.time.from) + "-" + (t.time.to<10?'0'+t.time.to:t.time.to);
    },
    buildSupplies() {
        let supplies = localData.read("supplies");
        var sups = [];
        if (supplies) {
            for (let i = 0; i < supplies.enabled.length; i++) {
                let obj = {
                    name: "",
                    code: "",
                    number: ""
                };
                if (supplies.enabled[i] != null) {
                    obj.name = supplies.enabled[i];
                    obj.code = supplies.enabled[i]
                        .toLowerCase()
                        .replace(/\s/g, "");
                    obj.number = supplies.number[i];
                    sups.push(obj);
                }
            }
            return sups;
        }
    }
};
