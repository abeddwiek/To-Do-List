/**
 *
 <button type="button" onclick="my_add_more();" >Add More</button>

 <div class="more_items">
 <div class="item">
 <input type="hidden" name="items[int_key][input_name1]">
 <input type="hidden" name="items[int_key][input_name2]">
 <button type="button" onclick="remove_option(this);" >Remove</button>
 </div>
 </div>

 <script type="module">
 my_add_more() {
    var key = new Date().getTime();

    var selector = '.more_items';

    var template = '<div class="item">
        <input type="hidden" name="items[key][input_name1]">
        <input type="hidden" name="items[key][input_name2]">
        <button type="button" onclick="remove_option(this);" >Remove</button>
    </div>';

    add_more(selector, template);

 }
 </script>
 *
 *
 */

function add_more(selector, template) {
    var more_items = $(selector);
    more_items.append(template);

    rename(more_items);
}
function remove_option(element) {
    var more_items = $(element).parents('.more_items').get(0);
    var item = $(element).parents('.item').get(0);

    $(item).hide().find('input[name], select[name], textarea[name]').each(function () {
        $(this).attr('disabled', 'disabled');
    });

    rename(more_items);
}
function rename(element) {
    $(element).find('input[name], select[name], textarea[name]').each(function () {
        var map = get_map($(this).parents('.item').get(0)).reverse();
        var old_name = $(this).attr('name');
        var new_name = get_field_name(old_name, map);
        $(this).attr('name', new_name);
    });
}
function get_map(item_element, map) {
    if (!map) {
        map = [];
    }
    map.push($(item_element).parent().children('.item').index(item_element));
    var parent_item = $(item_element).parents('.item');
    if ($(parent_item).length) {
        return get_map(parent_item, map);
    } else {
        return map;
    }
}
function get_field_name(name, map, parent_name, index, field_name) {
    if (!index) {
        index = 0;
    }
    if (!field_name) {
        field_name = '';
    }
    var patt = new RegExp(/\[\d+\]/);
    if (parent_name) {
        name = name.replace(parent_name, '');
        name = name.replace(patt, '');
    }
    parent_name = name.substr(0, name.indexOf(name.match(patt)));
    if (patt.test(name)) {
        field_name += parent_name + '[' + map[index] + ']';
        index++;
        return get_field_name(name, map, parent_name, index, field_name);
    } else {
        field_name += name;
        return field_name;
    }
}
