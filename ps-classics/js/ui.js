var ui = {
    insertLink: function( field ) {
        if ( this.isTxtField( field ) ) { field.value += '[link][/link]'; }
    },
    
    transformTxt: function( type, field ) {
        if ( type == 'b' ) { 
            field.value += '[bold][/bold]';
        }
        if ( type == 'i' ) { 
            field.value += '[italic][/italic]'; 
        }
        if ( type == 'fs' ) {
            field.value += '[fsize][/fsize]';
        }
    },

    insertIcon: function( icon, field ) {
        if ( this.isTxtField( field ) ) {
            field.value += "[icon]" + icon.getAttribute('data-entity') + "[/icon]";
        }
    },

    isTxtField: function( el ) {
        return ( el.tagName.toLowerCase() !== 'input' 
              && el.tagName.toLowerCase() !== 'textarea' ) ? false : true ;
    },

    modifyInput: function( trigger, field ) {
        var mod = trigger.getAttribute('data-modify');
        switch ( mod ) {
            case 'bold'  : this.transformTxt('b', field); break;
            case 'italic': this.transformTxt('i', field); break;
            case 'link'  : this.insertLink(field); break;
        }
    },

    loaderShow: function( parent ) {
        $(parent).append(globalSettings['loader-ico']);
    },

    loaderHide: function( parent ) {
        $(parent).children('i:first').remove();
    },

    showMessage: function( parent, data ) {
        $('#custom-alert').remove();
        this.customAlert(
            parent, (data.match( /(\[msg\]=)/ ) ? data.substring( 6 ) : data), '', true
        );
    },
    
    alert: function(text, callbacks, slidedown = false) {
        if( text.length <= 0 ) {
            return;
        }
        var callbackData = $.extend({
            callbacks: {
                ok: function(){}, cancel: function(){}
            }
        }, callbacks);

        var self = this.initialize(text, callbackData);
    }
};