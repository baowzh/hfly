(function($){
    var methods = {
        defaults:{
            formatDisplay: function (data, $item, $mpItem) {
                if ($mpItem) {
                    return $mpItem.html();
                }else {
                    return data;
                }
            },
            formatRemove: function () {
                return 'X';
            },
            formatValue: function (data, $value, $item, $mpItem) {
                if ($mpItem) {
                    return $mpItem.text();
                }else {
                    return data;
                }
            },
            marcoPolo: false,
            onAdd: function(){},
            onChange: function(){},
            onHighlight: function(){},
            onHighlightRemove: function(){},
            onRemove: function(){},
            onSelect: function(){},
            onSelectRemove: function(){},
            required: false,
            separator: ';',
            values:"",
            valuesName: null
        },

        keys: {
            BACKSPACE: 8,
            DELETE: 46,
            DOWN: 40,
            END: 35,
            ENTER: 13,
            HOME: 36,
            LEFT: 37,
            RIGHT: 39,
            UP: 38
        },
        _marcoPoloOptions: function () {
            var options = methods.options;
            return {
                onFocus: function () {
                    if (options.marcoPolo.onFocus) {
                        options.marcoPolo.onFocus.call(this);
                    }
                    self._resizeInput();
                },
                onRequestAfter: function () {
                    self.$container.parent().removeClass('mf_busy');
                    if (options.marcoPolo.onRequestAfter) {
                        options.marcoPolo.onRequestAfter.call(this);
                    }
                },
                onRequestBefore: function () {
                    self.$container.parent().addClass('mf_busy');
                    if (options.marcoPolo.onRequestBefore) {
                        options.marcoPolo.onRequestBefore.call(this);
                    }
                },
                onSelect: function (mpData, $mpItem) {
                    var add = true;
                    if (options.marcoPolo.onSelect) {
                        add = options.marcoPolo.onSelect.call(this, mpData, $mpItem);
                    }
                    if (add !== false) {
                        self.add(mpData, $mpItem, true, false);
                    }
                },
                required: options.required
            };
        },

        init:function(settings){
            var originalValue,
                $input;

            methods.options = $.extend(true, {}, methods.defaults, settings);

            methods.$input = $input = this.addClass("mf_input");
            methods.inputName = 'mf_' + ($input.attr('name') || $.now());

            methods.$container = $('<div class="mf_container"/>');
            methods.$list = $('<ol class="mf_list"/> ')
                .attr({ 'id':methods.inputName + '_list'});
            methods.$measure = $('<span class="mf_measure"/> ');

            methods.mousedown = false;
            methods.mpMousedown = false;

            methods.inputOriginals = {
                'width':$input.css('width')
            };

            if(methods.options.marcoPolo){
                originalValue = $input.val();
                $input.val('');
                self._bindMarcoPolo();

                $input.val(originalValue);
            }else{
               /* $input.attr({
                    'aria-owns':methods.$list.attr('id'),
                    'role':'combobox'
                }); */
            }

            methods._bindInput()
                ._bindList()
                ._bindContainer()
                ._bindDocument();

            $input
                .wrap(methods.$container)
                .before(methods.$list)
                .after(methods.$measure);

            methods.$container = $input.parent();

            if(methods.options.values){
                methods.add(methods.options.values,null,false,true);
            }

            methods
                ._addInputValues()
                ._styleMeasure()
                ._resizeInput();
        },

        _setOption:function(option,value){
            var $input = methods.$input;

            switch (option){
                case 'marcoPolo':
                    if(methods.options.marcoPolo){
                        if(value){
                            $input.marcoPolo('option', $.extend({},value,methods._marcoPoloOptions()));
                        }else{
                            $input.marcoPolo('destroy');
                        }
                    }else if(value){
                        methods._bindMarcoPolo($.extend({},value,methods._marcoPoloOptions()));
                        $input.marcoPolo('list').insertAfter($input.parent());
                    }
                    break;
                case 'required':
                    if(methods.options.marcoPolo){
                        $input.marcoPolo('option','required',value);
                    }
                    break;
                case 'valuesName':
                    methods.$list
                        .find('input:hidden.mf_value')
                        .attr('name',value + '[]');
                    break;
            }
        },

        _bindMarcoPolo:function(mpOptions){
            var $input = methods.$input,
                options = methods.options;

            if(mpOptions === undefined){
                mpOptions = $.extend({},options.marcoPolo,methods._marcoPoloOptions());
            }
            $input.marcoPolo(mpOptions);

            $input.marcoPolo('list').bind('mousedown.manifest',function(){
                methods.mpMousedown = true;
            });
            return self;
        },

        _bindInput:function(){
            var $input = methods.$input,
                options = methods.options,
                preventMarcoPoloCollision = options.marcoPolo && options.marcoPolo.minChars === 0,
                collisionkeys = [
                    methods.keys.UP,
                    methods.keys.DOWN,
                    methods.keys.HOME,
                    methods.keys.END
                ];

            $input.bind('keydown.manifest',function(key){
                methods._resizeInput();
                if(!options.required && methods._isSeparator(key.which)){

                    key.preventDefault();
                    if($input.val()){
                        methods.add($input.val(),null,true,false);
                    }
                    return;
                }

                if(key.which === methods.keys.ENTER){
                    key.preventDefault();
                    return;
                }

                if($input.val()){
                    return;
                }

                if(preventMarcoPoloCollision && $.inArray(key.which,collisionkeys)!==-1){
                    return;
                }

                switch (key.which){
                    case methods.keys.BACKSPACE:
                    case methods.keys.DELETE:
                        var $selected = methods._selected();

                        if ($selected.length) {
                            methods.remove($selected);
                        }else {
                            methods._selectPrev();
                        }
                        break;
                    case methods.keys.LEFT:
                    case methods.keys.UP:
                        methods._selectPrev();
                        break;
                    case methods.keys.RIGHT:
                    case methods.keys.DOWN:
                        methods._selectNext();
                        break;
                    case methods.keys.HOME:
                        methods._selectFirst();
                        break;
                    case methods.keys.END:
                        methods._selectLast();
                        break;
                    default:
                        methods._removeSelected();
                        break;
                }
            })
                .bind('keypress.manifest',function(key){
                    if (!options.required && methods._isSeparator(String.fromCharCode(key.which))) {
                        key.preventDefault();
                        if ($input.val()) {
                            methods.add($input.val(), null, true, false);
                        }
                    }
                })
                .bind('keyup.manifest',function(){
                    methods._resizeInput();
                })
                .bind('paste.manifest',function(){
                    setTimeout(function(){
                        methods._resizeInput();
                        if(!options.required && $input.val()){
                            methods.add(methods._splitBySeparator($input.val()),null,true,false);
                        }
                    },1)
                })
                .bind('blur.manifest',function(){
                    setTimeout(function(){
                        if(!methods.mousedown){
                            methods._removeSelected();
                        }
                        if(!methods.mpMousedown){
                            if(options.marcoPolo && options.required){
                                methods._resizeInput();
                            }else if($input.val()){
                                methods.add($input.val(),null,true,false);
                            }
                        }
                    },1);
                });

            return methods;
        },

        _bindList:function(){
            methods.$list
                .delegate('li','mouseover',function(){
                    methods._addHighlight($(this));
                })
                .delegate('li','mouseout',function(){
                    methods._removeHighlight($(this));
                })
                .delegate('li','mousedown',function(){
                    methods.mousedown = true;
                })
                .delegate('li','click',function(event){
                    if($(event.target).is('a.mf_remove')){
                        methods._removeSelected();
                        methods.remove($(this));
                        event.preventDefault();
                    }else{
                        methods._toggleSelect($(this));
                    }
                });
            return methods;
        },

        _bindContainer: function () {
            methods.$container.bind('click.manifest', function () {
                methods.$input.focus();
            });
            return methods;
        },

        _bindDocument:function(){
            var $input = methods.$input;
            $(document).bind('mouseup.manifest',function(event){
                if(methods.mousedown){
                    methods.mousedown = false;
                }
                if(!$(event.target).is('li.mf_item,li.mf_item *')){
                    methods._removeSelected();
                }

                if(methods.mpMousedown){
                    methods.mpMousedown = false;
                    if(methods.options.required){
                        methods._resizeInput();
                    }else if($input.val()){
                        methods.add($input.val(),null,true,false);
                    }
                }
            });
            return methods;
        },

        container:function(){
            return methods.$container;
        },

        list:function(){
            return methods.$list;
        },

        add:function(data,$mpItem,clearInputValue, initial){
            var $input = methods.$input,
                options = methods.options,
                values = $.isArray(data) ? data : [data],
                value,
                $item=$(),
                $remove = $(),
                $value = $(),
                buildItem = function(formatDisplay,formatRemove,formatValue){
                    $item.html(formatDisplay);
                    $remove.html(formatRemove);
                    $value.val(formatValue);
                    $item.append($remove,$value);

                    var allValue = methods.values(),
                         add = methods.options.onAdd(value,allValue,$item);

                    if(add !== false){
                        $item.appendTo(methods.$list);
                        if(!initial){
                            methods.options.onChange(value,$item);
                        }
                    }
                };
            console.log(values)
            for(var i =0 ,length = values.length;i<length;i++){
                value = values[i];
                if(typeof value === 'string'){
                    value = $.trim(value);
                }
                if(!value || ($.isPlainObject(value) && $.isEmptyObject(value))){
                    continue;
                }
                $item = $('<li class="mf_item" role="option"/> ');
                $remove = $('<a href="#" class="mf_remove" title="Remove" />');
                $value = $('<input type="hidden" class="mf_value" />');

                if (options.valuesName) {
                    $value.attr('name', options.valuesName + '[]');
                }else {
                    $value.attr('name', $input.attr('name') + '_values[]');
                }

                $item.data('manifest', value);

                $.when(options.formatDisplay.call($input, value, $item, $mpItem),
                    options.formatRemove.call($input, $remove, $item),
                    options.formatValue.call($input, value, $value, $item, $mpItem))
                    .then(buildItem);
            }
            if (clearInputValue) {
                methods._clearInputValue();
            }
        },

        _addInputValues:function(){
            var methods = this,
                $input = methods.$input,
                data = $input.data('values'),
                value = $input.val(),
                values = [];
            if(data){
                values = $.isArray(data) ? data :[data];
            }else if(value){
                values = methods._splitBySeparator(value);
            }
            if(values.length){
                methods.add(values,null,true,true);
            }
            return methods;
        },
        remove:function(selector){
            var methods = this,
                $item = $();
            if(selector instanceof jQuery){
                $item = selector;
            }else{
                $item = methods.$list.children(selector);
            }
            $item.each(function(){
                var $item = $(this),
                    data = $item.data('manifest');
                var remove = methods.options.onRemove(data,$item);
                if(remove !== false){
                    if(methods._isSelected($item)){
                        methods._removeSelect($item);
                    }
                    $item.remove();

                    methods.options.onChange(data,$item);
                }
            });
        },

        values: function () {
            var methods = this,
                $list = methods.$list,
                values = [];

            $list.find('input:hidden.mf_value').each(function () {
                values.push($(this).val());
            });

            return values;
        },

        destroy: function () {
            var methods = this,
                $input = methods.$input;

            // Destroy Marco Polo.
            if (methods.options.marcoPolo) {
                $input.marcoPolo('destroy');
            }

            methods.$list.remove();
            methods.$measure.remove();
            $input
                .unwrap()
                .removeClass('mf_input')
                // Join the added item values together and set as the input value.
                .val(methods._joinWithSeparator(methods.values()));

            // Reset the input to its original attribute values.
            $.each(methods.inputOriginals, function (attribute, value) {
                if (value === undefined) {
                    $input.removeAttr(attribute);
                }
                else {
                    $input.attr(attribute, value);
                }
            });

            $(document).unbind('.manifest');
        },

        _styleMeasure: function () {
            var methods = this,
                $input = methods.$input;

            methods.$measure.css({
                'font-family': $input.css('font-family'),
                'font-size': $input.css('font-size'),
                'font-style': $input.css('font-style'),
                'font-variant': $input.css('font-variant'),
                'font-weight': $input.css('font-weight'),
                'left': -9999,
                'letter-spacing': $input.css('letter-spacing'),
                'position': 'absolute',
                'text-transform': $input.css('text-transform'),
                'top': -9999,
                'white-space': 'nowrap',
                'width': 'auto',
                'word-spacing': $input.css('word-spacing')
            });

            return methods;
        },

        _measureText: function (text) {
            var $measure = this.$measure,
                escapedText;

            // Escape certain HTML special characters.
            escapedText = text
                .replace(/&/g, '&amp;')
                .replace(/\s/g, '&nbsp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;');

            $measure.html(escapedText);

            return $measure.width();
        },

        _maxInputWidth: function () {
            var $container = methods.$container,
                $input = methods.$input;

            return $container.width() - ($input.outerWidth(true) - $input.width());
        },

        _resizeInput: function () {
            var $input = methods.$input,
                textWidth;

            textWidth = methods._measureText($input.val() + '---');
            $input.width(Math.min(textWidth, methods._maxInputWidth()));

            return methods;
        },

        _clearInputValue: function () {
            var methods = this,
                $input = methods.$input;

            if (methods.options.marcoPolo) {
                $input.marcoPolo('change', null);
            }
            else {
                $input.val('');
            }

            methods._resizeInput();

            return methods;
        },

        _isSeparator: function (key) {
            var separator = this.options.separator;

            if ($.isArray(separator)) {
                return $.inArray(key, separator) !== -1;
            }else {
                return key === separator;
            }
        },

        _separators: function (onlyChars) {
            var option = this.options.separator,
                separators = $.isArray(option) ? option : [option];

            if (onlyChars) {
                separators = $.grep(separators, function (separator) {
                    return typeof separator === 'string';
                });
            }

            return separators;
        },

        _firstSeparator: function (onlyChars) {
            return this._separators(onlyChars).shift();
        },
        _splitBySeparator: function (value) {
            var separators = this._separators(true),
                values = value;

            if (separators.length) {
                values = value.split(new RegExp('[\\' + separators.join('\\') + ']'));
                values = $.map(values, $.trim);
            }

            return values;
        },
        _joinWithSeparator: function (values) {
            var separator = this._firstSeparator(true) || '';

            return values.join(separator + ' ');
        },
        _firstItem: function () {
            return this.$list.children('li:first');
        },

        _lastItem: function () {
            return this.$list.children('li:last');
        },

        _highlighted: function () {
            return this.$list.children('li.mf_highlighted');
        },

        _addHighlight: function ($item) {
            var methods = this;

            if (!$item.length) {
                return methods;
            }
            methods._removeHighlighted();

            $item.addClass('mf_highlighted');

            methods.options.onHighlight($item.data('marcoPolo'), $item);
            return methods;
        },

        _removeHighlight: function ($item) {
            var methods = this;

            if (!$item.length) {
                return methods;
            }

            $item.removeClass('mf_highlighted');

            methods.options.onHighlightRemove($item.data('marcoPolo'), $item);
            return methods;
        },

        _removeHighlighted: function () {
            return this._removeHighlight(this._highlighted());
        },

        _selected: function () {
            return this.$list.children('li.mf_selected');
        },

        _isSelected: function ($item) {
            return $item.hasClass('mf_selected');
        },

        _addSelect: function ($item) {
            var methods = this;

            if (!$item.length) {
                return methods;
            }
            methods._removeSelected();

            $item
                .addClass('mf_selected')
                .attr({
                    'aria-selected': 'true',
                    'id': methods.inputName + '_selected'
                });

            methods.options.onSelect($item.data('marcoPolo'), $item);
            return methods;
        },

        _removeSelect: function ($item) {
            var methods = this;

            if (!$item.length) {
                return methods;
            }

            $item
                .removeClass('mf_selected')
                .attr('aria-selected', 'false')
                .removeAttr('id');

            methods.$list.removeAttr('aria-activedescendant');

            methods.options.onSelectRemove($item.data('marcoPolo'), $item);
            return methods;
        },

        _removeSelected: function () {
            return this._removeSelect(this._selected());
        },

        _toggleSelect: function ($item) {
            if (this._isSelected($item)) {
                return this._removeSelect($item);
            }
            else {
                return this._addSelect($item);
            }
        },

        _selectPrev: function () {
            var methods = this,
                $selected = methods._selected(),
                $prev = $();

            if ($selected.length) {
                $prev = $selected.prev();
            }

            else {
                $prev = methods._lastItem();
            }

            if ($prev.length) {
                methods._addSelect($prev);
            }

            return methods;
        },

        _selectNext: function () {
            var methods = this,
                $selected = methods._selected(),
                $next = $selected.next();

            if ($next.length) {
                return methods._addSelect($next);
            }
            else {
                return methods._removeSelect($selected);
            }
        },

        _selectFirst: function () {
            return this._addSelect(this._firstItem());
        },

        _selectLast: function () {
            return this._addSelect(this._lastItem());
        }
    };
    $.fn.manifest = function(method){
        if (methods[method]) {

            return methods[method].apply(this, Array.prototype.slice.call(arguments, 1));
        } else if (typeof method === 'object' || !method) {
            return methods.init.apply(this, arguments);
        } else {
            $.error('Method ' + method + ' does not exist!');
        }
    };

})(jQuery);