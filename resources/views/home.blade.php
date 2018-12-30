@extends('layouts.app')
@section('left-bar')
    @include('layouts.list_group')
@endsection
@section('content')
<div class="search-area">
    <div class="title-bar">
        TÌM KIẾM THÔNG TIN HỒ SƠ ĐOÀN VIÊN
        <div class="arrow-down"></div>
    </div>
    <div class="content-area">
        <form class="search-form"> 
            <label>Mã đoàn viên</label>
            <input type="text" name="code" class="search-code" >
            <label> Họ tên</label>
            <input type="text" name="fullname" class="search-fullname">
            <label> Đơn vị </label>
            <select name="group" class="custom-select">
                <option value="0">Select car:</option>
                <option value="1">Audi</option>
                <option value="2">BMW</option>
                <option value="3">Citroen</option>
                <option value="4">Ford</option>
                <option value="5">Honda</option>
                <option value="6">Jaguar</option>
                <option value="7">Land Rover</option>
                <option value="8">Mercedes</option>
                <option value="9">Mini</option>
                <option value="10">Nissan</option>
                <option value="11">Toyota</option>
                <option value="12">Volvo</option>
            </select>
            <input type="submit" value='Tìm kiếm'>
        </form>
    </div>
</div>
<div class="body">
321
</div>
<script>
$('select').each(function () {

// Cache the number of options
var $this = $(this),
    numberOfOptions = $(this).children('option').length;

// Hides the select element
$this.addClass('s-hidden');

// Wrap the select element in a div
$this.wrap('<div class="select"></div>');

// Insert a styled div to sit over the top of the hidden select element
$this.after('<div class="styledSelect"></div>');

// Cache the styled div
var $styledSelect = $this.next('div.styledSelect');

// Show the first select option in the styled div
$styledSelect.text($this.children('option').eq(0).text());

// Insert an unordered list after the styled div and also cache the list
var $list = $('<ul />', {
    'class': 'options'
}).insertAfter($styledSelect);

// Insert a list item into the unordered list for each select option
for (var i = 0; i < numberOfOptions; i++) {
    $('<li />', {
        text: $this.children('option').eq(i).text(),
        rel: $this.children('option').eq(i).val()
    }).appendTo($list);
}

// Cache the list items
var $listItems = $list.children('li');

// Show the unordered list when the styled div is clicked (also hides it if the div is clicked again)
$styledSelect.click(function (e) {
    e.stopPropagation();
    $('div.styledSelect.active').each(function () {
        $(this).removeClass('active').next('ul.options').hide();
    });
    $(this).toggleClass('active').next('ul.options').toggle();
});

// Hides the unordered list when a list item is clicked and updates the styled div to show the selected list item
// Updates the select element to have the value of the equivalent option
$listItems.click(function (e) {
    e.stopPropagation();
    $styledSelect.text($(this).text()).removeClass('active');
    $this.val($(this).attr('rel'));
    $list.hide();
    /* alert($this.val()); Uncomment this for demonstration! */
});

// Hides the unordered list when clicking outside of it
$(document).click(function () {
    $styledSelect.removeClass('active');
    $list.hide();
});

});
</script>
@endsection
