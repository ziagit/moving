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
        return (
            year +
            "-" +
            month +
            "-" +
            day +
            " " +
            hours +
            ":" +
            minuts
        );
    },
}