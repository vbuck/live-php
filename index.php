<?php

require_once 'config.php';

$_instances = array();
$_basePath  = dirname( ( dirname(__FILE__) ) );
$_dirRes    = opendir($_basePath);

while ( false !== ( $_file = readdir($_dirRes) ) ) {
    $_mageRoot  = $_basePath . DIRECTORY_SEPARATOR . $_file . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
    $_mageRoot2 = $_basePath . DIRECTORY_SEPARATOR . $_file . DIRECTORY_SEPARATOR . 'magento' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
    $_mageRoot3 = $_basePath . DIRECTORY_SEPARATOR . $_file . DIRECTORY_SEPARATOR . 'store' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';
    $_mageRoot4 = $_basePath . DIRECTORY_SEPARATOR . $_file . DIRECTORY_SEPARATOR . 'shop' . DIRECTORY_SEPARATOR . 'app' . DIRECTORY_SEPARATOR . 'Mage.php';

    if (file_exists($_mageRoot)) {
        $_instances[] = trim($_file);
    } else if (file_exists($_mageRoot2)) {
        $_instances[] = trim($_file);
    } else if (file_exists($_mageRoot3)) {
        $_instances[] = trim($_file);
    } else if (file_exists($_mageRoot4)) {
        $_instances[] = trim($_file);
    }
}

closedir($_dirRes);

?>
<!DOCTYPE html>
<html>
    <head>
        <title>livePHP</title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" name="viewport" />
        <link rel="stylesheet" type="text/css" href="/live-php/lib/bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="/live-php/lib/bootstrap/css/bootstrap-responsive.css" />
        <style>
            body.fullscreen {
                overflow: hidden;
            }
            .inner-controls {
                margin-bottom: 12px;
            }
            #livephp_input {
                font-family: 'Courier New', monospace;
                width: 95%;
                overflow: scroll;
            }
            #livephp_output_wrapper {
                position: fixed;
                padding: 1em;
                bottom: 0;
                left: 0;
                right: 0;
                background-color: #ececf0;
                box-shadow: -2px -2px 8px rgba(0,0,0,0.25);
                box-sizing: border-box;
            }
            #livephp_output_wrapper.fullscreen {
                top: 0;
                background-color: rgba(236,236,240,0.92);
            }
            #livephp_output_wrapper > .controls {
                float: right;
            }
            #livephp_output_wrapper > .controls > i {
                cursor: pointer;
                margin-right: 4px;
            }
            #livephp_output {
                position: relative;
                overflow-x: hidden;
                overflow-y: auto;
                max-height: 250px;
                margin-bottom: 0;
                background-color: #ffffff;
                box-sizing: border-box;
            }
            #livephp_output.expanded {
                max-height: 550px;
            }
            #livephp_output_wrapper.fullscreen #livephp_output {
                max-height: none;
                height: 100%;
                padding-top: 3em;
            }
            #livephp_output_wrapper.fullscreen > h4 {
                position: absolute;
                left: 1.5em;
                top: 0.75em;
                z-index: 999;
                color: #777777;
                text-shadow: 1px 1px 0px #ffffff;
            }
            #livephp_output_wrapper.fullscreen > .controls {
                position: absolute;
                right: 2.5em;
                top: 1.5em;
                z-index: 999;
            }
            #livephp_output_wrapper.fullscreen > .controls > #toggle_output_view {
                display: none;
            }
        </style>
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
                                <div class="inner-controls">
                                    <label for="livephp_use_mage">
                                        <span>Run as Magento Instance:</span>
                                    </label>
                                    <select name="livephp[use_mage]" id="livephp_use_mage">
                                        <option value="">None</option>
                                        <?php foreach ($_instances as $_instance) : ?>
                                        <option value="<?php echo $_instance; ?>"><?php echo $_instance; ?></option>
                                        <?php endforeach; ?>
                                    </select>
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
        <script type="text/javascript" src="/live-php/lib/jquery.min.js"></script>
        <script type="text/javascript" src="/live-php/lib/bootstrap.min.js"></script>
        <script type="text/javascript" src="/live-php/lib/base.js"></script>
        <?php include 'url-load.php'; ?>
    </body>
</html>