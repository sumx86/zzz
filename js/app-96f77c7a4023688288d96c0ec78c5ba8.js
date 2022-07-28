var globalSettings = {
    'loader-ico': '<i class="fa fa-spinner fa-spin" id="spinner"></i>',
    'alert-exit': '<i id="exit-alert" class="fa fa-times"></i>',
    'psi-template': '<div class="psi"></div>',
    'psi-states': {
        'fail': 0,
        'close': 1,
        'done': 2
    },
    'color-panel': {
        'template': '<div id="color-panel" data-cl></div>',
        'palette': '<div class="palette" data-cl><div class="inner" data-cl></div></div>',
        'palettes': [
            '6f62a1', '564691', '556b2f', 'ededed', 'bababa',
            '5f7fad', '405c85', '59383a', '5c2c2e', '3b736e'
        ]
    },
    ajax: {
        'login': '/ajax/login',
        'register': '/ajax/register',
        'reset-pass': '/ajax/reset-pass',
        'search': '/ajax/search',
        'update': '/ajax/update',
        'comment': '/ajax/comment'
    },
    routes : {
        'home': '/',
        'acc': '/account/uid/',
        'members': '/members',
        'sign': '/sign-in'
    }
};

var SimpleModalEvents = {
    init: function(data) {
        $(document).on('click', data.trigger, data.handle);
        $._on(document, null, {
            keydown: function(e) {
                if( e.key.toLowerCase() == "escape" && $(data.target).hasClass('modal-active') ) {
                    $(data.trigger).click();
                }
            },
            click: function(e) {
                var target = e.target;
                if( $(data.target).hasClass('modal-active') && !target.hasAttribute(data.uniq_d)) {
                    $(data.trigger).click();
                }
            }
        }, null);
    }
};

