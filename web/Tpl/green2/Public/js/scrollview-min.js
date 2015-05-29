if(typeof SODON == "undefined" || !SODON){ var SODON = {}; SODON.util = {}; SODON.widget = {}; SODON.example = {}; }

(function() {

    var Dom = YAHOO.util.Dom;
    var Event = YAHOO.util.Event;

    /**
     * A widget to control scrolled views
     * @namespace SODON.widget
     * @class ScrollView
     * @constructor
     * @param {HTMLElement | String} container
     * @param {Object} config
     */
    SODON.widget.ScrollView = function(container, config) {
        this.init.apply(this, arguments);
    };

    /**
     * Scroll-iin cofiguration iig beltgedeg class.
     * @namespace SODON.widget.ScrollView
     * @class cfg
     * @param {Object} owner
     */
    SODON.widget.ScrollView.cfg = function(owner) {
        SODON.widget.ScrollView.cfg.superclass.constructor.apply(this, arguments);
    };

    YAHOO.extend(SODON.widget.ScrollView.cfg, SODON.util.Config, {

        _DEFAULT_CONFIG: {

            /**
             * @description scrollview-giin chigleliig zaana. 2 hon chigleltei. 1-hevtee, 2-bosoo.
             * @propery direction
             * @type String
             */
            direction: "horizontal",

            /**
             * @description delgetsend garah item-iin toog zaana.
             * @property screenSize
             * @type Integer
             */
            screenSize: 1,

            /**
             * @description Hed hedeer guilgehiig zaadag property.
             * @propery moveSize
             * @type moveSize
             */
            moveSize: 1,

            /**
             * @description Neg item-iin urgun
             * @property itemWidth
             * @type Integer
             */
            itemWidth: null,

            /**
             * @description Neg item-iin undur
             * @property itemHeight
             * @type Integer
             */
            itemHeight: null,

            /**
             * @description item hoorondoh zai
             * @property itemSpace
             * @type Integer
             */
            itemSpace: null,

            /**
             * @description Hudulguunii helber
             * @property easing
             * @type YAHOO.util.Easing.easeOut
             */
            easing: YAHOO.util.Easing.easeOut,

            /**
             * @description Hudulguunii hurd
             * @property speed
             * @type Integer
             */
            speed: 1,

            /**
             * @description Huleeh hugatsaa
             * @property waitTime
             * @type Integer
             */
            waitTime: 3000,

            /**
             * @description deesh yavuuldag tovch.
             * @property upButton
             * @type String
             */
            upButton: null,

            /**
             * @description doosh yavuuldag tovch.
             * @property downButton
             * @type String
             */
            downButton: null,

            /**
             * @description zuun tiish yavuuldag tovch.
             * @property prevButton
             * @type String
             */
            prevButton: null,

            /**
             * @description baruun tiish yavuuldag tovch.
             * @property nextButton
             * @type String
             */
            nextButton: null,

            /**
             * @description Idevhitei event.
             * @property activeEvent
             * @type String
             */
            activeEvent: 'click',

            /**
             * @description
             * @property auto
             * @type Boolean
             */
            auto: false,

            /**
             * @description
             * if repeat = "repeat" Ehnees ni davtana
             * if repeat = "repeat-back" Ehnees ni davtah bolovch shuud guilgene. insertAfter bolon insertBefore geh met function -uudiig ashiglahgui
             * if repeat = "norepeat" Dahin ehnees ni davtahgui. Gehdee uuniig hiigeegui baigaa
             * @property repeat
             * @type String
             */
            repeat: "repeat"
        }

    });

    SODON.widget.ScrollView.prototype = {

        /**
         * @property oContainer
         * @type HTMLElement
         */
        oContainer: null,

        /**
         *
         * @property _items
         * @type HTMLElement
         */
        _items: null,

        /**
         *
         * @property _mask
         * @type HTMLElement
         */
        _mask: null,

        /**
         * @property Config
         * @private
         * @type Object
         */
        Config: null,

        /**
         * @description tohirgoonuudiig hadgaldag property
         * @property cfg
         * @type Object
         */
        cfg: null,

        /**
         * @description
         * @property anim
         * @type Object
         */
        anim: null,

        /**
         * @description Hudluh chigleliig hadgaldag property
         * @property moveDirection
         * @type String
         */
        moveDirection: null,

        VERTICAL: "vertical",
        HORIZONTAL: "horizontal",
        TOP: "top",
        BOTTOM: "bottom",
        LEFT: "left",
        RIGHT: "right",

        /**
         * @description baiguulagch method.
         * @method init
         * @param {String} container
         * @param {Object} config
         */
        init: function(container, config) {
            var self = this;
            this.oContainer = Dom.get(container) || "scroll-container";
            this._items = Dom.getChildren(this.oContainer);
            this._mask = this.oContainer.parentNode;

            this.Config = {};
            this.cfg = new SODON.widget.ScrollView.cfg(this);
            this.cfg.setupConfig();
            if ( config != null ) { this.cfg.setConfig(config); }

            var direction = this.cfg.getConfigProperty("direction");
            var itemWidth = this.cfg.getConfigProperty("itemWidth");
            var itemHeight = this.cfg.getConfigProperty("itemHeight");
            var itemSpace = this.cfg.getConfigProperty("itemSpace");
            var screenSize = this.cfg.getConfigProperty("screenSize");
            var auto = this.cfg.getConfigProperty("auto");
            var waitTime = this.cfg.getConfigProperty("waitTime");

            /* for set buttons's visible */
            if ( !this._isShowButtons() ) {
                if ( direction == this.VERTICAL ) {
                    this._setVisibleOfUpButton(false);
                    this._setVisibleOfDownButton(false);
                } else {
                    this._setVisibleOfPrevButton(false);
                    this._setVisibleOfNextButton(false);
                }
            }
            // end of set button's visible

            /* FOR INIT SETTINGS */

            /* for container */
            Dom.setStyle(this.oContainer, "position", "absolute");
            Dom.setStyle(this.oContainer, "float", "left");
            Dom.setStyle(this.oContainer, "display", "inline");
            Dom.setStyle(this.oContainer, "top", "0px");
            Dom.setStyle(this.oContainer, "left", "0px");

            if ( direction == this.VERTICAL ) {
                Dom.setStyle(this.oContainer, "width", itemWidth + "px");
                Dom.setStyle(this.oContainer, "height", ( this._items.length * ( itemHeight + itemSpace ) ) + "px");
            } else {
                Dom.setStyle(this.oContainer, "width", ( this._items.length * ( itemWidth + itemSpace ) ) + "px");
                Dom.setStyle(this.oContainer, "height", itemHeight + "px");
            }
            /* end of container */

            /* for mask */
            Dom.setStyle(this._mask, "position", "relative");
            Dom.setStyle(this._mask, "overflow", "hidden");
            Dom.setStyle(this._mask, "float", "left");
            Dom.setStyle(this._mask, "display", "inline");

            var tempWidth = 0;
            var tempHeight = 0;
            if ( direction == this.VERTICAL ) {
                tempWidth = itemWidth;
                Dom.setStyle(this._mask, "width", tempWidth + "px");
                tempHeight = screenSize * ( itemHeight + itemSpace ) - itemSpace;
                Dom.setStyle(this._mask, "height", tempHeight + "px");
            } else {
                tempWidth = screenSize * ( itemWidth + itemSpace ) - itemSpace;
                Dom.setStyle(this._mask, "width", tempWidth + "px");
                tempHeight = itemHeight;
                Dom.setStyle(this._mask, "height", tempHeight + "px");
            }
            /* end of mask */

            /* for items */
            i = 0;
            while ( i < this._items.length ) {
                Dom.setStyle(this._items[i], "overflow", "hidden");
                Dom.setStyle(this._items[i], "float", "left");
                Dom.setStyle(this._items[i], "display", "inline");
                Dom.setStyle(this._items[i], "width", itemWidth + "px");
                Dom.setStyle(this._items[i], "height", itemHeight + "px");

                var divSep = document.createElement("div");
                Dom.insertAfter(divSep, this._items[i]);

                Dom.setStyle(divSep, "float", "left");
                Dom.setStyle(divSep, "display", "inline");
                Dom.addClass(divSep, "seperator");

                if ( direction == this.VERTICAL ) {
                    Dom.setStyle(divSep, "width", itemWidth + "px");
                    Dom.setStyle(divSep, "height", itemSpace + "px");
                } else {
                    Dom.setStyle(divSep, "width", itemSpace + "px");
                    Dom.setStyle(divSep, "height", itemHeight + "px");
                }
                i++;
            }
            /* end of items */

            this.anim = new YAHOO.util.Anim(this.oContainer, {});
            /* END OF INIT SETTINGS */

            if ( auto ) {
                YAHOO.lang.later(waitTime, auto, function(){
                    self.nextMove();
                }, {}, true);
            }

            this.initEvents();
        },

        /**
         * @description deesh move hiideg method.
         * @method upMove
         */
        upMove: function() {
            if ( this.isMove(this.TOP) ) {
                this.moveDirection = this.TOP;
                this.repeatManage();
            }
        },

        /**
         * @description doosh move hiideg method.
         * @method downMove
         */
        downMove: function() {
            if ( this.isMove(this.BOTTOM) ) {
                this.moveDirection = this.BOTTOM;
                this.repeatManage();
            }
        },

        /**
         * @description zuun tiish move hiideg method.
         * @method prevMove
         */
        prevMove: function() {
            if ( this.isMove(this.LEFT) ) {
                this.moveDirection = this.LEFT;
                this.repeatManage();
            }
        },

        /**
         * @description baruun tiish move hiideg method.
         * @method nextMove
         */
        nextMove: function() {
            if ( this.isMove(this.RIGHT) ) {
                this.moveDirection = this.RIGHT;
                this.repeatManage();
            }
        },

        /**
         * @description Ali neg chiglel ruu yavj boloh esehiig shiiddeg method.
         * @method isMove
         * @param {String} direction
         * @return Boolean
         */
        isMove: function(direction) {
            if ( !this._isShowButtons() ) return false;
            if ( !this.anim.isAnimated() ) {
                if ( this.cfg.getConfigProperty("direction") == this.HORIZONTAL && ( direction == this.RIGHT || direction == this.LEFT ) ) {
                    return true;
                }
                else if ( this.cfg.getConfigProperty("direction") == this.VERTICAL && ( direction == this.TOP || direction == this.BOTTOM ) ) {
                    return true;
                }
            }
            return false;
        },

        /**
         * @description Ene ni repeat uudiig manage hiideg method yum. Er ni bol yug haash ni yaahiig shiiddeg method gesen ug.
         * @method repeatManage
         */
        repeatManage: function() {
            var repeat = this.cfg.getConfigProperty("repeat");

            if ( repeat == "repeat" ) {
                if ( this.moveDirection == this.TOP || this.moveDirection == this.LEFT ) {
                    this.prepareTLByRepeat();
                }
                // call move method
                this.moveByRepeat();
            } else if ( repeat == "repeat-back" ) {
                this.prepareByRepeatBack();
            } else if ( repeat == "norepeat" ) {
                // ene hesgiin code -iig odoogoor bicheegui baigaa.
            }
        },

        /**
         * @description prepare TOP and LEFT By Repeat
         * @method prepareTLByRepeat
         */
        prepareTLByRepeat: function() {
            var itemWidth = this.cfg.getConfigProperty("itemWidth");
            var itemHeight = this.cfg.getConfigProperty("itemHeight");
            var itemSpace = this.cfg.getConfigProperty("itemSpace");

            var currTopPos = parseInt(Dom.getStyle(this.oContainer, "top"));
            var currLeftPos = parseInt(Dom.getStyle(this.oContainer, "left"));

            // item space -iig ni tsugt ni hiih gej doorh uildliig 2 udaa davdav.
            Dom.insertBefore(Dom.getLastChild(this.oContainer), Dom.getFirstChild(this.oContainer));
            Dom.insertBefore(Dom.getLastChild(this.oContainer), Dom.getFirstChild(this.oContainer));
            if ( this.moveDirection == this.TOP ) {
                Dom.setStyle(this.oContainer, "top", (currTopPos - (itemHeight + itemSpace )) + "px");
            } else if ( this.moveDirection == this.LEFT ) {
                Dom.setStyle(this.oContainer, "left", (currLeftPos - (itemWidth + itemSpace)) + "px");
            }
        },

        /**
         * @description prepare BOTTOM and RIGHT By Repeat
         * @method prepareBRByRepeat
         */
        prepareBRByRepeat: function() {
            var itemWidth = this.cfg.getConfigProperty("itemWidth");
            var itemHeight = this.cfg.getConfigProperty("itemHeight");
            var itemSpace = this.cfg.getConfigProperty("itemSpace");

            var currTopPos = parseInt(Dom.getStyle(this.oContainer, "top"));
            var currLeftPos = parseInt(Dom.getStyle(this.oContainer, "left"));

            // item space -iig ni tsugt ni hiih gej doorh uildliig 2 udaa davdav.
            Dom.insertAfter(Dom.getFirstChild(this.oContainer), Dom.getLastChild(this.oContainer));
            Dom.insertAfter(Dom.getFirstChild(this.oContainer), Dom.getLastChild(this.oContainer));
            if ( this.moveDirection == this.BOTTOM ) {
                Dom.setStyle(this.oContainer, "top", (currTopPos + (itemHeight + itemSpace)) + "px");
            } else if ( this.moveDirection == this.RIGHT ) {
                Dom.setStyle(this.oContainer, "left", (currLeftPos + (itemWidth + itemSpace)) + "px");
            }
        },

        /**
         * @description prepare By Repeat Back
         * @method prepareByRepeatBack
         */
        prepareByRepeatBack: function() {
            var screenSize = this.cfg.getConfigProperty("screenSize");
            var moveSize = this.cfg.getConfigProperty("moveSize");
            var itemWidth = this.cfg.getConfigProperty("itemWidth");
            var itemHeight = this.cfg.getConfigProperty("itemHeight");
            var itemSpace = this.cfg.getConfigProperty("itemSpace");

            var attributes = {};

            var currTopPos = parseInt(Dom.getStyle(this.oContainer, "top"));
            var currLeftPos = parseInt(Dom.getStyle(this.oContainer, "left"));

            var topFirstPos = 0;
            var bottomLastPos = (-1) * (this._items.length - screenSize) * ( itemHeight + itemSpace );
            var leftFirstPos = 0;
            var rightLastPos = (-1) * (this._items.length - screenSize) * ( itemWidth + itemSpace );

            if ( this.moveDirection == this.TOP && currTopPos == topFirstPos ) {
//                alert("top, first");
                attributes = { top: { to: bottomLastPos, unit: "px" } };
            } else if ( this.moveDirection == this.BOTTOM && currTopPos == bottomLastPos ) {
//                alert("bottom, last");
                attributes = { top: { to: topFirstPos, unit: "px" } };
            } else if ( this.moveDirection == this.LEFT && currLeftPos == leftFirstPos ) {
//                alert("left, first");
                attributes = { left: { to: rightLastPos, unit: "px" } };
            } else if ( this.moveDirection == this.RIGHT && currLeftPos == rightLastPos ) {
//                alert("right, last");
                attributes = { left: { to: leftFirstPos, unit: "px" } };
            } else {
                if ( this.moveDirection == this.TOP ) {
                    var toTop = ( currTopPos + moveSize * (itemHeight + itemSpace) );
                    attributes = { top: { to: toTop, unit: "px" } };
                } else if ( this.moveDirection == this.BOTTOM ) {
                    var toBottom = ( currTopPos - moveSize * (itemHeight + itemSpace) );
                    attributes = { top: { to: toBottom, unit: "px" } };
                } else if ( this.moveDirection == this.LEFT ) {
                    var toLeft = ( currLeftPos + moveSize * (itemWidth + itemSpace) );
                    attributes = { left: { to: toLeft, unit: "px" } };
                } else if ( this.moveDirection == this.RIGHT ) {
                    var toRight = ( currLeftPos - moveSize * (itemWidth + itemSpace) );
                    attributes = { left: { to: toRight, unit: "px" } };
                }
            }
            // call move By Repeat Back
            this.moveByRepeatBack(attributes);
        },

        /**
         * @description move hiideg function.
         * @method moveByRepeat
         */
        moveByRepeat: function() {
            var self = this;
            var attributes = {};
            var moveSize = this.cfg.getConfigProperty("moveSize");
            var itemWidth = this.cfg.getConfigProperty("itemWidth");
            var itemHeight = this.cfg.getConfigProperty("itemHeight");
            var itemSpace = this.cfg.getConfigProperty("itemSpace");
            var speed = this.cfg.getConfigProperty("speed");
            var easing = this.cfg.getConfigProperty("easing");

            var currTopPos = parseInt(Dom.getStyle(this.oContainer, "top"));
            var currLeftPos = parseInt(Dom.getStyle(this.oContainer, "left"));

            if ( this.moveDirection == this.TOP ) {
                var toTop = ( currTopPos + moveSize * (itemHeight + itemSpace) );
                attributes = { top: { to: toTop, unit: "px" } };
            } else if ( this.moveDirection == this.BOTTOM ) {
                var toBottom = ( currTopPos - moveSize * (itemHeight + itemSpace) );
                attributes = { top: { to: toBottom, unit: "px" } };
            } else if ( this.moveDirection == this.LEFT ) {
                var toLeft = ( currLeftPos + moveSize * (itemWidth + itemSpace) );
                attributes = { left: { to: toLeft, unit: "px" } };
            } else if ( this.moveDirection == this.RIGHT ) {
                var toRight = ( currLeftPos - moveSize * (itemWidth + itemSpace) );
                attributes = { left: { to: toRight, unit: "px" } };
            }

            this.anim = new YAHOO.util.Anim(this.oContainer, attributes, speed, easing);
            this.anim.onComplete.subscribe(function(e) {
                if ( self.moveDirection == self.BOTTOM || self.moveDirection == self.RIGHT ) {
                    self.prepareBRByRepeat();
                }
            });
            this.anim.animate();
        },

        /**
         * @description attribute -aar move hiideg function.
         * @method moveByAttribute
         */
        moveByRepeatBack: function(attributes) {
            var speed = this.cfg.getConfigProperty("speed");
            var easing = this.cfg.getConfigProperty("easing");

            this.anim = new YAHOO.util.Anim(this.oContainer, attributes, speed, easing);
            this.anim.animate();
        },

        /**
         * @description Tovchnuudad event-uudiig ni attach hiideg method.
         * @method initEvents
         */
        initEvents: function() {
            var self = this;
            var activeEvent = this.cfg.getConfigProperty("activeEvent");
            if ( this.cfg.getConfigProperty("upButton") != null ) {
                Event.on(Dom.get(this.cfg.getConfigProperty("upButton")), activeEvent, function(e) {
                    self.upMove();
                });
            }
            if ( this.cfg.getConfigProperty("downButton") != null ) {
                Event.on(Dom.get(this.cfg.getConfigProperty("downButton")), activeEvent, function(e) {
                    self.downMove();
                });
            }
            if ( this.cfg.getConfigProperty("nextButton") != null ) {
                Event.on(Dom.get(this.cfg.getConfigProperty("nextButton")), activeEvent, function(e) {
                    self.nextMove();
                });
            }
            if ( this.cfg.getConfigProperty("prevButton") != null ) {
                Event.on(Dom.get(this.cfg.getConfigProperty("prevButton")), activeEvent, function(e) {
                    self.prevMove();
                });
            }
        },

        /**
         * @description item-uudiin too hudulguun hiihed hangalttai esehiig shalgaj ugdug method.
         * @method _isShowButtons
         */
        _isShowButtons: function() {
            return this._items.length > this.cfg.getConfigProperty("screenSize");
        },

        /**
         * @description set up button's visible
         * @method _setVisibleOfUpButton
         * @param {Boolean} value
         */
        _setVisibleOfUpButton: function(value) {
            var upButton = this.cfg.getConfigProperty("upButton");
            Dom.setStyle(upButton, value ? "" : "none");
        },

        /**
         * @description set down button's visible
         * @method _setVisibleOfDownButton
         * @param {Boolean} value
         */
        _setVisibleOfDownButton: function(value) {
            var downButton = this.cfg.getConfigProperty("downButton");
            Dom.setStyle(downButton, "display", value ? "" : "none");
        },

        /**
         * @description set preview button's visible
         * @method _setVisibleOfPrevButton
         * @param {Boolean} value
         */
        _setVisibleOfPrevButton: function(value) {
            var prevButton = this.cfg.getConfigProperty("prevButton");
            Dom.setStyle(prevButton, "display", value ? "" : "none");
        },

        /**
         * @description set next button's visible
         * @method _setVisibleOfNextButton
         * @param {Boolean} value
         */
        _setVisibleOfNextButton: function(value) {
            var nextButton = this.cfg.getConfigProperty("nextButton");
            Dom.setStyle(nextButton, "display", value ? "" : "none");
        }
    };

})();