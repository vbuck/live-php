$(document).ready(function() {
    $('form').on('submit',function(e) {
        e.preventDefault();
        execute($(this));
        return false;
    });
    
    $(window).on('resize',update_view);
    
    $('#livephp_input').focus();
    
    $(document).on('keydown',function(e) {        
        if(e.keyCode==13 && e.ctrlKey) {
            e.preventDefault();
            $('form').submit();
            return false;
        }
        else if(e.keyCode==83 && e.ctrlKey) {
            e.preventDefault();
            save();
            return false;
        }
        else if(e.keyCode==79 && e.ctrlKey) {
            e.preventDefault();
            $('#livephp_snippets').focus();
            return false;
        }
        else if(e.keyCode==82 && e.ctrlKey) {
            e.preventDefault();
            $('form').submit();
            return false;
        }
        else if(e.keyCode==45 && e.ctrlKey) {
            e.preventDefault();
            new_snippet();
            return false;
        }
        else if(e.keyCode==9 && e.target.id=='livephp_input') {
            e.preventDefault();
            
            var cursor=$(e.target).prop('selectionStart');
            e.target.value=e.target.value.substr(0,cursor)+'\t'+e.target.value.substr(cursor);
            
            e.target.setSelectionRange(cursor+1,cursor+1);
            
            return false;
        }
        else if(e.keyCode==77 && e.ctrlKey) {
            e.preventDefault();
            toggle_fullscreen();
            return false;
        }
    });
    
    load_all();
});

function check_name() {
    if(!$('#livephp_snippet_name').val()) {
        $('#livephp_snippet_name').focus();
        
        alert('Please give this snippet a name.');
        
        return false;
    }
    
    return true;
}

function delete_snippet(snippet) {
    if(confirm('Are you sure you want to delete this snippet?')) {
        $.post('/live-php/remove.php?file='+encodeURI(snippet),function(output) {
            $('#livephp_snippet_name').val('');
            $('#livephp_input').val('');
            $('#livephp_output').html(output);
            load_all();
        });
    }
}

function execute(form) {
    $('#livephp_output').html('Running ...');
    $.post('/live-php/run.php',form.serialize(),function(output) {
        $('#livephp_output').html(output);
    });
}

function load(snippet) {
    if(!snippet)
        return false;
    
    $('#livephp_output').html('Loading ...');
    $.get('/live-php/load.php?file='+encodeURI(snippet),function(code) {
        $('#livephp_snippet_name').val(snippet.replace(/\.php$/,''));
        $('#livephp_input').val(code).focus();
        $('#livephp_output').html('');
        get_url(true);
    });
}

function load_all() {
    $.get('/live-php/load.php',function(html) {
        $('#livephp_snippets').html('<option value="">Select One</option>').append(html);
    });
}

function get_url(noselect) {
    if(!check_name())
        return false;
    
    var key=window.btoa(unescape(encodeURIComponent($('#livephp_snippet_name').val()))),
        url=window.location.href.replace(/\/live-php\/.*$/,'/live-php/')+'load/'+key;
        
    $('#livephp_snippet_url').val(url).removeClass('hidden').show();
    
    if(!noselect)
        $('#livephp_snippet_url').focus().select();
}

function new_snippet() {
    $('#livephp_snippet_name').val('');
    $('#livephp_input').val('').focus();
    $('#livephp_snippet_url').val('').addClass('hidden');
    $('#livephp_output').html('');
}

function save() {
    if(!check_name())
        return false;
    
    $('#livephp_output').html('Saving ...');
    $.post('/live-php/save.php',$('form').serialize(),function(output) {
        $('#livephp_output').html(output);
        load_all();
    });
}

function toggle_output_view(source) {
    if(source.hasClass('icon-minus')) {
        source[0].className='icon-plus';
        $('#livephp_output').removeClass('expanded');
    }
    else {
        source[0].className='icon-minus';
        $('#livephp_output').addClass('expanded');
    }
    
    update_view();
}

function toggle_fullscreen() {
    if($('#livephp_output_wrapper').hasClass('fullscreen')) {
        $('#livephp_output_wrapper').removeClass('fullscreen');
        $(document.body).removeClass('fullscreen');
    }
    else {
        $('#livephp_output_wrapper').addClass('fullscreen');
        $(document.body).addClass('fullscreen');
    }
    
    update_view();
}

function update_view() {
    $(document.body).css('padding-bottom',$('#livephp_output_wrapper').outerHeight().toString()+'px');
}