(function($){
    $.extend(jQuery, {
        initCall: function(objectName, obj) {
            if( $.isFunction(obj.initialize) ) {
                obj.initialize.call(obj);
                if( objectName ) {
                    console.log("Running initialize function of: '" + objectName + "' object");
                }
            }
        },
        cancelEvent: function(e) {
            e.preventDefault();
            if( $.isFunction(e.stopPropagation) ) {
                e.stopPropagation();
            }
            if(e.hasOwnProperty('cancelBubble')) {
                e.cancelBubble = true;
            }
        },
        _on: function(element, delegate, fnObj, _bindObj) {
            var _type = $.type(fnObj);
            if( _type != 'object' ) {
                throw new TypeError("[jQuery._on()] Expected third argument of type `object`, `"+_type+"` was passed instead.");
            }
            $.each(fnObj, function(event, fn){
                fn = _bindObj ? fn.bind(_bindObj) : fn;
                (delegate) && $(element).on(event, delegate, fn) || $(element).on(event, fn);
            });
        },
        doAjax: function(opts, showLoading, parent) {
            var params = $.extend({
                url: '',
                async: true,
                data: {},
                type: 'post'
            }, opts);
            if( showLoading ) {
                $('#spinner').css('display', 'block');
            }
            return $.ajax(params);
        }
    });

    $._isMobile = function() {
        return /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent);
    }
    
    $.redirect = function(obj) {
        var _location;
        if( typeof obj == 'object' ) {
            _location = globalSettings.routes[obj.getAttribute('data-name')];
        } else {
            _location = obj;
        }
        return ( window.location.href = _location )|| ( window.location.assign( _location ) )
            || ( window.location.replace( _location ) );
    }
})(jQuery);
(function($) {
    $.corePlugin = $.corePlugin || {};
    $.corePlugin.alert = $.corePlugin.alert || {};
    $.corePlugin.alert.callbacks = {};
    $.corePlugin.alert.self = null;

    $.corePlugin.alert.show = function(text, obj) {
        this.init(text, obj.callback);
    }

    $.corePlugin.alert.init = function(text, callback) {
        var html = "<div id='alert-box'><div id='alert-box-text-box'><span id='text'>"+text+"</span></div><button id='alert-box-button' data-action='ok'>OK</button></div>";
        this.self = $($.parseHTML(html)[0]);
        $('body').find('div:first').append(this.self);
        this.callbacks['ok'] = callback.ok;
        this.setup();
    }

    $.corePlugin.alert.setup = function() {
        var scope = this;
        this.self.on('click', '[data-action]', this._click);
        $(document).keydown(function(event) {
            if( event.key.toLowerCase() == "escape" || event.key.toLowerCase() == "enter" ) {
                scope.self.find('[data-action]').focus().click();
            }
        });
    }

    $.corePlugin.alert._click = function(e) {
        // can't use 'this' here since it is replaced with the event target
        $.corePlugin.alert.callbacks['ok']();
    }
})(jQuery);
(function($) {
    $(document).ready(function() {
        $('.lang-img-container > img').click(function() {
            cookieUtil.create({
                    name: 'lang',
                    value: $(this).parent().attr('data-lang').toLowerCase(),
                    path: '/',
                    days: 365
                }
            );
            location = location.href;
        });
    });
})(jQuery);
(function($) {
    $(document).ready(function() {
        $('#sign-out > i:first').click(function(e) {
            $('#logout-confirmation-modal').css('display', 'flex').animate({top: 0}).promise().done(function(){
                var count = 0;
                var borderColor = '#a11443';
                var funcID = setInterval(function() {
                    if(count == 8) {
                        clearInterval(funcID);
                    } else {
                        if(borderColor == '#a11443') {
                            borderColor = '#241b44';
                        } else {
                            borderColor = '#a11443';
                        }
                        $('#logout-confirmation-modal').css('border-color', borderColor);
                    }
                    count++;
                }, 100);

                $('#confirmation-buttons > #yes > span:first').click(function() {
                    $.redirect('/ajax/logout');
                });
                $('#confirmation-buttons > #no > span:first').click(function(){
                    $('#logout-confirmation-modal').animate({'top': '-9.3%'}).css('display', 'flex');
                });
            });
        });
    });
})(jQuery);
(function($) {
    $(document).ready(function() {
        // on mouse over #677ab5
        $('#login-button').click(function() {
            $.redirect('/sign-in');
        });
        $('[data-acc]').click(function() {
            $.redirect(globalSettings.routes['acc'] + parseInt($(this).attr('data-uid')));
        });
        $('.page-item').click(function() {
            var item = $(this);
            var parent = item.parent().parent();
            var action = parent.attr('data-action');
            var redirect;
            
            if(!item.hasClass('no-redirect')) {
                var pageID = parseInt(item.find('span').first().text());
                switch(action) {
                    case "collection":
                        redirect = '/collection?page=' + pageID + '&platform=' + parent.attr('data-platform');
                        break;
                    case "members":
                        redirect = '/members?page=' + pageID;
                        break;
                }
                $.redirect(redirect);
            }
        });
    });
})(jQuery);
(function($) {
    // ps1 ps2 ps3
    $.initCall('toggle-collection-containers', {
        initialize: function() {
            $(document).on('click', '.platform', function() {
                let result = window.location.href.match(/search-game=(.*)/i)[0];
                $.redirect('/collection?page=1&platform=' + $(this).attr('id') + (result ? '&' + result : '' ));
            });
        }
    });
})(jQuery);
(function($) {
    $.initCall('comment-like-handling', {
        initialize: function() {
            $(document).on('preview-comments-loaded', this._registerLikeEvent.bind(this));
        },
        _registerLikeEvent: function() {
            var self = this;
            $('.comment-actions').find('.like-comment').click(function(e) {
                self._doUpdate(e);
            });
        },
        _doUpdate: function(e) {
            var _self  = this;
            var target = $(e.currentTarget);
            var _class = target.attr('class').split(" ");
            $.doAjax({
                url: globalSettings.ajax['update'],
                data: 'action=like&data=' + JSON.stringify({'item':parseInt(_class[_class.length - 1]),'item_type':'comment'})
            }, false)
            .done(function(jqXHR, status, req) {
                console.log('[COMMENT-LIKE-HANDLING-MODULE] -> ' + jqXHR);
                if(status == 'success') {
                    if(jqXHR.indexOf('{') == 0) {
                        var response = $.parseJSON(jqXHR);
                        if(response.hasOwnProperty('success')) {
                            _self._updateContent(response, target);
                        } else {
                            _self._handleError();
                        }
                    }
                }
            });
        },
        _updateContent: function(resp, target) {
            var response = resp.success;
            target.parent().find('span:first').text(response.result[0]['comment_likes']);
        },
        _handleError: function() {
            $("html, body").animate({scrollTop: 0}, "slow").promise().done(function() {
                $('#comment-rate-warning').css('display', 'flex').delay(2000).hide('fast');
            });
        }
    });
})(jQuery);
(function($) {
    $.initCall('comment-reply-handling', {
        initialize: function() {
            $(document).on('preview-comments-loaded', this._registerCommentActions.bind(this));
        },
        _registerCommentActions: function(e) {
            var self = this;
            $('.comment-actions').find('.reply > span:first').click(function(e) {
                if(!window._login) {
                    self._handleError();
                } else {
                    console.log('reply-login');
                }
            });
        },
        _handleError: function() {
            $("html, body").animate({scrollTop: 0}, "slow").promise().done(function() {
                $('#comment-rate-warning').css('display', 'flex').delay(2000).hide('fast');
            });
        }
    });
})(jQuery);
(function($) {
    $.initCall('preview-views-handling', {
        initialize: function() {
            $(document).on('preview-update-views', this._updateViews.bind(this));
        },
        _updateViews: function(e, data) {
            var _self = this;
            $.doAjax({
                url: globalSettings.ajax['update'],
                data: 'action=view&data=' + JSON.stringify({'item':parseInt(data.item),'item_type':'game'})
            }, false)
            .done(function(jqXHR, status, req) {
                console.log('[PREVIEW-VIEWS-HANDLING-MODULE] -> ' + jqXHR);
                if(status == 'success') {
                    if(jqXHR.indexOf('{') == 0) {
                        var response = $.parseJSON(jqXHR);
                        if(response.hasOwnProperty('success')) {
                            _self._updateContent(response, data.item);
                        }
                    }
                }
            });
        },
        _updateContent: function(resp, itemID) {
            var response = resp.success;
            var newViewsCount = response.result[0]['views'];

            $('#item-actions > #views > span > span:first').text(newViewsCount);
            $('.collection-item').each(function(index, element) {
                var id = $(element).attr('class').split(' ')[1];
                if(itemID == id) {
                    $(element).find('.collection-item-slider:first > .views:first').attr('data-count', newViewsCount);
                    $(element).find('.collection-item-slider:first > .views:first > span:first > span:first').text(newViewsCount);
                }
            });
        }
    });
})(jQuery);
(function($) {
    // ps1 ps2 ps3
    $.initCall('game-preview-control', {
        _exitElement: '#exit-preview',
        _previewContainer: '#game-preview-container',

        initialize: function() {
            var self = this;
            $(document).on('preview-comments-load', this._loadComments.bind(this));
            $(document).ready(function() {
                $(self._exitElement).click(function() {
                    $(self._previewContainer).css('display', 'none');
                    $('.comment-box, #scrolltop-caret').remove();
                    $('#comment-section').css('display', 'none');
                    $('#no-comments').css('display', 'none');
                });
                
                $('.collection-item').click(function() {
                    var id = $(this).attr('class').split(" ")[1];
                    $(self._previewContainer + " > #preview > #game-cover > img:first").attr('src', $(this).find('.cover:first > img').attr('src'));
                    $(self._previewContainer + " > #preview > #top > #inner > span").text($(this).attr('data-name'));

                    $('#item-information > #inner > #uploader > #display-name > span:first').text($(this).attr('data-uploader'));

                    $("#item-actions > #likes,#item-actions > #favourited").attr('class', 'action-button ' + id);
                    $('#item-actions > #likes > span > span:first').text($(this).find('.collection-item-slider > .likes').attr('data-count'));
                    $('#item-actions > #favourited > span > span:first').text($(this).find('.collection-item-slider > .favourited').attr('data-count'));
                    $('#item-actions > #comments > span > span:first').text($(this).find('.collection-item-slider > .comments').attr('data-count'));
                    $('#item-actions > #views > span > span:first').text($(this).find('.collection-item-slider > .views').attr('data-count'));

                    $(self._previewContainer).css('display', 'block');
                    $('#lang-container').css('z-index', '5');
                    $('#comment-section').css('display', 'block');
                    
                    $(document).trigger('preview-comments-load', [{'item':id}]);
                    $(document).trigger('preview-update-views',  [{'item':id}]);
                    $('#comment-submit').attr('data-item', id);
                });
            });
        },
        _loadComments: function(event, data) {
            var self = this;
            $.doAjax({
                url: globalSettings.ajax['comment'],
                data: 'action=load&data=' + JSON.stringify({'item':data.item})
            }, true)
            .done(function(jqXHR, status, req) {
                console.log('[GAME-PREVIEW-CONTROL-MODULE] -> ' + jqXHR);
                if(status == 'success') {
                    if(jqXHR.indexOf('{') == 0) {
                        var response = $.parseJSON(jqXHR);
                        if(response.hasOwnProperty('success')) {
                            self._updateCommentsSection(response);
                        }
                    }
                }
                $('#spinner').css('display', 'none');
            });
        },
        _updateCommentsSection: function(response) {
            var commentsData = response.success;
            if(commentsData.length <= 0) {
                $('#no-comments').css('display', 'block');
                $('#scrolltop-caret').css('display', 'none');
                return;
            }
            for(var i = 0; i < commentsData.length; i++) {
                var html = $.parseHTML("<div class='comment-box'>\
                    <div class='inner'>\
                        <div class='user-pic'>\
                            <img src='\\ps-classics\\img\\93401019.jfif'>\
                        </div>\
                        <div class='comment-info-top'>\
                            <div class='username info'>\
                                <span>"+commentsData[i]['comment']['username']+"</span>\
                            </div>\
                            <div class='comment-date info'>\
                                <span>"+commentsData[i]['comment']['date']+"</span>\
                            </div>\
                            <div class='comment-actions info'>\
                                <div class='like'>\
                                    <span><i class='fa fa-thumbs-up like-comment "+commentsData[i]['comment']['comment_id']+"' data-action='like' data-url='update'></i> <span> "+commentsData[i]['comment']['likes']+"</span></span>\
                                </div>\
                                <div class='reply'>\
                                    <span>"+commentsData[i]['comment']['reply-meta']+"</span>\
                                </div>\
                            </div>\
                        </div>\
                        <div class='comment'>\
                            <div class='inner'>\
                                <span>"+commentsData[i]['comment']['text']+"</span>\
                            </div>\
                        </div>\
                    </div>\
                </div>");
                $(html).css('display', 'block');
                $('#comment-section > #inner').append(html);
            }
            if(commentsData.length >= 2) {
                $('#comment-section > #inner').append('<i id="scrolltop-caret" class="fa fa-caret-up"></i>');
            }
            $(document).trigger('preview-comments-loaded', []);
        }
    });
})(jQuery);
(function($) {
    $.initCall('collection-item-action-buttons', {
        _parent: null,
        initialize: function() {
            var self = this;
            $(document).on('collection-item-stats-update', this._updateContent.bind(this));
            $(document).on('collection-item-stats-error', this._handleError.bind(this));
            $(document).ready(function() {
                $('.action-button:not(".no-action") > span').find('i:first').click(function(element) {
                    self._doUpdate(element);
                });
            });
        },
        _doUpdate: function(e) {
            var target = $(e.currentTarget);
            this._parent = target.parent().parent();
            $.doAjax({
                url: globalSettings.ajax['update'],
                data: 'action='+this._parent.attr('data-action') + '&data=' + JSON.stringify({'item':parseInt(this._parent.attr('class').split(" ")[1]),'item_type':'game'})
            }, false)
            .done(function(jqXHR, status, req) {
                if(status == 'success') {
                    if(jqXHR.indexOf('{') == 0) {
                        var response = $.parseJSON(jqXHR);
                        if(response.hasOwnProperty('success')) {
                            $(document).trigger('collection-item-stats-update', [{response, target}]);
                        } else {
                            $(document).trigger('collection-item-stats-error', [{response, target}]);
                        }
                    }
                }
            });
        },
        _updateContent: function(e, data) {
            var response = data.response.success;
            var collectionItemID = this._parent.attr('class').split(" ")[1];
            switch(response.action) {
                case "like":
                    var newLikesCount = response.result[0]['likes'];
                    $('#item-actions > #likes > span > span:first').text(newLikesCount);
                    $('.collection-item').each(function(index, element) {
                        var id = $(element).attr('class').split(' ')[1];
                        if(collectionItemID == id) {
                            $(element).find('.collection-item-slider:first > .likes:first').attr('data-count', newLikesCount);
                            $(element).find('.collection-item-slider:first > .likes:first > span:first > span:first').text(newLikesCount);
                        }
                    });
                    break;
                case "favourite":
                    var newFavouritedCount = response.result[0]['favourited'];
                    $('#item-actions > #favourited > span > span:first').text(newFavouritedCount);
                    $('.collection-item').each(function(index, element) {
                        var id = $(element).attr('class').split(' ')[1];
                        if(collectionItemID == id) {
                            $(element).find('.collection-item-slider:first > .favourited:first').attr('data-count', newFavouritedCount);
                            $(element).find('.collection-item-slider:first > .favourited:first > span:first > span:first').text(newFavouritedCount);
                        }
                    });
                    break;
                default:
                    break;
            }
        },
        _handleError: function(event, data) {
            var error = data.response.error;
            if(error == 'login') {
                $('#account-login-first').css('display', 'flex').delay(2000).hide('fast');
            }
        }
    });
})(jQuery);
(function($) {
    $.initCall('collection-item-post-comment', {
        initialize: function() {
            var self = this;
            $(document).ready(function() {
                $._on('#comment-submit', null, {
                    'mousedown' : function(e) {
                        $(e.currentTarget).find('i:first').css('color', 'white');
                    },
                    'mouseup' : function(e) {
                        var target = $(e.currentTarget);
                        target.find('i:first').css('color', '#fc5603');
                        $.doAjax({
                            url: globalSettings.ajax['comment'],
                            data: 'action=post&data=' + JSON.stringify({'item':target.attr('data-item'),'text':$('#collection-item-comment-input-field').val()})
                        }, false)
                        .done(function(jqXHR, status, req) {
                            console.log(jqXHR + ' -- ' + status + ' -- ' + req);
                        });
                    }
                }, self);
            });
        }
    });
})(jQuery);
(function($) {
    $.initCall('user-settings', {
        _modal: '#settings-container',
        _data: null,

        initialize: function() {
            $(document).ready(function(){
                $('#sign-out-button').click(function(e) {
                    $.redirect("/ajax/logout");
                });
            });
            SimpleModalEvents.init({'target':'#settings-container','trigger':'#user-settings-button','uniq_d':'data-gr', 'handle':this._toggleModal.bind(this)});
        },
        _toggleModal: function(e) {
            var modal = $(this._modal);
            if( !this._isActive() ) {
                modal.stop().fadeIn(200);
                modal.addClass('modal-active');
            } else {
                modal.stop().fadeOut(200);
                modal.removeClass('modal-active');
            }
        },
        _isActive: function() {return $(this._modal).hasClass('modal-active');}
    });
})(jQuery);
(function($){
    $.initCall('update-user-info', {
        _editor: '.info-edit-block',
        _active: false,

        initialize: function() {
            $(document).on('click', '[data-role="edit-user-info"]', this._toggleContentEditor.bind(this));
            $(document).on('click', '[data-role="update-user"]', this._update.bind(this));
            $(document).on('user-info-update', this.updateContent.bind(this));
        },
        _toggleContentEditor: function(e) {
            if( !this._isActiveModal() ) {
                $(this._editor).find('#inner > #content').show('fast');
                $(this._editor).find('#inner').stop().animate({'height':'420px'});
                this._active = true;
            } else {
                var _this = this;
                $(this._editor).find('#inner > #content').hide('fast');
                setTimeout(function(){
                    $(_this._editor).find('#inner').stop().animate({'height':'0px'}, 'fast');
                    _this._active = false;
                }, 200);
            }
        },
        _getInputData: function() {
            var data = {accounts: {}};
            var tempData = {};
            $('.info-field').each(function(index, element) {
                let name = element.getAttribute('name');
                if( element.getAttribute('data-role') == 'account-list-item' ) {
                    tempData = data.accounts;
                } else {
                    tempData = data;
                } tempData[name] = $(element).val();
            });
            return data;
        },
        _update: function(e) {
            var target = $(e.currentTarget);
            this._toggleSubmitLock();
            var _this = this;
            $.doAjax({url: globalSettings.ajax[target.attr('data-action')], data: JSON.stringify(this._getInputData()) + 'user-info-update'}, true, target)
            .done(function(jqXHR, status, req){
                var response = $.parseJSON(jqXHR);
                $(document).trigger('user-info-update', [{response, target}]);
            })
            .fail(function(message) {
                $.corePlugin.alert.show(message, {
                    callback: {
                        ok: function() {
                            $.redirect(window.location.href);
                        }
                    }
                }, true);
            });
        },
        updateContent: function(event, data) {
            console.log(data);
            //ui.loaderHide(data.target.parent());
            this._toggleSubmitLock();
        },
        _toggleSubmitLock: function() {
            $('[data-role="update-user"]').prop('disabled', function(e, disabled) {
                return !disabled;
            });
        },
        _isActiveModal: function() {return this._active;}
    });
})(jQuery);
(function($) {
    $.initCall('form-handling', {
        initialize: function() {
            $(window).on('load', this._initializeInputErrors.bind(this));
            $._on(document, '#login-form, #registration-form, #reset-pass-form, #comment-form', {
                submit: this._formSubmit,
            }, this);
        },
        _initializeInputErrors: function() {
            $('.input-field').each(function(i, e) {
                var self = $(this);
                var form = self.parent();
                var form_action = form.attr('data-action');
                if( form_action == 'login' || form_action == 'register' || form_action == 'reset-pass' ) {
                    var element = $.parseHTML("<span style='display: none;'>what teh cuck</span>");
                    $(element).attr('id', self.attr('name') + '-error');
                    $('#main-container').append(element);
                }
            });
        },
        _formSubmit: function(e) {
            $.cancelEvent(e);
            var form = $(e.currentTarget);
            this._toggleSubmitLock();
            this._resetInputFields(form);

            var self = this;
            $.doAjax({url: globalSettings.ajax[form.attr('data-action')], data: form.serialize()}, true, form)
            .done(function(jqXHR, status, req) {
                console.log(jqXHR);
                if( jqXHR.indexOf('{') == 0 ) {
                    var response = $.parseJSON(jqXHR);
                    if( response.hasOwnProperty('success') ) {
                        $.redirect(globalSettings.routes['home']);
                    } else {
                        self._handleError(response['input-error']);
                    }
                }
                
                $('#spinner').css('display', 'none');
                self._toggleSubmitLock();
            })
            .fail(function(message) {
                $.corePlugin.alert.show(message, {
                    callback: {
                        ok: function() {
                            $.redirect(window.location.href);
                        }
                    }
                }, true);
            });
        },
        _toggleSubmitLock: function() {
            $(document).find("[data-action='login'],[data-action='register'],[data-action='reset-pass']").each(function(i, e) {
                $(e).find('button').prop('disabled', function(e, disabled) {
                    return !disabled;
                });
            });
        },
        _handleError: function(errObj) {
            var self = this;
            if(Object.keys(errObj).length > 0) {
                $.each(errObj, function(inputName, errorText) {
                    $("input[name='"+inputName+"']").css('border', '1px solid #a11443').addClass('error');
                    if( errorText != '' ) {
                        self._showError(inputName, errorText);
                    }
                });
            }
        },
        _showError: function(inputName, errorText) {
            if(inputName.indexOf('register') >= 0) {
                var container = $('#sign-up-errors-container');
                var element = container.find('#'+inputName+'-error').first();
                element.append("<span>"+errorText+"</span><i class='fa fa-times remove-error'></i>");
                this._registerExitErrorEvent(element);
                element.css('display', 'flex');
            } else {
                $('#'+inputName+'-error').css('display', 'block').text(errorText);
            }
        },
        _registerExitErrorEvent: function(element) {
            element.find('.remove-error').click(function() {
                var self  = $(this);
                var error = self.parent();
                error.find('span').first().text('');
                error.hide('fast');
            });
        },
        _resetInputFields: function(form) {
            form.find('input').each(function(i, e) {
                var _field = $(e);
                _field.css('border', '1px solid #738399').removeClass('error'), $('#'+$(e).attr('name')+'-error').css('display', 'none').text('');
            });
        }
    });
})(jQuery);
/*(function($){
    $.initCall('password-strength-indicator', {
        _pollInterval: 100,
        _checkTimer: null,
        _tooltip: '#psi-tooltip',
        _passwordField: 'input[type="password"]',
        
        initialize: function() {
            var _this = this;
            $(window).on('load', function() {
                $._on(_this._passwordField, null, {
                    focus: _this._pollInit,
                    blur: _this._pollEnd
                }, _this);
            });
        },
        _pollInit: function(e) {
            var field = $(e.target);
            if( field.attr('data-psi') ) {
                var psi = field.attr('data-psi');
                this._pollField({field, psi});
            }
        },
        _pollField: function(fieldData) {
            this._checkTimer = setInterval(this._check, this._pollInterval, fieldData, this);
            this.showTooltip();
        },
        _pollEnd: function(field) {
            if( this._checkTimer ) {
                clearInterval(this._checkTimer);
            }
            this.hideTooltip();
        },
        showTooltip: function() {
            $(this._tooltip).stop().fadeIn('fast');
        },
        hideTooltip: function() {
            $(this._tooltip).stop().fadeOut('fast');
        },
        
        psiIndicator: {
            initialized: false,
            psi: '',
            _state: -1,

            init: function() {
                this.setup($(this.psi), globalSettings['psi-template']);
                this.initialized = true;
            },
            clearValues: function() {
                this.initialized = false;
                this.psi = '';
                //this.state = -1;
                console.log('Psi indicator terminated!');
            },
            setup: function(_psi, _template) {
                if( _psi.find('.psi').length <= 0 ) {
                    _psi.append(_template);
                    _psi.append(_template);
                    _psi.append(_template);
                }
            },
            render: function(state) {
                if( !this.initialized ) {
                    this.init();
                    console.log("Psi indicator initialized! [psi-container="+this.psi+"] [initial-state="+this._state+"]");
                }
                this.updatePsi(state);
            },
            updatePsi: function(state) {
                var _stateName = this.getStateName(state);
                var _psi = $(this.psi);
                var _this = this;
                var _psiElements = _psi.find('.psi');

                this.onStateChanged(state, function() {
                    var _index = state + 1;
                    _psiElements.slice(0, _index).map(function(index, element) {
                        _this.setState(element, _stateName);
                    });
                    _this.removePrevious(_index, _psiElements);
                });
            },
            removePrevious: function(index, elements) {
                if( index < elements.length ) {
                    elements.slice(index, elements.length).map(function(index, element) {
                        $(element).attr('class', 'psi');
                    });
                }
            },
            onStateChanged: function(state, callback) {
                if( this._state != state ) {
                    this._state = state;
                    callback();
                }
            },
            getStateName: function(state){
                var states = globalSettings['psi-states'];
                for(var _state in states) {
                    if(states[_state] === state) {
                        return _state;
                    }
                }
            },
            setState: function(element, stateName) {
                $(element).attr('class', 'psi psi-state-' + stateName);
            },
            setPsi: function(id) {
                this.psi = id;
            },
            hasPsi: function() {
                return this.psi != '';
            }
        },
        
        _check: function(fieldData, _this) {
            var fieldValue = fieldData.field.val();
            //console.log(fieldValue);
            var state;
            
            if( fieldValue.length < 15 ) {
                state = globalSettings['psi-states']['fail'];
            }
            else if( fieldValue.length >= 15 ) {
                if( !(/[0-9]/).test(fieldValue) || !(/[A-Z]/).test(fieldValue) ) {
                    state = globalSettings['psi-states']['close'];
                } else {
                    state = globalSettings['psi-states']['done'];
                }
            }

            if( !_this.psiIndicator.hasPsi() ) {
                _this.psiIndicator.setPsi('#' + fieldData.psi);
            }
            _this.psiIndicator.render(state);
        }
    });
})(jQuery);*/