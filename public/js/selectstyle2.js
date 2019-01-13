$('select').each(function() {
    var $this = $(this), numberOfOptions = $(this).children('option').length;

    $this.addClass('s-hidden');

    $this.wrap('<div class="select_s2"></div>');

    $this.after('<div class="styledSelect_s2"></div>');

    var $styledSelect = $this.next('div.styledSelect_s2');

    $styledSelect.text($this.children('option:selected').eq(0).text());
    var $list = $('<ul />', {
        'class': 'options'
    }).insertAfter($styledSelect);

    for(var i = 0; i < numberOfOptions; i++) {
        $('<li />', {
            text: $this.children('option').eq(i).text()
            , rel: $this.children('option').eq(i).val()
        }).appendTo($list);
    }

    var $listItems = $list.children('li');

    $styledSelect.click(function(e) {
        e.stopPropagation();
        $('div.styledSelect_s2.active').each(function() {
            $(this).removeClass('active').next('ul.options').hide();
        });
        $(this).toggleClass('active').next('ul.options').toggle();
    });

    $listItems.click(function(e) {
        e.stopPropagation();
        $styledSelect.text($(this).text()).removeClass('active');
        $this.val($(this).attr('rel'));
        $list.hide();
    });

    $(document).click(function() {
        $styledSelect.removeClass('active');
        $list.hide();
    });

});