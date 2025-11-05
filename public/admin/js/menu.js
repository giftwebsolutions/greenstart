$(document).ready(function () {
    let menu_type = 'default';
    /**
     * Show loading spinner on AJAX start, hide on AJAX stop.
     */
    $(document).ajaxStart(function () {
        $("#ajax_loader").show();
    }).ajaxStop(function () {
        $("#ajax_loader").hide('slow');
    });

    /**
     * Change label on keyup.
     */
    $(document).on('keyup', '.edit-menu-item-title', function () {
        const title = $(this).val();
        const index = $('.edit-menu-item-title').index($(this));
        $('.menu-item-title').eq(index).html(title);
    });

    /**
     * Change URL on keyup.
     */
    $(document).on('keyup', '.edit-menu-item-url', function () {
        const url = $(this).val();
        const index = $('.edit-menu-item-url').index($(this));
        const result = url.length > 30 ? `${url.slice(0, 30)}...` : url;
        $('.menu-item-link').eq(index).html(result);
    });

    $('#linkType').on('change', function () {
        var type = $(this).val();
        menu_type = type;
        fetchLinkData(type);
    });

    window.fetchLinkData = function fetchLinkData(type) {
        $.ajax({
            url: URL_FETCH_MENU,
            type: 'GET',
            data: { type: type },
            success: function (data) {
                console.log(data);
                var html = '';
                if (type == 'custom') {
                    html += '<div class="form-group my-2">';
                    html += '    <label for="label">Enter Label</label>';
                    html += '    <input type="text" class="form-control" name="label" placeholder="Label Menu"> </div>';
                    html += '<div class="form-group my-2">';
                    html += '<label for="url">URL</label><input type="text" class="form-control" id="url" name="url" required> </div>';
                } else {
                    html += '<div id="itemCheckboxContainer">';
                    data.forEach(function (item) {
                        html += '<div class="form-check">';
                        html += '<input class="form-check-input" type="checkbox" data-url="' + item.url + '" data-label="' + item.name + '" value="' + item.id + '" name="menu_id" id="itemCheckbox-' + item.url + '">';
                        html += '<label class="form-check-label" for="itemCheckbox-' + item.url + '">' + item.name + '</label>';
                        html += '</div>';
                    });
                    html += '</div>';
                }
                $('#linkDataContainer').html(html);
            }
        });
    }

    fetchLinkData($('#linkType').val());

    /**
     * Add item to menu.
     * @param {Event} e - The event object.
     * @param {string} type - The type of menu item.
     */
    window.addItemMenu = function addItemMenu(e) {
        let data = [];
        const form = $('form#menu-item-form');

        if (menu_type === "default") {
            const label = form.find('input[name="label"]').val();
            const url = form.find('input[name="url"]').val();
            if (!label || !url) {
                alert('Please enter label and url');
                return;
            }
            data.push({
                label: label,
                url: url,
                role: form.find('select[name="role"]').val(),
                icon: form.find('input[name="icon"]').val(),
                id: $('#idmenu').val()
            });
        } else {
            const checkboxes = form.find('input[name="menu_id"]:checked');
            let flag = false;
            checkboxes.each(function () {
                const element = $(this);
                const label = element.attr('data-label');
                const url = element.attr('data-url');
                if (!label || !url) {
                    flag = true;
                    return false;
                }
                data.push({
                    label: label,
                    url: url,
                    role: form.find('select[name="role"]').val(),
                    icon: element.attr('data-icon'),
                    id: $('#idmenu').val()
                });
            });
            if (flag) {
                alert('Please enter label and url');
                return;
            }
        }

        $.ajax({
            data: { data: data },
            url: URL_CREATE_ITEM_MENU,
            type: 'POST',
            success: function (response) {
                window.location.reload();
                //$('#linkDataContainer').empty();
                //fetchLinkData($('#linkType').val());
            },
            error: function (xhr, status, error) {
                console.error('Error adding menu item:', error);
            }
        });
    };

    /**
     * Update menu item.
     * @param {number} [id=0] - The ID of the item to update.
     */
    window.updateItem = function updateItem(id = 0) {
        let data;

        if (id) {
            const label = $(`#label-menu-${id}`).val();
            const classes = $(`#clases-menu-${id}`).val();
            const url = $(`#url-menu-${id}`).val();
            const icon = $(`#icon-menu-${id}`).val();
            const target = $(`#target-menu-${id}`).val();
            const role_id = $(`#role_menu_${id}`).length ? $(`#role_menu_${id}`).val() : 0;

            if (!label || !url) {
                alert('Please enter label and url');
                return;
            }

            data = {
                label: label,
                classes: classes,
                url: url,
                icon: icon,
                target: target,
                role_id: role_id,
                id: id
            };
        } else {
            const arr_data = [];
            let flag = false;

            $('.menu-item-settings').each(function () {
                const id = $(this).find('.edit-menu-item-id').val();
                const label = $(this).find('.edit-menu-item-title').val();
                const classes = $(this).find('.edit-menu-item-classes').val();
                const url = $(this).find('.edit-menu-item-url').val();
                const icon = $(this).find('.edit-menu-item-icon').val();
                const role = $(this).find('.edit-menu-item-role').val();
                const target = $(this).find('select.edit-menu-item-target option:selected').val();

                if (!label || !url) {
                    flag = true;
                    return false;
                }

                arr_data.push({
                    id: id,
                    label: label,
                    class: classes,
                    link: url,
                    icon: icon,
                    target: target,
                    role_id: role
                });
            });

            if (flag) {
                alert('Please enter label and url');
                return;
            }

            data = { dataItem: arr_data };
        }

        $.ajax({
            data: data,
            url: URL_UPDATE_ITEM_MENU,
            type: 'POST',
            success: function (response) {
                console.log('Menu item updated successfully');
                $('#linkDataContainer').empty();
                fetchLinkData($('#linkType').val());
            },
            error: function (xhr, status, error) {
                console.error('Error updating menu item:', error);
            }
        });
    };

    /**
     * Update menu.
     * @param {Array} serialize - The serialized menu data.
     */
    window.actualizarMenu = function actualizarMenu(serialize) {
        const menuName = $('#menu-name').val();
        if (menuName) {
            $.ajax({
                dataType: 'json',
                data: {
                    data: serialize,
                    menuName: menuName,
                    idMenu: $('#idmenu').val(),
                    class: $('#menu-class').val()
                },
                url: URL_UPDATE_ITEMS_AND_MENU,
                type: 'POST',
                success: function (response) {
                    $(`select[name="menu"] option[value="${$('#idmenu').val()}"]`).html(menuName);
                },
                error: function (xhr, status, error) {
                    console.error('Error updating menu:', error);
                }
            });
        } else {
            alert('Please enter menu name!');
        }
    };

    /**
     * Delete menu item.
     * @param {number} id - The ID of the item to delete.
     */
    window.deleteItem = function deleteItem(id) {
        $.ajax({
            dataType: 'json',
            data: { id: id },
            url: URL_DELETE_ITEM_MENU,
            type: 'POST',
            success: function (response) {
                window.location = URL_FULL;
                //$('#linkDataContainer').empty();
                //fetchLinkData($('#linkType').val());
            },
            error: function (xhr, status, error) {
                console.error('Error deleting menu item:', error);
            }
        });
    };

    /**
     * Delete menu.
     */
    window.deleteMenu = function deleteMenu() {
        if (confirm('Do you want to delete this menu?')) {
            $.ajax({
                dataType: 'json',
                data: { id: $('#idmenu').val() },
                url: URL_DELETE_MENU,
                type: 'POST',
                success: function (response) {
                    if (!response.error) {
                        alert(response.resp);
                        window.location = URL_CURRENT;
                        //$('#linkDataContainer').empty();
                        //fetchLinkData($('#linkType').val());
                    } else {
                        alert(response.resp);
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error deleting menu:', error);
                }
            });
        }
    };

    /**
     * Create a new menu.
     */
    window.createNewMenu = function createNewMenu() {
        const menuName = $('#menu-name').val();
        if (menuName) {
            $.ajax({
                dataType: 'json',
                data: {
                    name: menuName,
                    class: $('#menu-class').val()
                },
                url: URL_CREATE_MENU,
                type: 'POST',
                success: function (response) {
                    window.location = `${URL_CURRENT}?menu=${response.resp}`;
                },
                error: function (xhr, status, error) {
                    console.error('Error creating menu:', error);
                }
            });
        } else {
            alert('Please enter menu name');
            $('#menu-name').focus();
        }
    };

    if ($('#nestable').length) {
        $('#nestable').nestable({
            expandBtnHTML: '',
            collapseBtnHTML: '',
            maxDepth: 5,
            callback: function (l, e) {
                updateItem();
                actualizarMenu(l.nestable('toArray'));
            }
        });
    }
});
