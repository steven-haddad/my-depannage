$(document).ready(function () {
    const visitorsBlock = $('.visitors-block');
    const visitorsCountBlock = visitorsBlock.find('.visitors-counter');
    const minValueVisitors = parseInt(visitorsBlock.data('min-value'));
    const maxValueVisitors = parseInt(visitorsBlock.data('max-value'));
    const strokeValueVisitors = parseInt(visitorsBlock.data('stroke-value'));
    const minIntervalUpdate = parseInt(visitorsBlock.data('min-interval'));
    const maxIntervalUpdate = parseInt(visitorsBlock.data('max-interval'));
    const currentValue = +visitorsCountBlock.text();
    
    setInterval(() => {
        let visitorsCount = getRandomInt(minValueVisitors, maxValueVisitors);
    if (Math.abs(currentValue - visitorsCount) > strokeValueVisitors) {
        visitorsCount = visitorsCount > currentValue ? currentValue + strokeValueVisitors : currentValue - strokeValueVisitors;
        visitorsCount = getRandomInt(currentValue, visitorsCount);
        
    }

    visitorsCountBlock.text(visitorsCount);
}, getRandomInt(minIntervalUpdate, maxIntervalUpdate) * 1000);

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min)) + min;
    }
});