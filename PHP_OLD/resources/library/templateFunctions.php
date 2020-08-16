<?php
    require_once(realpath(dirname(__FILE__) . "/../config.php"));

    function renderLayoutWithContentFile($contentFile, $variables = array())
    {
        $contentFileFullPath = TEMPLATES_PATH . "/" . $contentFile;

        // making sure passed in variables are in scope of the template
        // each key in the $variables array will become a variable
        if (count($variables) > 0) {
            foreach ($variables as $key => $value) {
                if (strlen($key) > 0) {
                    ${$key} = $value;
                }
            }
        }

        require_once(TEMPLATES_PATH . "/header.php");

        echo "<div class=\"container-fluid\" >\n";
        echo "\t<div class=\"row\">";

       require_once(TEMPLATES_PATH . "/leftPanel.php");

       echo "\t\t<main role=\"main\" class=\"col-md-9 ml-sm-auto col-sm-10 col-lg-10 px-4\">\n";



        if (file_exists($contentFileFullPath)) {
            require_once($contentFileFullPath);
        } else {
            /*
                If the file isn't found the error can be handled in lots of ways.
                In this case we will just include an error template.
            */
            require_once(TEMPLATES_PATH . "/error.php");
        }


        echo "\t\t</main>\n";

        echo "\t</div>\n";

        // close container div
        echo "</div>\n";

        require_once(TEMPLATES_PATH . "/footer.php");
    }
