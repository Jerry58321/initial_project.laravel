function generateDateTimeRangePicker(id, useTimePicker = true) {
    const dateLang = {
        daysOfWeek: ["日", "一", "二", "三", "四", "五", "六"],
        monthNames: ["一月", "二月", "三月", "四月", "五月", "六月", "七月", "八月", "九月", "十月", "十一月", "十二月"],
        applyLabel: "submit",
        cancelLabel: "cancel"
    };

    let format = useTimePicker ? 'YYYY-MM-DD HH:mm:ss' : 'YYYY-MM-DD';

    $(`[id^=${id}]`).daterangepicker({
        locale: {
            daysOfWeek: dateLang.daysOfWeek,
            monthNames: dateLang.monthNames,
            applyLabel: dateLang.applyLabel,
            cancelLabel: dateLang.cancelLabel,
            format: format,
        },
        timePicker: useTimePicker,
        timePickerSeconds: true,
        timePickerIncrement: 1,
        timePicker24Hour: true,
        showDropdowns: true,
        singleDatePicker: true,
        autoUpdateInput: true,
        opens: 'right',
        drops: 'up'
    });
}
