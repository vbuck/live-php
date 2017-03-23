<?php define('BASE_URI', dirname($_SERVER['SCRIPT_NAME'])); ?>
<?php require_once 'config.php'; ?>
<!DOCTYPE html>
<html>
    <head>
        <title>livePHP</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" name="viewport" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URI; ?>/lib/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URI; ?>/lib/bootstrap/css/bootstrap-responsive.min.css" />
        <link rel="stylesheet" type="text/css" href="<?php echo BASE_URI; ?>/lib/base.css" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row-fluid">
                <div class="span8">
                    <h1>livePHP</h1>
                    <p class="lead">Quickly run PHP code.</p>
                </div>
                <div class="span4">
                    <h4>My Snippets</h4>
                    <select id="livephp_snippets" name="livephp[snippets]" onchange="load(this.value);"></select>
                </div>
            </div>
            <hr />
            <div class="row-fluid">
                <div class="span10">
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="livephp_snippet_name">Name</label>
                            <div class="controls">
                                <input type="text" name="livephp[snippet_name]" id="livephp_snippet_name" class="input-xlarge" />
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="livephp_input">Code</label>
                            <div class="controls">
                                <textarea name="livephp[input]" wrap="off" id="livephp_input" class="input-xxlarge" rows="20" placeholder="echo 'Hello world';"></textarea>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <div class="inner-controls">
                                    <label for="livephp_display_errors">
                                        <input type="checkbox" name="livephp[display_errors]" id="livephp_display_errors" value="1"<?php echo $config['display_errors'] ? ' checked="checked"' : ''; ?> />
                                        <span>Display Errors</span>
                                    </label>
                                </div>
                                <button type="submit" class="btn btn-info">Execute</button>
                                <button type="button" class="btn" onClick="save();">Save</button>
                                <button type="button" class="btn" onClick="delete_snippet($('#livephp_snippet_name').val());">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="span2">
                    <fieldset>
                        <legend>Shortcuts</legend>
                        <dt>New</dt>
                        <dd>Ctrl + Insert</dd>
                        <dt>Run</dt>
                        <dd>Ctrl + R</dd>
                        <dt>Save</dt>
                        <dd>Ctrl + S</dd>
                        <dt>Open</dt>
                        <dd>Ctrl + O</dd>
                        <dt>Toggle Full-Screen</dt>
                        <dd>Ctrl + M</dd>
                    </fieldset>
                    <hr />
                    <div class="control-group">
                        <div class="controls">
                            <button type="button" class="btn" onClick="get_url();">Generate URL</button>
                        </div>
                    </div>
                    <div id="url-container" class="control-group">
                        <div class="controls">
                            <input type="text" class="input-block-level hidden" id="livephp_snippet_url" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row-fluid">
                <div class="span12">
                    <div id="livephp_output_wrapper">
                        <div class="controls">
                            <i id="toggle_output_view" class="icon-plus" onclick="toggle_output_view($(this));" title="Toggle Height"></i>
                            <i id="toggle_fullscreen" class="icon-fullscreen" onclick="toggle_fullscreen();" title="Toggle Fullscreen"></i>
                        </div>
                        <h4>Output</h4>
                        <div class="well" id="livephp_output"></div>
                    </div>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php echo BASE_URI; ?>/lib/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URI; ?>/lib/bootstrap.min.js"></script>
        <script type="text/javascript" src="<?php echo BASE_URI; ?>/lib/base.js"></script>
        <?php include 'url-load.php'; ?>
        <?php if ( $config['default_snippet'] && ( empty($snippet) || !file_exists($snippet) ) ) : ?>
        <script type="text/javascript">
            load('<?php echo $config['default_snippet']; ?>', function() {
                $('#livephp_output').html('Loaded default snippet');
            });
        </script>
        <?php endif; ?>
    </body>
</html>