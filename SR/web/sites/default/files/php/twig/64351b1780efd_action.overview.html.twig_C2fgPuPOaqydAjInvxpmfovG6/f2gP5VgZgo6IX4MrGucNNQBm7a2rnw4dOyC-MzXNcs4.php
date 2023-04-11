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

/* @help_topics/action.overview.html.twig */
class __TwigTemplate_d5b60bd8273846521f125c09d3e60914 extends \Twig\Template
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
        // line 8
        ob_start(function () { return ''; });
        // line 9
        echo "  ";
        echo t("Actions page", array());
        $context["actions_link_text"] = ('' === $tmp = ob_get_clean()) ? '' : new Markup($tmp, $this->env->getCharset());
        // line 11
        $context["actions_page"] = $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\help_topics\HelpTwigExtension']->getRouteLink($this->sandbox->ensureToStringAllowed(($context["actions_link_text"] ?? null), 11, $this->source), "entity.action.collection"));
        // line 12
        echo "<h2>";
        echo t("What are actions?", array());
        echo "</h2>
<p>";
        // line 13
        echo t("Actions are module-defined tasks that can be executed on the site; for example, unpublishing content, sending an email message, or blocking a user.", array());
        echo "</p>
<h2>";
        // line 14
        echo t("What are simple actions?", array());
        echo "</h2>
<p>";
        // line 15
        echo t("Simple actions do not require configuration. They are automatically available to be executed, and are always listed as available on the @actions_page.", array("@actions_page" => ($context["actions_page"] ?? null), ));
        echo "</p>
<h2>";
        // line 16
        echo t("What are advanced actions?", array());
        echo "</h2>
<p>";
        // line 17
        echo t("Advanced actions require configuration. Before they are available for listing and execution, they need to be created and configured. For example, for an action that sends e-mail, you would need to configure the e-mail address.", array());
        echo "</p>
<h2>";
        // line 18
        echo t("How are actions executed?", array());
        echo "</h2>
<p>";
        // line 19
        echo t("In the core software, actions can be executed through a <em>bulk operations form</em> added to a view; if you have the core Views module installed, see the related topic \"Managing content listings (views)\" for more information about views and bulk operations.", array());
        echo "</p>
<h2>";
        // line 20
        echo t("Configuring actions overview", array());
        echo "</h2>
<p>";
        // line 21
        echo t("The core Actions module provides a user interface for listing and configuring actions. The core Views UI module provides a user interface for creating views, which may include bulk operations forms for executing actions. See the related topics listed below for specific tasks.", array());
        echo "</p>
<h2>";
        // line 22
        echo t("Additional resources", array());
        echo "</h2>
<ul>
  <li><a href=\"https://www.drupal.org/documentation/modules/action\">";
        // line 24
        echo t("Online documentation for the Action module", array());
        echo "</a></li>
</ul>";
    }

    public function getTemplateName()
    {
        return "@help_topics/action.overview.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  93 => 24,  88 => 22,  84 => 21,  80 => 20,  76 => 19,  72 => 18,  68 => 17,  64 => 16,  60 => 15,  56 => 14,  52 => 13,  47 => 12,  45 => 11,  41 => 9,  39 => 8,);
    }

    public function getSourceContext()
    {
        return new Source("", "@help_topics/action.overview.html.twig", "C:\\xampp\\htdocs\\ShriGanesha\\SR\\web\\core\\modules\\help_topics\\help_topics\\action.overview.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = array("set" => 8, "trans" => 9);
        static $filters = array("escape" => 15);
        static $functions = array("render_var" => 11, "help_route_link" => 11);

        try {
            $this->sandbox->checkSecurity(
                ['set', 'trans'],
                ['escape'],
                ['render_var', 'help_route_link']
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
