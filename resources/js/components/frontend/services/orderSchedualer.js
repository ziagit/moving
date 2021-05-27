export default {
    movingExpiration(schedualedDate,appointment) {
        let d = new Date(schedualedDate);
        var last2 = appointment.slice(-2);
        var schedualed = new Date(d.getFullYear(), d.getMonth(), d.getDate(), last2);
        var today = new Date();
        const diffTime = Math.abs(schedualed - today);
        const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
        return diffHours>=24?false:true;
    },
    itemExpiration(schedualedDate,appointment) {
        let d = new Date(schedualedDate);
        var last2 = appointment.slice(-2);
        var schedualed = new Date(d.getFullYear(), d.getMonth(), d.getDate(), last2);
        var today = new Date();
        const diffTime = Math.abs(schedualed - today);
        const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
        return diffHours>=2?false:true;
    },
}