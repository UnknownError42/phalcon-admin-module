function popover(){
    $('[data-toggle="popover"]').popover({
        html: true,
        delay: { "hide": 100 },
        trigger: 'focus'
    });
}