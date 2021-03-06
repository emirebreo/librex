
<?php
                require "misc/header.php";
                $config = require "config.php";

                function better_setcookie($name)
                {
                    if (!empty($_REQUEST[$name]))
                        setcookie($name, $_REQUEST[$name], time() + (86400 * 90));
                    else if (isset($_COOKIE[$name]))
                        setcookie($name, "", time() - 1000); 
                }

                if (isset($_REQUEST["save"]))
                {
                    better_setcookie("theme");

                    better_setcookie("disable_special");

                    better_setcookie("invidious");
                    better_setcookie("bibliogram");
                    better_setcookie("nitter");
                    better_setcookie("libreddit");
                    better_setcookie("wikiless");
                    
                    header("Location: ./settings.php");
                    die();
                }
                else if (isset($_REQUEST["reset"]))
                {
                    if (isset($_SERVER["HTTP_COOKIE"])) {
                        $cookies = explode(";", $_SERVER["HTTP_COOKIE"]);
                        foreach($cookies as $cookie) {
                            $parts = explode("=", $cookie);
                            $name = trim($parts[0]);
                            setcookie($name, "", time() - 1000);
                        }

                        header("Location: ./settings.php");
                        die();
                    }
                }
            ?>

    <title>LibreX - Settings</title>
    </head>
    <body>
        <div class="misc-container">
            <h1>Settings</h1>
            <form method="post" enctype="multipart/form-data" autocomplete="off">
              <div>
                <label for="theme">Theme:</label>
                <select name="theme">
                <?php
                    $themes = "<option value=\"dark\">Dark</option>
                    <option value=\"light\">Light</option>
                    <option value=\"auto\">Auto</option>
                    <option value=\"nord\">Nord</option>
                    <option value=\"night_owl\">Night Owl</option>
                    <option value=\"discord\">Discord</option>";

                    if (isset($_COOKIE["theme"]))
                    {
                        $cookie_theme = $_COOKIE["theme"];
                        $themes = str_replace($cookie_theme . "\"", $cookie_theme . "\" selected", $themes);
                    }

                    echo $themes;
                ?>
                </select>
                </div>
                <div>
                    <label for="special">Disable special queries (e.g.: currency conversion)</label>
                    <input type="checkbox" name="disable_special"
                    <?php echo isset($_COOKIE["disable_special"]) ? "checked"  : "\"\""; ?>
                    >
                </div>
                <h2>Privacy friendly frontends</h2>
                <p>For an example if you want to view YouTube without getting spied on, click on "Invidious", find the instance that is most suitable for you then paste it in (correct format: https://example.com)</p>
                <div class="instances-container">   
                      <div>
                        <a for="invidious" href="https://docs.invidious.io/instances/" target="_blank">Invidious</a>
                        <input type="text" name="invidious" placeholder="Replace YouTube" value=
                            <?php echo isset($_COOKIE["invidious"]) ? $_COOKIE["invidious"]  : "\"$config->invidious\""; ?>
                        >
                      </div>

                      <div>
                        <a for="bibliogram" href="https://git.sr.ht/~cadence/bibliogram-docs/tree/master/docs/Instances.md" target="_blank">Bibliogram</a>
                        <input type="text" name="bibliogram" placeholder="Replace Instagram" value=
                            <?php echo isset($_COOKIE["bibliogram"]) ? $_COOKIE["bibliogram"]  : "\"$config->bibliogram\""; ?>
                        >
                      </div>

                      <div>
                        <a for="nitter" href="https://github.com/zedeus/nitter/wiki/Instances" target="_blank">Nitter</a>
                        <input type="text" name="nitter" placeholder="Replace Twitter" value=
                            <?php echo isset($_COOKIE["nitter"]) ? $_COOKIE["nitter"]  : "\"$config->nitter\""; ?>
                        >
                      </div>

                      <div>
                        <a for="libreddit" href="https://github.com/spikecodes/libreddit" target="_blank">Libreddit</a>
                        <input type="text" name="libreddit" placeholder="Replace Reddit" value=
                            <?php echo isset($_COOKIE["libreddit"]) ? $_COOKIE["libreddit"]  : "\"$config->libreddit\""; ?>
                        >
                      </div>

                      <div>
                        <a for="wikiless" href="https://codeberg.org/orenom/wikiless" target="_blank">Wikiless</a>
                        <input type="text" name="wikiless" placeholder="Replace Wikipedia" value=
                            <?php echo isset($_COOKIE["wikiless"]) ? $_COOKIE["wikiless"]  : "\"$config->wikiless\""; ?>
                        >
                      </div>
                </div>
                <div>
                  <button type="submit" name="save" value="1">Save</button>
                  <button type="submit" name="reset" value="1">Reset</button>
                </div>
                <div>
                    <?php 
                        if (!empty($_COOKIE))
                        {
                            echo "<p>If you use the Tor browser or just regularly delete cookies you can also set the settings as a query param:</p>";

                            $url = "?";

                            foreach ($_COOKIE as $key => $value)
                                $url .= "&$key=$value";
                            
                            $url = substr_replace($url, "", 1, 1);

                            echo $url;
                        }
                    ?>
                </div>
            </form>
        </div>

<?php require "misc/footer.php"; ?>