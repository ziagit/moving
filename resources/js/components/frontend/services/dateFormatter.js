export default {
    format(date) {
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
        // let ampm = hours >= 12 ? "pm" : "am";
        return year + "-" + month + "-" + day + " " + hours + ":" + minuts;
    },
    monthName(num) {
        var name;
        switch (num) {
            case 1:
                name = "Jan";
                break;
            case 2:
                name = "Feb";

                break;
            case 3:
                name = "Mar";
                break;
            case 4:
                name = "Apr";
                break;
            case 5:
                name = "May";
                break;
            case 6:
                name = "Jun";
                break;
            case 7:
                name = "Jul";
                break;
            case 8:
                name = "Aug";
                break;
            case 9:
                name = "Sep";
                break;
            case 10:
                name = "Oct";
                break;
            case 11:
                name = "Nov";
                break;
            case 12:
                name = "Dec";
                break;
        }
        return name;
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
    }
};
