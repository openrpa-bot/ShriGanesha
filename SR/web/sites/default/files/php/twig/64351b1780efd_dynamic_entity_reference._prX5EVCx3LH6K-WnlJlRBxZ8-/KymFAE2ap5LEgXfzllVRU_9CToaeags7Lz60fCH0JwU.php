<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* @help_topics/dynamic_entity_reference.overview.html.twig */
class __TwigTemplate_af02f05153f63a5dbd1f1105e11b583b extends \Twig\Template
{
    private $source;
    private $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        $macros = $this->macros;
        // line 5
        echo "<h2>";
        echo t("Overview", array());
        echo "</h2>
<p>
  <a href=\"https://www.drupal.org/project/dynamic_entity_reference\" rel=\"nofollow\">
    ";
        // line 8
        echo t("Dynamic Entity Reference", array());
        // line 9
        echo "  </a>
  ";
        // line 10
        echo t("provides a field type/widget/formatter combination for Drupal 8 that allows an entity-reference field to reference more than one entity type.", array());
        // line 11
        echo "</p>
<a target=\"_blank\" rel=\"noopener noreferrer\" href=\"https://www.drupal.org/files/project-images/Screen%20Shot%202014-06-11%20at%208.00.21%20am.png\">
  <img src=\"https://www.drupal.org/files/project-images/Screen%20Shot%202014-06-11%20at%208.00.21%20am.png\" alt=\"Dynamic Entity Reference\" data-canonical-src=\"https://www.drupal.org/files/project-images/Screen%20Shot%202014-06-11%20at%208.00.21%20am.png\" style=\"max-width: 100%;\">
</a>

<h2>";
        // line 16
        echo t("Features", array());
        echo "</h2>

<p>
  ";
        // line 19
        echo t("Create a single field to hold references to Users and Nodes. Or Terms and Nodes, or all three.", array());
        // line 20
        echo "</p>

<h2>";
        // line 22
        echo t("Requirements", array());
        echo "</h2>

<p>
  ";
        // line 25
        echo t("Core field module.", array());
        // line 26
        echo "</p>

<h2>";
        // line 28
        echo t("Known problems", array());
        echo "</h2>

<p>
  ";
        // line 31
        echo t("Please use the", array());
        echo " <a href=\"https://www.drupal.org/project/issues/dynamic_entity_reference\" rel=\"nofollow\">";
        echo t("issue queue", array());
        echo "</a> ";
        echo t("to report problems.", array());
        // line 32
        echo "</p>";
    }

    public function getTemplateName()
    {
        return "@help_topics/dynamic_entity_reference.overview.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  96 => 32,  90 => 31,  84 => 28,  80 => 26,  78 => 25,  72 => 22,  68 => 20,  66 => 19,  60 => 16,  53 => 11,  51 => 10,  48 => 9,  46 => 8,  39 => 5,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/dynamic_entity_reference.overview.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\modules\\contrib\\dynamic_entity_reference\\help_topics\\dynamic_entity_reference.overview.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("trans" => 5);
        static $filters = array();
        static $functions = array();

        try {
            $this->sandbox->checkSecurity(
                ['trans'],
                [],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }
}
